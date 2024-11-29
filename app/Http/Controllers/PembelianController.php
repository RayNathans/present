<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\DetailTransaksiPembelian;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class PembelianController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian, limit, dan sort dari request
        $search = $request->input('search', '');
        $limit = $request->input('limit', 5); // Default limit ke 5
        $sort = $request->input('sort', 'id'); // Default sort by 'id'
        $direction = $request->input('direction', 'asc'); // Default direction 'asc'

        // Query detail transaksi pembelian dengan join ke bahan baku dan user
        $pembelians = TransaksiPembelian::with(['user', 'detailTransaksiPembelian'])
            ->whereHas('detailTransaksiPembelian', function ($query) use ($search) {
                $query->whereHas('bahanbaku', function ($query) use ($search) {
                    $query->where('nama_bahan_baku', 'like', "%$search%");
                });
            })->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orderBy($sort, $direction) // Apply sorting based on user input
            ->paginate($limit); // Apply pagination

        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'pembelians' => view('pembelian.partials.pembelians', compact('pembelians'))->render(),
                'pagination' => $pembelians->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('pembelian.tampilan', compact('search', 'limit', 'pembelians'));
    }

    public function create()
    {
        // Mengambil data bahan baku untuk ditampilkan pada form pembelian
        $bahanBakus = BahanBaku::all();
        return view('pembelian.create', compact('bahanBakus'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'bahan' => 'required|array',
            'id_user' => 'required|integer'
        ]);

        // Menghitung total harga berdasarkan bahan yang dipilih
        $totalHarga = 0;
        $bahanDipilih = $request->bahan; // Langsung menggunakan data yang dikirimkan

        foreach ($bahanDipilih as $bahan) {
            $totalHarga += $bahan['subtotal']; // Jumlahkan subtotal
        }

        // Buat transaksi pembelian
        $transaksi = TransaksiPembelian::create([
            'id_user' => $request->id_user,
            'total_harga' => $totalHarga, // Total harga yang dihitung
            'tanggal_transaksi' => $request->tanggal,
        ]);

        // Simpan detail transaksi untuk masing-masing bahan
        foreach ($bahanDipilih as $bahan) {
            DetailTransaksiPembelian::create([
                'id_transaksi_beli' => $transaksi->id,
                'id_bahan_baku' => (int) $bahan['id_bahan'], // Sesuaikan jika ada ID bahan
                'jumlah_per_bahan_baku' => $bahan['jumlah'],
                'total_harga_per_bahan_baku' => $bahan['subtotal'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditambahkan.'
        ]);
        Log::info('Request data:', $request->all());
    }
}
