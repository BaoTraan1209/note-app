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
    public function index(Request $request): View
    {
        return view('notes.index');
    }

    public function createView(Request $request):View
    {
        return view('notes.create');
    }

    public function store(Request $request): View
    {
        $title = $request->get('title');
        $content = $request->get('content');

        // Controller -> Service xu ly logic
        $service = app(NoteService::class);

        $data = [];
        return view('notes.index', $data);
    }
}
