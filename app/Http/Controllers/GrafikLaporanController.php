<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\TransaksiPembelian;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GrafikLaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data penjualan bulanan
        $penjualanBulanan = TransaksiPenjualan::selectRaw('MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function ($item) {
                $item->bulan = Carbon::createFromFormat('m', $item->bulan)->format('F'); // Format bulan
                return $item;
            });

        // Ambil data pengeluaran tahunan
        $pengeluaranTahunan = TransaksiPenjualan::selectRaw('YEAR(tanggal_transaksi) as tahun, SUM(total_harga) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        // Ambil menu dengan penjualan terbanyak
        $menuTerbanyak = Menu::with('detailTransaksiPenjualan')->get()->sortByDesc(function($menu) {
            return $menu->detailTransaksiPenjualan->sum('jumlah_menu'); // Total penjualan berdasarkan jumlah menu
        })->first();

        $pembelianBulanan = TransaksiPembelian::selectRaw('MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function ($item) {
                $item->bulan = Carbon::createFromFormat('m', $item->bulan)->format('F'); // Format bulan
                return $item;
            });  

        return view('laporan.grafik', compact('penjualanBulanan', 'pengeluaranTahunan', 'menuTerbanyak', 'pembelianBulanan'));
    }
}
