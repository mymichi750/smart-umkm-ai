<section class="space-y-5">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                {{ __('Delete Account') }}
            </h2>

            <p class="mt-1 text-sm text-slate-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </div>
        <div class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-rose-600">
            {{ __('Danger') }}
        </div>
    </div>

    <div class="rounded-2xl border border-rose-200 bg-white/80 p-4">
        <p class="text-sm text-slate-600">
            {{ __('Tindakan ini bersifat permanen. Pastikan Anda benar-benar ingin melanjutkan.') }}
        </p>
    </div>

    <button type="button" class="btn btn-danger rounded-3 px-4 py-2" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        <i class="bi bi-trash3 me-2"></i>{{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h2 class="modal-title fs-5 fw-semibold" id="confirmUserDeletionLabel">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="modal-body pt-3">
                        <p class="text-muted mb-3">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <label for="delete_account_password" class="form-label fw-semibold">{{ __('Password') }}</label>

                        <input id="delete_account_password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Password') }}" required autocomplete="current-password">

                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3 me-2"></i>{{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('confirmUserDeletion')).show();
            });
        </script>
    @endif
</section>
