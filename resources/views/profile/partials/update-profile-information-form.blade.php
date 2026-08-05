<section class="space-y-6">
    <header class="profile-card__header">
        <div class="profile-card__heading">
            <div class="profile-card__icon">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    {{ __('Profile Information') }}
                </h2>

                <p class="mt-1 text-sm text-slate-600">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </div>
        </div>
        <div class="profile-card__badge">
            {{ __('Info') }}
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="grid gap-5 md:grid-cols-2">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-slate-700" />
                <div class="profile-card__input-wrap">
                    <x-text-input id="name" name="name" type="text" class="profile-card__input mt-0" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
                <div class="profile-card__input-wrap">
                    <x-text-input id="email" name="email" type="email" class="profile-card__input mt-0" :value="old('email', $user->email)" required autocomplete="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                <p class="text-sm text-amber-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="ml-1 font-medium underline transition hover:text-amber-900">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-emerald-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="profile-card__footer">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <x-primary-button class="profile-action-btn profile-action-btn--primary">
                    <i class="bi bi-check2-circle me-2"></i>
                    {{ __('Save') }}
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-slate-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>
