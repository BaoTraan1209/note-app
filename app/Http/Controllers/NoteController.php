<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\INoteRepository;
use App\Events\NoteUpdated;
use App\Helpers\AuthHelper;
use App\Http\Requests\Note\ShareNoteRequest;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Mail\ShareNoteMail;
use App\Models\Note;
use App\Models\NoteTag;
use App\Models\User;
use App\Queries\Note\NoteHandler;
use App\Queries\Note\NoteQuery;
use App\Services\NoteService;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $user = AuthHelper::getUser();

        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('perPage', 1000);

        $noteQuery = new NoteQuery(
            page: $page,
            perPage: $perPage,
            userId: $user->getKey(),
            keyword: $request->get('keyword', $request->get('q'))
        );

        $notes = app(NoteHandler::class)->execute($noteQuery);

        $data = [];
        $data['notes'] = $notes;
        $data['keyword'] = $request->get('keyword', $request->get('q'));
        $data['noteTags'] = $this->availableTagsFor($user->getKey());

        return view('notes.index', $data);
    }

    // View create
    public function create(Request $request):View
    {
        $user = AuthHelper::getUser();

        return view('notes.create', [
            'availableTags' => $this->availableTagsFor($user->getKey()),
        ]);
    }

    public function store(StoreNoteRequest $request): JsonResponse|RedirectResponse
    {
        $user = AuthHelper::getUser();

        $validated = $request->validated();
        $title = $validated['title'];
        $content = $validated['content'] ?? null;
        $password = $validated['password'] ?? null;
        $tags = $validated['tags'] ?? [];
        $isPinned = $request->boolean('is_pinned');
        $fontSize = (int) ($validated['font_size'] ?? 16);
        $shareEmails = $this->parseShareEmails($validated['share_emails'] ?? null);

        if (! $request->expectsJson() && $shareEmails->isNotEmpty()) {
            $registeredEmails = User::query()
                ->whereIn('email', $shareEmails)
                ->where('id', '!=', $user->getKey())
                ->pluck('email');
            $missing = $shareEmails->diff($registeredEmails);

            if ($missing->isNotEmpty()) {
                return back()
                    ->withErrors(['share_emails' => 'These emails are not registered: '.$missing->implode(', ')])
                    ->withInput();
            }
        }

        $note = app(NoteService::class)->createNote(
            title: $title,
            userId: $user->getKey(),
            content: $content,
            password: $password,
            tags: $tags,
            isPinned: $isPinned,
            fontSize: $fontSize
        );

        $imagePaths = $this->appendImages($request, $note);
        $sharedEmails = collect();

        if ($shareEmails->isNotEmpty()) {
            $sharedEmails = $this->shareCreatedNote(
                note: $note,
                emails: $shareEmails,
                permission: $validated['share_permission'] ?? 'read',
                owner: $user
            );
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note->load(['tags']),
                'saved_at' => now()->format('H:i:s'),
                'update_url' => route('notes.update', $note->id),
                'show_url' => route('notes.show', $note->id),
                'image_urls' => $this->imageUrls($imagePaths),
                'shared_emails' => $sharedEmails->values()->all(),
            ], 201);
        }

        return redirect()
            ->route('notes.index')
            ->with('success', 'Note created successfully.');
    }

    // View show
    public function show(Request $request): View
    {
        $noteId = (int) $request->route('noteId');
        $user = AuthHelper::getUser();
        $note = $this->accessibleNote($noteId, $user->getKey());

        if ($note->isLocked() && ! session()->get($this->passwordSessionKey($note))) {
            return view('notes.password', [
                'note' => $note,
                'mode' => 'unlock',
            ]);
        }

        $data = [];
        $data['note'] = $note;
        $sharedUser = $note->shareUsers->firstWhere('id', $user->getKey());
        $data['canEdit'] = $note->created_by === $user->getKey()
            || optional($sharedUser?->pivot)->permission === 'edit';
        $data['isOwner'] = $note->created_by === $user->getKey();
        $data['availableTags'] = $this->availableTagsFor((int) $note->created_by);

        return view('notes.show', $data);
    }

    public function update(UpdateNoteRequest $request): JsonResponse|RedirectResponse
    {
        $noteId = (int) $request->route('noteId');
        $user = AuthHelper::getUser();
        $existingNote = $this->editableNote($noteId, $user->getKey());

        if ($existingNote->isLocked() && ! session()->get($this->passwordSessionKey($existingNote))) {
            abort(403, 'Unlock this note before editing it.');
        }

        $validated = $request->validated();
        $title = $validated['title'];
        $content = $validated['content'] ?? null;
        $password = $validated['password'] ?? null;
        $tags = $validated['tags'] ?? [];
        $isOwner = $existingNote->created_by === $user->getKey();
        $isPinned = $isOwner ? $request->boolean('is_pinned') : (bool) $existingNote->pinned_at;
        $fontSize = (int) ($validated['font_size'] ?? $existingNote->font_size ?? 16);
        $shareEmails = $isOwner ? $this->parseShareEmails($validated['share_emails'] ?? null) : collect();

        $note = app(NoteService::class)->updateNote(
            noteId: $noteId,
            title: $title,
            content: $content,
            password: $password,
            tags: $tags,
            isPinned: $isPinned,
            fontSize: $fontSize,
            userId: $user->getKey()
        );

        $imagePaths = $this->appendImages($request, $note);
        if ($imagePaths->isEmpty()) {
            $this->pruneImagesMissingFromContent($note);
        }
        $note->load(['tags']);
        $sharedEmails = collect();

        if ($shareEmails->isNotEmpty()) {
            $sharedEmails = $this->shareCreatedNote(
                note: $note,
                emails: $shareEmails,
                permission: $validated['share_permission'] ?? 'read',
                owner: $user
            );
        }

        try {
            $pendingBroadcast = broadcast(new NoteUpdated($note, $user->getKey()));
            $pendingBroadcast->toOthers();
            unset($pendingBroadcast);
        } catch (\Throwable $exception) {
            report($exception);
        }

        if (! $request->expectsJson()) {
            return redirect()
                ->route('notes.show', $note->id)
                ->with('status', 'Note saved.');
        }

        return response()->json([
            'success' => true,
            'note' => $note,
            'saved_at' => now()->format('H:i:s'),
            'image_urls' => $this->imageUrls($imagePaths),
            'shared_emails' => $sharedEmails->values()->all(),
        ]);
    }

    public function togglePin(Request $request): JsonResponse|RedirectResponse
    {
        $noteId = (int) $request->route('noteId');
        $user = AuthHelper::getUser();
        $note = app(NoteService::class)->togglePin($noteId, $user->getKey());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'pinned' => (bool) $note->pinned_at,
                'saved_at' => now()->format('H:i:s'),
            ]);
        }

        return back()->with('status', $note->pinned_at ? 'Note pinned.' : 'Note unpinned.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $noteId = (int) $request->route('noteId');
        $user = AuthHelper::getUser();
        $note = app(INoteRepository::class)->findUserNoteById($noteId, $user->getKey());

        if ($note->isLocked() && ! session()->get($this->passwordSessionKey($note))) {
            return redirect()->route('notes.password.unlock-form', $note->id);
        }

        app(NoteService::class)->deleteNote($noteId, $user->getKey());

        return redirect()
            ->route('notes.index')
            ->with('status', 'Note deleted.');
    }

    protected function accessibleNote(int $noteId, int $userId): Note
    {
        return Note::query()
            ->where(function ($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->orWhereHas('shareUsers', fn ($share) => $share->where('users.id', $userId));
            })
            ->with(['tags', 'shareUsers'])
            ->findOrFail($noteId);
    }

    protected function editableNote(int $noteId, int $userId): Note
    {
        return Note::query()
            ->where(function ($query) use ($userId) {
                $query->where('created_by', $userId)
                    ->orWhereHas('shareUsers', fn ($share) => $share
                        ->where('users.id', $userId)
                        ->where('note_shares.permission', 'edit'));
            })
            ->with(['tags', 'shareUsers'])
            ->findOrFail($noteId);
    }

    protected function passwordSessionKey(Note $note): string
    {
        return "notes.{$note->id}.unlocked";
    }

    protected function appendImages(Request $request, Note $note): Collection
    {
        if (! $request->hasFile('images')) {
            return collect();
        }

        $paths = collect($request->file('images'))
            ->filter()
            ->map(fn ($image) => $image->store('note-images', 'public'))
            ->filter()
            ->values();

        if ($paths->isEmpty()) {
            return collect();
        }

        $note->forceFill([
            'images' => collect($note->images ?? [])
                ->merge($paths)
                ->values()
                ->all(),
        ])->save();

        return $paths;
    }

    protected function imageUrls(Collection $paths): array
    {
        return $paths
            ->map(fn ($path) => asset('storage/'.$path))
            ->values()
            ->all();
    }

    protected function pruneImagesMissingFromContent(Note $note): void
    {
        $images = collect($note->images ?? []);

        if ($images->isEmpty()) {
            return;
        }

        $content = (string) $note->content;
        $keptImages = $images
            ->filter(fn ($path) => str_contains($content, asset('storage/'.$path)))
            ->values();

        if ($keptImages->count() !== $images->count()) {
            $note->forceFill(['images' => $keptImages->all()])->save();
        }
    }

    public function shared(): View
    {
        $user = AuthHelper::getUser();

        $notes = Note::query()
            ->whereHas('shareUsers', fn ($share) => $share->where('users.id', $user->getKey()))
            ->with([
                'tags',
                'users',
                'shareUsers' => fn ($share) => $share->where('users.id', $user->getKey()),
            ])
            ->orderByDesc('updated_at')
            ->get();

        return view('notes.shared', [
            'notes' => $notes,
        ]);
    }

    public function shareEdit(Request $request): View
    {
        $note = $this->ownedNote((int) $request->route('noteId'));

        return view('notes.share', [
            'note' => $note,
            'shareUsers' => $note->shareUsers,
        ]);
    }

    public function share(ShareNoteRequest $request): RedirectResponse
    {
        $user = AuthHelper::getUser();
        $note = $this->ownedNote((int) $request->route('noteId'));
        $validated = $request->validated();
        $emails = $this->parseShareEmails($validated['emails'] ?? null);

        if ($emails->isEmpty()) {
            return back()
                ->withErrors(['emails' => 'Please enter at least one recipient email.'])
                ->withInput();
        }

        $shareUsers = User::query()
            ->whereIn('email', $emails)
            ->where('id', '!=', $user->getKey())
            ->get();

        $registeredEmails = $shareUsers->pluck('email')->map(fn ($email) => strtolower($email));
        $missing = $emails->diff($registeredEmails);

        if ($missing->isNotEmpty()) {
            return back()
                ->withErrors(['emails' => 'These emails are not registered: '.$missing->implode(', ')])
                ->withInput();
        }

        $this->shareCreatedNote(
            note: $note,
            emails: $emails,
            permission: $validated['permission'],
            owner: $user
        );

        return back()->with('status', 'Note shared successfully.');
    }

    public function updateShare(Request $request): RedirectResponse
    {
        $note = $this->ownedNote((int) $request->route('noteId'));
        $validated = $request->validate([
            'permission' => 'required|in:read,edit',
        ]);

        $shareUser = $note->shareUsers
            ->first(fn ($shareUser) => (int) $shareUser->pivot->id === (int) $request->route('shareId'));

        abort_if(! $shareUser, 404);

        $note->shareUsers()->updateExistingPivot($shareUser->getKey(), [
            'permission' => $validated['permission'],
        ]);

        return back()->with('status', 'Sharing permission updated.');
    }

    public function destroyShare(Request $request): RedirectResponse
    {
        $note = $this->ownedNote((int) $request->route('noteId'));
        $shareUser = $note->shareUsers
            ->first(fn ($shareUser) => (int) $shareUser->pivot->id === (int) $request->route('shareId'));

        abort_if(! $shareUser, 404);

        $note->shareUsers()->detach($shareUser->getKey());

        return back()->with('status', 'Shared access revoked.');
    }

    protected function ownedNote(int $noteId): Note
    {
        return Note::query()
            ->where('created_by', AuthHelper::getUser()->getKey())
            ->with(['shareUsers'])
            ->findOrFail($noteId);
    }

    protected function availableTagsFor(int $userId): Collection
    {
        return NoteTag::query()
            ->where('created_by', $userId)
            ->whereHas('notes', fn ($query) => $query->where('notes.created_by', $userId))
            ->orderBy('name')
            ->get();
    }

    protected function shareCreatedNote(Note $note, Collection $emails, string $permission, User $owner): Collection
    {
        $shareUsers = User::query()
            ->whereIn('email', $emails)
            ->where('id', '!=', $owner->getKey())
            ->get();
        $sharedEmails = collect();

        foreach ($shareUsers as $shareUser) {
            $alreadyShared = $note->shareUsers()
                ->where('users.id', $shareUser->getKey())
                ->exists();

            $note->shareUsers()->syncWithoutDetaching([
                $shareUser->getKey() => [
                    'owner_id' => $owner->getKey(),
                    'permission' => $permission,
                ],
            ]);

            $note->shareUsers()->updateExistingPivot($shareUser->getKey(), [
                'owner_id' => $owner->getKey(),
                'permission' => $permission,
            ]);

            if (! $alreadyShared) {
                Mail::to($shareUser->email)->send(new ShareNoteMail(
                    note: $note,
                    senderName: $owner->display_name ?: $owner->name ?: $owner->email,
                    noteUrl: route('notes.show', $note->getKey()),
                    permission: $permission
                ));
            }

            $sharedEmails->push($shareUser->email);
        }

        return $sharedEmails;
    }

    protected function parseShareEmails(?string $emails): Collection
    {
        return collect(preg_split('/[\s,;]+/', $emails ?? '') ?: [])
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter()
            ->unique()
            ->values();
    }
}


