<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\INoteRepository;
use App\Helpers\AuthHelper;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Queries\Note\NoteHandler;
use App\Queries\Note\NoteQuery;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $user = AuthHelper::getUser();

        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('perPage', 10);

        $noteQuery = new NoteQuery(
            page: $page,
            perPage: $perPage,
            userId: $user->getKey()
        );

        $notes = app(NoteHandler::class)->execute($noteQuery);

        $data = [];
        $data['notes'] = $notes;
        return view('notes.index', $data);
    }

    // View create
    public function create(Request $request):View
    {
        return view('notes.create');
    }

    public function store(StoreNoteRequest $request): RedirectResponse
    {
        $user = AuthHelper::getUser();

        $validated = $request->validated();
        $title = $validated['title'];
        $content = $validated['content'] ?? null;
        $password = $validated['password'] ?? null;
        $tags = $validated['tags'] ?? [];

        app(NoteService::class)->createNote(
            title: $title,
            userId: $user->getKey(),
            content: $content,
            password: $password,
            tags: $tags
        );

        return redirect()
            ->route('notes.index')
            ->with('success', 'Note created successfully.');
    }

    // View show
    public function show(Request $request): View
    {
        $noteId = (int) $request->route('noteId');
        $note = app(INoteRepository::class)->findById($noteId);

        $data = [];
        $data['note'] = $note;

        return view('notes.show', $data);
    }

    public function update(UpdateNoteRequest $request): JsonResponse
    {
        $noteId = (int) $request->route('noteId');

        $validated = $request->validated();
        $title = $validated['title'];
        $content = $validated['content'] ?? null;
        $password = $validated['password'] ?? null;
        $tags = $validated['tags'] ?? [];

        $note = app(NoteService::class)->updateNote(
            noteId: $noteId,
            title: $title,
            content: $content,
            password: $password,
            tags: $tags
        );

        return $this->sendSuccessResponse([$note]);
    }
}
