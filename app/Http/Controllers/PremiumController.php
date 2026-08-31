<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PremiumController extends Controller
{
    /**
     * User mengajukan upgrade premium — simpan bukti, set pending, tunggu admin.
     */
    public function confirmPayment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'premium_level' => ['required', 'integer', Rule::in([2, 3])],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.mimes'    => 'Bukti pembayaran harus berupa file JPG, PNG, atau PDF.',
            'payment_proof.max'      => 'Ukuran file bukti pembayaran maksimal 5 MB.',
        ]);

        $user  = $request->user();
        $level = (int) $data['premium_level'];

        if ($level <= $user->premium_level) {
            return back()->with('error', 'Paket yang dipilih sudah aktif atau lebih rendah dari paket Anda saat ini.');
        }

        if ($user->premium_pending_level) {
            return back()->with('error', 'Pengajuan Anda sebelumnya masih dalam proses verifikasi. Silakan tunggu konfirmasi dari admin.');
        }

        $path = $request->file('payment_proof')
            ->store("payment-proofs/{$user->id}", 'local');

        $user->update([
            'premium_pending_level' => $level,
            'premium_proof_path'    => $path,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Paket Anda akan diaktifkan setelah diverifikasi oleh admin (1×24 jam).');
    }

    /**
     * Admin melihat file bukti pembayaran.
     */
    public function viewProof(User $user)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        abort_unless($user->premium_proof_path, 404);

        $path = storage_path('app/' . $user->premium_proof_path);
        abort_unless(file_exists($path), 404);

        return response()->file($path);
    }

    /**
     * Admin menyetujui pengajuan premium user.
     */
    public function approvePremium(Request $request, User $user): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        if (! $user->premium_pending_level) {
            return back()->with('error', 'Tidak ada pengajuan premium yang menunggu untuk user ini.');
        }

        $user->update([
            'premium_level'         => $user->premium_pending_level,
            'premium_pending_level' => null,
            'premium_proof_path'    => null,
        ]);

        return back()->with('success', "Premium {$user->premium_level} berhasil diaktifkan untuk {$user->name}.");
    }

    /**
     * Admin menolak pengajuan premium user.
     */
    public function rejectPremium(Request $request, User $user): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $user->update([
            'premium_pending_level' => null,
            'premium_proof_path'    => null,
        ]);

        return back()->with('success', "Pengajuan premium {$user->name} berhasil ditolak.");
    }
}
