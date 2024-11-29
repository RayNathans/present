<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\DetailTransaksiPenjualan;
use App\Models\TransaksiPenjualan;

class PenjualanController extends Controller
{
    /**
     * Display the sales page.
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian, limit, dan sort dari request
        $search = $request->input('search', '');
        $limit = $request->input('limit', 5); // Default limit ke 5
        $sort = $request->input('sort', 'id'); // Default sort by 'id'
        $direction = $request->input('direction', 'asc'); // Default direction 'asc'

        // Query detail transaksi pembelian dengan join ke bahan baku dan user
        $penjualans = TransaksiPenjualan::with(['user', 'detailTransaksiPenjualans'])
            ->whereHas('detailTransaksiPenjualans', function ($query) use ($search) {
                $query->whereHas('menu', function ($query) use ($search) {
                    $query->where('nama_menu', 'like', "%$search%");
                });
            })->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orderBy($sort, $direction) // Apply sorting based on user input
            ->paginate($limit); // Apply pagination

        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'penjualans' => view('penjualan.partials.penjualans', compact('penjualans'))->render(),
                'pagination' => $penjualans->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('penjualan.index', compact('search', 'limit', 'penjualans'));
    }

    public function create()
    {
        // Mengambil data bahan baku untuk ditampilkan pada form pembelian
        $menus = Menu::all();
        $pelanggans = Pelanggan::where('id_member', '!=', 0)->get();
        return view('penjualan.create', compact('menus', 'pelanggans'));
    }

    /**
     * Store a new sales transaction.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tanggal' => 'required|date', // Ensure the date is present in the request
            'id_pelanggan' => 'required|exists:pelanggans,id', // The customer ID
            'nomor_meja' => 'required|string|max:10', // The table number
            'id_user' => 'required|integer',
            'menu' => 'required|array', // The authenticated user ID
        ]);

        $totalHarga = 0;
        $menuDipilih = $request->menu;


        foreach ($menuDipilih as $menu) {
            $totalHarga += $menu['subtotal']; // Jumlahkan subtotal
        };

        // Create the new transaction
        $transaksi = TransaksiPenjualan::create([
            'tanggal' => $request['tanggal'],
            'id_user' => auth()->id(), // Get the authenticated user ID
            'id_pelanggan' => $request->id_pelanggan, // Customer ID
            'total_harga' => $totalHarga, // Total amount
            'nomor_meja' => $request->nomor_meja, // Table number
        ]);

        foreach ($menuDipilih as $menu) {
            DetailTransaksiPenjualan::create([
                'id_transaksi_penjualan' => $transaksi->id,
                'id_menu' => (int) $menu['id_menu'],
                'jumlah_menu' => $menu['jumlah'],
                'total_harga_per_menu' => $menu['subtotal'],
            ]);
        }

        $pelanggan = Pelanggan::find($request->id_pelanggan); // Temukan pelanggan berdasarkan ID
        $pelanggan->progressTransaksi += $totalHarga; // Tambahkan total harga ke progressTransaksi
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil disimpan',
            'id_transaksi' => $transaksi->id,
        ]);
    }
}
