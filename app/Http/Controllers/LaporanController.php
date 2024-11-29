<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\DetailTransaksiPenjualan;
use App\Models\TransaksiPembelian;
use App\Models\DetailTransaksiPembelian;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        // Tampilkan halaman pilihan kategori laporan
        return view('laporan.tampilan');
    }

    public function laporanPenjualan(Request $request)
    {
        // Ambil data member untuk dropdown filter
        $users = User::all();
        $members = Member::all();

        // Default parameter
        $limit = $request->input('limit', 5); // Default limit
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d')); // Tanggal mulai default
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d')); // Tanggal akhir default

        // Query utama
        $query = TransaksiPenjualan::with(['user', 'detailTransaksiPenjualans.menu', 'pelanggan'])
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate]); // Filter tanggal

        // Filter berdasarkan id_member
        if ($request->filled('id_member')) {
            $query->whereHas('pelanggan', function ($q) use ($request) {
                $q->where('id_member', $request->id_member);
            });
        }

        // Filter berdasarkan pencarian nama user
        if ($request->filled('id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->id);
            });
        }

        // Paginate hasil
        $laporanPenjualan = $query->paginate($limit)->appends([
            'id' => $request->id,
            'limit' => $limit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'id_member' => $request->id_member,
        ]);

        // Jika request adalah AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('laporan.partials.laporan_penjualan', compact('laporanPenjualan'))->render(),
                'pagination' => (string) $laporanPenjualan->appends(['id' => $request->id, 'limit' => $limit, 'start_date' => $startDate, 'end_date' => $endDate, 'id_member' => $request->id_member])->links('pagination::tailwind'),
            ]);
        }

        // Return ke view
        return view('laporan.penjualan', compact('laporanPenjualan', 'members', 'startDate', 'endDate', 'limit', 'users'));
    }


    public function laporanPembelian(Request $request)
    {
        $users = User::all();

        $limit = $request->input('limit', 5);
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d')); // Tanggal mulai default
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d')); // Tanggal akhir default

        $query = TransaksiPembelian::with(['user', 'detailTransaksiPembelian']);

        // Filter berdasarkan tanggal jika parameter 'start_date' dan 'end_date' ada di request
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan pencarian nama user
        if ($request->filled('id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->id);
            });
        }

        // Ambil hasil query
        $laporanPembelian = $query->paginate($limit)->appends([
            'id' => $request->id,
            'limit' => $limit,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return view('laporan.pembelian', compact('laporanPembelian', 'users', 'startDate', 'endDate', 'limit'));
    }


    public function showDetailPenjualan($id)
    {
        $laporanPenjualan = TransaksiPenjualan::with(['user', 'detailTransaksiPenjualans.menu'])->findOrFail($id);
        $laporanPenjualan->calculateTotalHarga();
        return view('laporan.detailPenjualan', compact('laporanPenjualan'));
    }

    public function generatePDFjual($id)
    {
        // Ambil data laporan penjualan dengan ID tertentu
        $laporanPenjualan = TransaksiPenjualan::with(['user', 'detailTransaksiPenjualans.menu', 'pelanggan'])->findOrFail($id);

        // Generate PDF dari tampilan Blade
        $pdf = PDF::loadView('laporan.detailPenjualan', compact('laporanPenjualan'));

        // Untuk menampilkan PDF di browser
        return $pdf->stream('laporan-penjualan.pdf');
    }

    // public function generatePDFBeli($id)
    // {
    //     // Ambil data laporan penjualan dengan ID tertentu
    //     $laporanPembelian = TransaksiPembelian::with(['user', 'detailTransaksiPembelian.bahanbaku'])->findOrFail($id);

    //     // Generate PDF dari tampilan Blade
    //     $pdf = PDF::loadView('laporan.detailPembelian', compact('laporanPembelian'));

    //     // Untuk menampilkan PDF di browser
    //     return $pdf->stream('laporan-pembelian.pdf');

    //     // Atau untuk mendownload PDF
    //     // return $pdf->download('laporan-penjualan.pdf');
    // }

    public function showDetailPembelian($id)
    {
        $laporanPembelian = TransaksiPembelian::with(['user', 'detailTransaksiPembelian.bahanbaku'])->findOrFail($id);
        $laporanPembelian->tanggal_transaksi = Carbon::parse($laporanPembelian->tanggal_transaksi);
        return view('laporan.detailPembelian', compact('laporanPembelian'));
    }
    public function generatePDFbeli($id)
    {
        // Ambil data laporan penjualan dengan ID tertentu
        $laporanPembelian = TransaksiPembelian::with(['user', 'detailTransaksiPembelian.bahanbaku'])->findOrFail($id);
        $laporanPembelian->tanggal_transaksi = Carbon::parse($laporanPembelian->tanggal_transaksi);
        // Generate PDF dari tampilan Blade
        $pdf = PDF::loadView('laporan.detailPembelian', compact('laporanPembelian'));

        // Untuk menampilkan PDF di browser
        return $pdf->stream('laporan-pembelian.pdf');
    }
}
