<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPembelian;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah total pelanggan dari tabel `pelanggans`
        $totalMembers = Pelanggan::count();
        $totalOutcome = TransaksiPembelian::with('detailTransaksiPembelian')
            ->get()
            ->sum(function ($transaksi) {
                return $transaksi->detailTransaksiPembelian->sum('total_harga_per_bahan_baku');
            });
        $totalIncome = TransaksiPenjualan::with('detailTransaksiPenjualans')
            ->get()
            ->sum(function ($transaksi) {
                return $transaksi->detailTransaksiPenjualans()->sum('total_harga_per_menu');
            });
        $totalTransaksi = TransaksiPembelian::count() + TransaksiPenjualan::count();

        // Mengirim data ke tampilan
        return view('dashboard.dashboard', compact('totalMembers', 'totalOutcome', 'totalIncome','totalTransaksi'));
    }

    // Metode lain yang dapat Anda tambahkan sesuai kebutuhan
    public function user()
    {
        // Logika untuk menampilkan pengguna
        return view('user.tampilan'); // Ganti dengan view pengguna
    }

    public function penjualan()
    {
        // Logika untuk menampilkan penjualan
        return view('penjualan.tampilan'); // Ganti dengan view penjualan
    }

    public function pembelian()
    {
        // Logika untuk menampilkan pembelian
        return view('pembelian.tampilan'); // Ganti dengan view pembelian
    }

    public function laporan()
    {
        // Logika untuk menampilkan laporan
        return view('laporan.tampilan'); // Ganti dengan view laporan
    }

    public function bahanbaku()
    {
        // Logika untuk menampilkan bahan baku
        return view('bahanbaku.tampilan'); // Ganti dengan view bahan baku
    }

    public function member()
    {
        // Logika untuk menampilkan anggota
        return view('member.tampilan'); // Ganti dengan view anggota
    }

    public function pelanggan()
    {
        // Logika untuk menampilkan pelanggan
        return view('pelanggan.tampilan'); // Ganti dengan view pelanggan
    }
}
