<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            $this->markUserAsActived($request);

            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            $this->markUserAsActived($request);

            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }

    protected function markUserAsActived(EmailVerificationRequest $request): void
    {
        if (! Schema::hasColumn('users', 'actived_at')) {
            return;
        }

        if ($request->user()->actived_at) {
            return;
        }

        $request->user()->forceFill([
            'actived_at' => $request->user()->freshTimestamp(),
        ])->save();
    }
}
