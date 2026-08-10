<section class="profile-section">
    <header class="profile-card__header">
        <div class="profile-card__heading">
            <div class="profile-card__icon">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div>
                <h2 class="profile-card__title">
                    Informasi Profil
                </h2>

                <p class="profile-card__description">
                    Kelola nama dan alamat email yang digunakan pada akun Anda.
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

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="profile-form-grid">
            <div class="profile-field">
                <x-input-label for="name" value="Nama Lengkap" />
                <div class="profile-card__input-wrap">
                    <x-text-input id="name" name="name" type="text" class="profile-card__input mt-0" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="profile-field">
                <x-input-label for="email" value="Email" />
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
                    <p class="profile-save-status"><i class="bi bi-check-circle-fill me-1"></i>Profil berhasil disimpan.</p>
                @endif
            </div>
        </div>
    </form>
</section>
