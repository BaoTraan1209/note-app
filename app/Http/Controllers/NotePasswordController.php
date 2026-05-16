<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class NotePasswordController extends Controller
{
    public function edit(Request $request, int $noteId): View
    {
        $note = $this->ownedNote($request, $noteId);

        return view('notes.password', [
            'note' => $note,
            'mode' => 'manage',
        ]);
    }

    public function unlockForm(Request $request, int $noteId): View
    {
        $note = $this->accessibleNote($request, $noteId);

        return view('notes.password', [
            'note' => $note,
            'mode' => 'unlock',
        ]);
    }

    public function unlock(Request $request, int $noteId): RedirectResponse
    {
        $note = $this->accessibleNote($request, $noteId);

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
        ]);

        if (! Hash::check($validated['current_password'], $note->password)) {
            return back()->withErrors(['current_password' => 'The note password is incorrect.']);
        }

        session()->put($this->sessionKey($note), true);

        return redirect()->route('notes.show', $note->id);
    }

    public function update(Request $request, int $noteId): RedirectResponse
    {
        $note = $this->ownedNote($request, $noteId);

        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        if ($note->isLocked()) {
            $rules['current_password'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        if ($note->isLocked() && ! Hash::check($validated['current_password'], $note->password)) {
            return back()->withErrors(['current_password' => 'The current note password is incorrect.']);
        }

        $note->forceFill([
            'password' => $validated['password'],
        ])->save();

        session()->put($this->sessionKey($note), true);

        return redirect()->route('notes.show', $note->id)->with('status', 'Note password saved.');
    }

    public function destroy(Request $request, int $noteId): RedirectResponse
    {
        $note = $this->ownedNote($request, $noteId);

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
        ]);

        if (! Hash::check($validated['current_password'], $note->password)) {
            return back()->withErrors(['current_password' => 'The current note password is incorrect.']);
        }

        $note->forceFill(['password' => null])->save();
        session()->forget($this->sessionKey($note));

        return redirect()->route('notes.show', $note->id)->with('status', 'Password protection disabled.');
    }

    protected function ownedNote(Request $request, int $noteId): Note
    {
        return Note::query()
            ->where('created_by', $request->user()->id)
            ->with(['tags', 'shareUsers'])
            ->findOrFail($noteId);
    }

    protected function accessibleNote(Request $request, int $noteId): Note
    {
        return Note::query()
            ->where(function ($query) use ($request) {
                $query->where('created_by', $request->user()->id)
                    ->orWhereHas('shareUsers', fn ($share) => $share->where('users.id', $request->user()->id));
            })
            ->with(['tags', 'shareUsers'])
            ->findOrFail($noteId);
    }

    protected function sessionKey(Note $note): string
    {
        return "notes.{$note->id}.unlocked";
    }
}
