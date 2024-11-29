<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use App\Models\TransaksiPenjualan;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search', '');
        $limit = $request->input('limit', 5); // Default limit ke 5

        $query = User::with('role');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $users = $query->paginate($limit);  // Pastikan ini adalah objek yang dipaginasi


        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'users' => view('user.partials.users', compact('users'))->render(),
                'pagination' => (string) $query->appends(['search' => $search, 'limit' => $limit])->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('user.tampilan', compact('users', 'search', 'limit'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string||max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|string',
            'id_role' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_role' => $request->id_role,
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string||max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'id_role' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    // }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah ada transaksi penjualan yang terhubung
        if (TransaksiPenjualan::where('id_user', $user->id)->exists()) {
            return redirect()->route('user.index')->with('error', 'Tidak bisa menghapus user ini karena masih ada Transaksi Penjualan yang terhubung.');
        }
    
        // Cek apakah ada transaksi pembelian yang terhubung
        if (TransaksiPembelian::where('id_user', $user->id)->exists()) {
            return redirect()->route('user.index')->with('error', 'Tidak bisa menghapus user ini karena masih ada Transaksi Pembelian yang terhubung.');
        }
    
        // Hapus user jika tidak ada transaksi terkait
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
    

    public function checkUser($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah ada pelanggan yang menggunakan member ini
        $hasTransaksiPenjualan = TransaksiPenjualan::where('id_user', $user->id)->exists();

        $hasTransaksiPembelian = TransaksiPembelian::where('id_user', $user->id)->exists();
        return response()->json([
            'has_transaksi_penjualan' => $hasTransaksiPenjualan,
            'has_transaksi_pembelian' => $hasTransaksiPembelian
        ]);
    }


}
