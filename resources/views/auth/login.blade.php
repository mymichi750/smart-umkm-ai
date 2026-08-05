<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-login-form">
        @csrf

        <div class="mb-4 text-center d-none d-lg-block">
            <h2 class="h4 fw-bold mb-2">Masuk ke Akun Anda</h2>
            <p class="text-muted mb-0">Gunakan email dan password Anda untuk masuk ke dashboard bisnis.</p>
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="form-label" />
            <x-text-input id="email" class="form-control form-control-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="form-label" />
            <x-text-input id="password" class="form-control form-control-lg" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-sm text-primary" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            @endif
        </div>

        <div class="d-grid mb-3">
            <x-primary-button class="btn btn-brand btn-lg w-100">{{ __('Log in') }}</x-primary-button>
        </div>

        <p class="text-center text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar sekarang</a></p>
    </form>
</x-guest-layout>
