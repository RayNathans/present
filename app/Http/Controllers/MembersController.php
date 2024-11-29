<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pelanggans = null;
        $message = null;

        if ($request->has('search')) {
            if (empty($search)) {
                // Jika tombol search ditekan tanpa input
                $message = "Silakan masukkan Nomor Anda.";
            } elseif (strlen($search) < 12) {
                // Jika inputan kurang dari 12 karakter
                $message = "Nomor yang Anda masukkan terlalu pendek. Minimal 12 karakter.";
            } else {
                // Jika ada input pada pencarian dan panjangnya cukup
                $pelanggans = Pelanggan::with('member')
                    ->where('noWA', 'like', '%' . $search . '%')
                    ->get();

                // Jika tidak ada hasil
                if ($pelanggans->isEmpty()) {
                    $message = "Tidak ada hasil ditemukan.";
                    $pelanggans = null; // Kosongkan $pelanggans jika tidak ada hasil
                }
            }
        } else {
            // Tampilan awal
            $message = "Silahkan Masukan Social Media Anda.";
        }

        return view('members', compact('pelanggans', 'message'));
    }
}
