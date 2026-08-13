<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PremiumController extends Controller
{
    public function confirmPayment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'premium_level' => ['required', 'integer', Rule::in([2, 3])],
        ]);

        $user = $request->user();
        $level = (int) $data['premium_level'];

        if ($level <= $user->premium_level) {
            return back()->with('error', 'Paket yang dipilih sudah aktif atau lebih rendah dari paket Anda saat ini.');
        }

        // Konfirmasi manual: ganti dengan callback payment gateway saat QRIS sudah terintegrasi.
        $user->update(['premium_level' => $level]);

        return back()->with('success', "Pembayaran QRIS dikonfirmasi. Akun Anda sekarang Premium {$level}.");
    }
}
