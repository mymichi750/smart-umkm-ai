<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <p class="text-uppercase fw-bold mb-2 profile-page__eyebrow">
                    {{ __('Account Settings') }}
                </p>
                <h2 class="h2 mb-0 text-dark">
                    {{ __('Profile') }}
                </h2>
            </div>
            <div class="profile-page__pill">
                {{ ucfirst($user->role ?? 'User') }}
            </div>
        </div>
    </x-slot>

    <div class="py-4 py-lg-5">
        <div class="mx-auto" style="max-width: 1280px;">
            <div class="profile-shell">
                <div class="profile-hero">
                    <div class="profile-hero__glow"></div>
                    <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between gap-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="mb-1 fw-semibold">{{ $user->name }}</h3>
                                <p class="mb-0 text-white-50">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="profile-chip"><i class="bi bi-shield-check me-2"></i>{{ __('Secure') }}</span>
                            <span class="profile-chip"><i class="bi bi-stars me-2"></i>{{ __('Premium') }}</span>
                        </div>
                    </div>

                    <div class="row g-3 mt-4">
                        <div class="col-sm-6 col-lg-3">
                            <div class="profile-stat-card">
                                <div class="profile-stat-icon"><i class="bi bi-person-badge"></i></div>
                                <div>
                                    <small class="text-white-50">{{ __('Role') }}</small>
                                    <h6 class="mb-0 mt-1">{{ ucfirst($user->role ?? 'User') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="profile-stat-card">
                                <div class="profile-stat-icon"><i class="bi bi-check-circle"></i></div>
                                <div>
                                    <small class="text-white-50">{{ __('Status') }}</small>
                                    <h6 class="mb-0 mt-1">{{ __('Active') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="profile-stat-card">
                                <div class="profile-stat-icon"><i class="bi bi-envelope-check"></i></div>
                                <div>
                                    <small class="text-white-50">{{ __('Email') }}</small>
                                    <h6 class="mb-0 mt-1">{{ __('Verified') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="profile-stat-card">
                                <div class="profile-stat-icon"><i class="bi bi-clock-history"></i></div>
                                <div>
                                    <small class="text-white-50">{{ __('Updated') }}</small>
                                    <h6 class="mb-0 mt-1">{{ __('Just now') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-0">
                    <div class="col-12 col-xl-7">
                        <div class="profile-panel h-100">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="col-12 col-xl-5">
                        <div class="profile-panel h-100">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="profile-danger-zone">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
