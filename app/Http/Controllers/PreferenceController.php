<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PreferenceController extends Controller
{
    public function edit(Request $request): View
    {
        return view('preferences.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:light,dark'],
            'default_view' => ['required', 'in:grid,list'],
        ]);

        $request->user()->forceFill([
            'preferences' => $validated,
        ])->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'preferences' => $validated,
            ]);
        }

        return back()->with('status', 'Preferences updated.');
    }
}
