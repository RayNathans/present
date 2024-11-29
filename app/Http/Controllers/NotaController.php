<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use App\Models\DetailTransaksiPenjualan;

class NotaController extends Controller
{
    public function show($id)
    {
        // Fetch the transaction and its details
        $transaksi = TransaksiPenjualan::with('pelanggan', 'detailTransaksiPenjualans.menu')
            ->findOrFail($id);

        // Calculate totals
        $subtotal = $transaksi->detailTransaksiPenjualans->sum('total_harga_per_menu');
        $diskon = $transaksi->pelanggan->diskon ?? 0; // Assume 'diskon' is in the Pelanggan model
        $totalBayar = $subtotal - ($subtotal * ($diskon / 100));

        // Pass data to the view
        return view('penjualan.nota', [
            'transaksi' => $transaksi,
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'totalBayar' => $totalBayar,
        ]);
    }
}
