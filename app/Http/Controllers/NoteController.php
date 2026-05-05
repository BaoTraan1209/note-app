<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function createView(Request $request):View
    {
        return view('notes.create');
    }

    public function index(Request $request):View
    {
        $notes = app(NoteService::class)->getAll();
        $data = [];
        $data['notes'] = $notes;
        return view('notes.index', $data);
    }

    public function show(Request $request): View
    {
        $noteId = $request->route('noteId');
        $note = app(NoteService::class)->findById($noteId);

        $data = [];
        $data['note'] = $note;
        return view('notes.show', $data);
    }

    public function store(Request $request):View
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $service = app(NoteService::class);
        $data = [];
        return view('notes.index', $data);
    }
}
