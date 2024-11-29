<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        // Ambil semua menu dari database
        $menus = Menu::all();

        return view('menus', compact('menus'));
    }

    public function store(Request $request)
    {

        return redirect()->route('menus')->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
