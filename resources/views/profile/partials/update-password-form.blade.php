<section class="profile-section">
    <header class="profile-card__header">
        <div class="profile-card__heading">
            <div class="profile-card__icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <h2 class="profile-card__title">
                    Keamanan Akun
                </h2>

                <p class="profile-card__description">
                    Gunakan password yang kuat untuk menjaga keamanan akun Anda.
                </p>
            </div>
        </div>
        <div class="profile-card__badge profile-card__badge--muted">
            <i class="bi bi-lock-fill me-1"></i>
            {{ __('Security') }}
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')

        <div class="profile-field">
            <x-input-label for="update_password_current_password" value="Password Saat Ini" />
            <div class="profile-card__input-wrap">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="profile-card__input mt-0" autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="profile-field">
            <x-input-label for="update_password_password" value="Password Baru" />
            <div class="profile-card__input-wrap">
                <x-text-input id="update_password_password" name="password" type="password" class="profile-card__input mt-0" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="profile-field">
            <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password Baru" />
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
                    <p class="profile-save-status"><i class="bi bi-check-circle-fill me-1"></i>Password berhasil diperbarui.</p>
                @endif
            </div>
        </div>
    </form>
</section>
