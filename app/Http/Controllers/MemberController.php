<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Pelanggan;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 5); // Default limit ke 5

        // Mulai query dengan relasi 'member' (jika perlu)
        $query = Member::query();

        if ($search) {
            $query->where('nama_member', 'LIKE', "%{$search}%");
        }

        $members = $query->paginate($limit);  // Pastikan ini adalah objek yang dipaginasi


        // Jika request AJAX
        if ($request->ajax()) {
            return response()->json([
                'members' => view('member.partials.members', compact('members'))->render(),
                'pagination' => (string) $query->appends(['search' => $search, 'limit' => $limit])->links('pagination::tailwind')
            ]);
        }

        // Jika bukan AJAX
        return view('member.tampilan', compact('members', 'search', 'limit'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request, Member $member)
    {
        $request->validate([
            'nama_member' => 'required|string|max:255|unique:members,nama_member,' . $member->id,
            'diskon_member' => 'required|numeric|min:0|unique:members,diskon_member,' . $member->id,
            'batas_atas_member' => 'nullable|integer|min:0|unique:members,batas_atas_member,' . $member->id,
            'batas_bawah_member' => 'nullable|integer|min:0|unique:members,batas_bawah_member,' . $member->id,
        ]);

        Member::create($request->all());
        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_member' => 'required|string|max:255|unique:members,nama_member,' . $member->id,
            'diskon_member' => 'required|numeric|min:0|unique:members,diskon_member,' . $member->id,
            'batas_atas_member' => 'nullable|integer|min:0|unique:members,batas_atas_member,' . $member->id,
            'batas_bawah_member' => 'nullable|integer|min:0|unique:members,batas_bawah_member,' . $member->id,
        ]);

        $member->update($request->all());
        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Cek apakah member masih terhubung dengan pelanggan
        if (Pelanggan::where('id_member', $member->id)->exists()) {
            return redirect()->route('member.index')->with('error', 'Tidak bisa menghapus member ini karena masih ada pelanggan yang terhubung.');
        }

        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    public function checkPelanggan($id)
    {
        $member = Member::findOrFail($id);

        // Cek apakah ada pelanggan yang menggunakan member ini
        $hasPelanggan = Pelanggan::where('id_member', $member->id)->exists();

        return response()->json([
            'has_pelanggan' => $hasPelanggan
        ]);
    }
}
