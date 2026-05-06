<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use App\Services\LabelService;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function createView(Request $request): View
    {
        $labels = app(LabelService::class)->getAllLabels(Auth::id());
        return view('notes.create', ['labels' => $labels]);
    }

    public function index(Request $request): View
    {
        $keyword = $request->get('keyword');
        $labelId = $request->get('labelId');
        $service = app(NoteService::class);

        if ($keyword) {
            $notes = $service->search(
                Auth::id(),
                $keyword
            );
        } else {
            $notes = $service->getAllNotes(
                Auth::id()
            );
        }

        $data = [];
        $data['notes'] = $notes;
        $data['keyword'] = $keyword;

        return view('notes.index', $data);
    }

    public function show(Request $request): View
    {
        $noteId = $request->route('noteId');
        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $data = [];
        $data['note'] = $note;
        return view('notes.show', $data);
    }

    public function store(StoreNoteRequest $request)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $labelIds = $request->get('labels', []);
        $service = app(NoteService::class);

        $service->createNote(
            title: $title,
            userId: Auth::id(),
            content: $content,
            labelIds: $labelIds
        );

        return redirect()->route('notes.index');
    }

    public function edit(Request $request): View
    {
        $noteId = $request->route('noteId');
        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $labels = app(LabelService::class)->getAllLabels(Auth::id());

        $data = [];
        $data['note'] = $note;
        $data['labels'] = $labels;

        return view('notes.edit', $data);
    }

    public function update(StoreNoteRequest $request): \Illuminate\Http\RedirectResponse
    {
        $noteId = $request->route('noteId');

        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $service = app(NoteService::class);

        $service->update(
            note: $note,
            title: $request->get('title'),
            content: $request->get('content'),
            labelIds: $request->get('labels', [])
        );

        return redirect()->route('notes.index');
    }

    public function destroy(Request $request)
    {
        $noteId = $request->route('noteId');
        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $service = app(NoteService::class);
        $service->delete($note);
        return redirect()->route('notes.index');
    }

    public function pin(Request $request)
    {
        $noteId = $request->route('noteId');

        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $service = app(NoteService::class);
        $service->pin($note);
        return redirect()->back();
    }

    public function unpin(Request $request)
    {
        $noteId = $request->route('noteId');

        $note = app(NoteService::class)->findById($noteId);

        if (!$note) {
            abort(404);
        }

        if ($note->created_by !== Auth::id()) {
            abort(403);
        }

        $service = app(NoteService::class);

        $service->unpin($note);

        return redirect()->back();
    }

}
