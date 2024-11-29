@foreach ($bahanbakus as $bahanbaku)
    <tr class="border-b border-gray-300 hover:bg-gray-100">
        <td class="py-3 px-6">{{ $bahanbaku->id }}</td>
        <td class="py-3 px-6 flex items-center">
            <img src="{{ asset($bahanbaku->gambar_bahanbaku) }}" alt="{{ $bahanbaku->nama_bahan_baku }}"
                class="h-16 w-16 rounded mr-4">
            <span>{{ $bahanbaku->nama_bahan_baku }}</span>
        </td>
        <td class="py-3 px-6">{{ number_format($bahanbaku->jumlah_bahan_baku, 0, ',', '.') }} kg</td>
        <td class="py-3 px-6">Rp {{ number_format($bahanbaku->harga_bahan_baku, 0, ',', '.') }}</td>
        <td class="py-3 px-6">
            <a href="{{ route('bahanbaku.edit', $bahanbaku) }}"
                class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('bahanbaku.destroy', $bahanbaku) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
