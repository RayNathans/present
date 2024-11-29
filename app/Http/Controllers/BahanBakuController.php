<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\DetailTransaksiPembelian;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $limit = $request->get('limit', 5); // Default limit if none is set

        // Query menus with search and limit
        $bahanbakus = BahanBaku::where('nama_bahan_baku', 'like', "%$search%")
            ->paginate($limit);

        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'bahanbakus' => view('bahanbaku.partials.bahanBakus', compact('bahanbakus'))->render(),
                'pagination' => (string) $bahanbakus->appends(['search' => $search, 'limit' => $limit])->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('bahanbaku.tampilan', compact('bahanbakus', 'search', 'limit'));
    }

    // Menampilkan form untuk menambah menu
    public function create()
    {
        return view('bahanbaku.create');
    }

    public function store(Request $request, BahanBaku $bahanbaku)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bahanbakus,nama_bahan_baku,' . $bahanbaku->id,
            'jumlah' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Maksimal 5MB
        ]);

        // Simpan gambar
        $path = $request->file('image')->store('images', 'public'); // Simpan ke storage/app/public/images

        // Buat menu baru
        BahanBaku::create([
            'nama_bahan_baku' => $request->name,
            'harga_bahan_baku' => $request->price,
            'jumlah_bahan_baku' => $request->jumlah,
            'gambar_bahan_baku' => $path,
        ]);

        return redirect()->route('bahanbaku.index')->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function edit(BahanBaku $bahanbaku)
    {
        return view('bahanbaku.edit', compact('bahanbaku'));
    }

    public function update(Request $request, BahanBaku $bahanbaku)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bahanbakus,nama_bahan_baku,' . $bahanbaku->id,
            'price' => 'required|numeric|min:0',

        ]);

        if ($request->hasFile('image')) {
            if ($bahanbaku->gambar_bahan_baku) {
                Storage::disk('public')->delete($bahanbaku->gambar_bahan_baku);
            }
        
            $path = $request->file('image')->store('images', 'public');
            $bahanbaku->gambar_bahan_baku = $path;
        }

        $bahanbaku->nama_bahan_baku = $request->name;
        $bahanbaku->harga_bahan_baku = $request->price;
        $bahanbaku->save();

        return redirect()->route('bahanbaku.index')->with('success', 'Bahan Baku item updated successfully!');
    }

    public function destroy($id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);

        // Cek apakah member masih terhubung dengan pelanggan
        if (DetailTransaksiPembelian::where('id_bahan_baku', $bahanbaku->id)->exists()) {
            return redirect()->route('bahanbaku.index')->with('error', 'Tidak bisa menghapus menu ini karena masih ada detail transaksi penjualan yang terhubung.');
        }
        $bahanbaku->delete();
        return redirect()->route('bahanbaku.index')->with('success', 'Bahan Baku item deleted successfully!');
    }

    public function checkBahanBaku($id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);

        // Cek apakah ada pelanggan yang menggunakan member ini
        $hasDetailTransaksiPembelian = DetailTransaksiPembelian::where('id_bahan_baku', $bahanbaku->id)->exists();

        return response()->json([
            'has_detail_transaksi_pembelian' => $hasDetailTransaksiPembelian
        ]);
    }
}
