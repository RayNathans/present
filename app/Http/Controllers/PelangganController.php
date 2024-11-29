<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Pelanggan;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 5); // Default limit ke 5

        // Mulai query dengan relasi 'member' (jika perlu)
        $query = Pelanggan::with('member');

        if ($search) {
            $query->where('nama_pelanggan', 'LIKE', "%{$search}%")
                ->orWhere('noWA', 'LIKE', "%{$search}%");
        }

        $pelanggans = $query->paginate($limit);  // Pastikan ini adalah objek yang dipaginasi


        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'pelanggans' => view('pelanggan.partials.pelanggans', compact('pelanggans'))->render(),
                'pagination' => (string) $query->appends(['search' => $search, 'limit' => $limit])->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('pelanggan.tampilan', compact('pelanggans', 'search', 'limit'));
    }


    public function create()
    {
        $members = Member::all(); // Ambil semua data member
        return view('pelanggan.create', compact('members')); // Kirim ke view
    }

    public function store(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'noWA' => 'nullable|unique:pelanggans,noWA' . $pelanggan->id, // Pastikan tidak ada spasi tambahan di sini
            'progressTransaksi' => 'nullable|numeric',
            'id_member' => 'nullable|integer',
        ]);

        // Pastikan progressTransaksi dan noWA default null jika kosong
        $data = $request->all();

        // Cek apakah kolom noWA kosong, jika iya, set null
        if (empty($data['noWA'])) {
            $data['noWA'] = null;
        }

        // Cek apakah kolom progressTransaksi kosong, jika iya, set null
        if (empty($data['progressTransaksi'])) {
            $data['progressTransaksi'] = 0;
        }

        // Cek apakah kolom id_member kosong, jika iya, set default
        if (empty($data['id_member'])) {
            $data['id_member'] = 1;  // Member default, misalnya id_member = 1
        }

        // Simpan data pelanggan ke database
        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id); // Ambil data pelanggan berdasarkan ID
        $members = Member::all(); // Ambil semua data member
        return view('pelanggan.edit', compact('pelanggan', 'members')); // Kirim ke view
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'noWA' => 'nullable|unique:pelanggans,noWA,' . $pelanggan->id, // Pastikan tidak ada spasi tambahan
            'progressTransaksi' => 'nullable|numeric',
            'id_member' => 'nullable|integer',
        ]);

        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Cek apakah member masih terhubung dengan pelanggan
        if (TransaksiPenjualan::where('id_pelanggan', $pelanggan->id)->exists()) {
            return redirect()->route('pelanggan.index')->with('error', 'Tidak bisa menghapus pelanggan ini karena ada transaksi penjualan yang terhubung.');
        }
    
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    } 

    public function checkPelanggan($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Cek apakah ada pelanggan yang menggunakan member ini
        $hasTransaksiPenjualan = TransaksiPenjualan::where('id_pelanggan', $pelanggan->id)->exists();

        return response()->json([
            'has_transaksi_penjualan' => $hasTransaksiPenjualan
        ]);
    }
}
