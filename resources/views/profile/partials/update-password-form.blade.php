<section class="space-y-6">
    <header class="profile-card__header">
        <div class="profile-card__heading">
            <div class="profile-card__icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-slate-900">
                    {{ __('Update Password') }}
                </h2>

                <p class="mt-1 text-sm text-slate-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
        </div>
        <div class="profile-card__badge profile-card__badge--muted">
            <i class="bi bi-lock-fill me-1"></i>
            {{ __('Security') }}
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-semibold text-slate-700" />
            <div class="profile-card__input-wrap">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="profile-card__input mt-0" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-semibold text-slate-700" />
            <div class="profile-card__input-wrap">
                <x-text-input id="update_password_password" name="password" type="password" class="profile-card__input mt-0" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-slate-700" />
            <div class="profile-card__input-wrap">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="profile-card__input mt-0" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="profile-card__footer">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <x-primary-button class="profile-action-btn profile-action-btn--primary">
                    <i class="bi bi-shield-lock me-2"></i>
                    {{ __('Save') }}
                </x-primary-button>

                @if (session('status') === 'password-updated')
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
