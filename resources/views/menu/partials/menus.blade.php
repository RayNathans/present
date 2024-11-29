<!-- resources/views/menu/partials/menus.blade.php -->
@foreach ($menus as $menu)
    <tr class="border-b border-gray-300 hover:bg-gray-100">
        <td class="py-3 px-6">{{ $menu->id }}</td>
        <td class="py-3 px-6 flex items-center">
            <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" class="w-16 h-16">
            <span>{{ $menu->nama_menu }}</span>
        </td>
        <td class="py-3 px-6">{{ number_format($menu->harga_menu, 0, ',', '.') }} IDR</td>
        <td class="py-3 px-6">
            <a href="{{ route('menu.edit', $menu) }}" class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('menu.destroy', $menu) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
