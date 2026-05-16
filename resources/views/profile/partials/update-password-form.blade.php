<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="auth-form">
        @csrf
        @method('put')

        <div class="field">
            <label for="update_password_current_password">Current password</label>
            <input class="compact-input" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="field">
            <label for="update_password_password">New password</label>
            <input class="compact-input" id="update_password_password" name="password" type="password" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="field">
            <label for="update_password_password_confirmation">Confirm password</label>
            <input class="compact-input" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="action-row">
            <button class="btn-primary" type="submit"><i class="bi bi-key"></i> Change password</button>

            @if (session('status') === 'Password updated')
                <p class="muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
