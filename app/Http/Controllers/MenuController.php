<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiPenjualan;
use App\Models\Menu;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $limit = $request->get('limit', 5); // Default limit if none is set

        // Query menus with search and limit
        $menus = Menu::where('nama_menu', 'like', "%$search%")
            ->paginate($limit);

        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'menus' => view('menu.partials.menus', compact('menus'))->render(),
                'pagination' => (string) $menus->appends(['search' => $search, 'limit' => $limit])->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('menu.tampilan', compact('menus', 'search', 'limit'));
    }



    // Menampilkan form untuk menambah menu
    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:menus,nama_menu'. $menu->id,
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Maksimal 5MB
        ]);

        // Simpan gambar
        $path = $request->file('image')->store('images', 'public'); // Simpan ke storage/app/public/images

        // Buat menu baru
        Menu::create([
            'nama_menu' => $request->name,
            'harga_menu' => $request->price,
            'gambar_menu' => $path,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:menus,nama_menu,' . $menu->id,
            'price' => 'required|numeric|min:0',
            'image' => 'image|max:5120|nullable',
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $menu->gambar_menu = $path;
        }
    
        $menu->nama_menu = $request->name;
        $menu->harga_menu = $request->price;
        $menu->save();
    
        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully!');
    }
    

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Cek apakah member masih terhubung dengan pelanggan
        if (DetailTransaksiPenjualan::where('id_menu', $menu->id)->exists()) {
            return redirect()->route('menu.index')->with('error', 'Tidak bisa menghapus menu ini karena masih ada detail transaksi penjualan yang terhubung.');
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully!');
    }

    public function checkMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Cek apakah ada pelanggan yang menggunakan member ini
        $hasDetailTransaksiPenjualan = DetailTransaksiPenjualan::where('id_menu', $menu->id)->exists();

        return response()->json([
            'has_detail_transaksi_penjualan' => $hasDetailTransaksiPenjualan
        ]);
    }
}
