@foreach ($pelanggans as $pelanggan)
    <tr class="border-b border-gray-300 hover:bg-gray-100">
        <td class="py-3 px-6">{{ $pelanggan->nama_pelanggan }}</td>
        <td class="py-3 px-6">{{ $pelanggan->noWA }}</td>
        <td class="py-3 px-6">{{ $pelanggan->progressTransaksi }}</td>
        <td class="py-3 px-6">
            {{ $pelanggan->member ? $pelanggan->member->nama_member : 'Non-Member' }}</td>
        <td class="py-3 px-6">
            {{ $pelanggan->status ? 'Aktif' : 'Tidak Aktif' }}
        </td>
        <td class="py-3 px-6">
            <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"
                    onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">Hapus</button>
            </form>
        </td>
    </tr>
@endforeach
