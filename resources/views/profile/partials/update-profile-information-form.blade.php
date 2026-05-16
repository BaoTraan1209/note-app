<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="auth-form" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="profile-avatar-row">
            <div class="avatar avatar-large">
                @if ($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }} avatar">
                @else
                    {{ $user->initials() }}
                @endif
            </div>
            <div class="field">
                <label for="avatar">Avatar</label>
                <label class="profile-file-picker" for="avatar">
                    <i class="bi bi-image"></i>
                    <span>Choose file</span>
                    <small data-file-name>No file selected</small>
                </label>
                <input class="profile-file-input" id="avatar" name="avatar" type="file" accept="image/*" data-profile-file-input>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="field">
            <label for="display_name">Display name</label>
            <input class="compact-input" id="display_name" name="display_name" type="text" value="{{ old('display_name', $user->display_name) }}" placeholder="Name shown in the app">
            <x-input-error class="mt-2" :messages="$errors->get('display_name')" />
        </div>

        <div class="field">
            <label for="name">Account name</label>
            <input class="compact-input" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input class="compact-input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="verify-email-button" type="submit">
                            <i class="bi bi-envelope-check"></i>
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="action-row">
            <button class="btn-primary" type="submit"><i class="bi bi-check-lg"></i> Save profile</button>

            @if (session('status') === 'Profile updated')
                <p class="muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
