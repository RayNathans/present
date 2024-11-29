@foreach ($users as $user)
    <tr class="border-b border-gray-300 hover:bg-gray-100">
        <td class="py-3 px-6">{{ $user->name }}</td>
        <td class="py-3 px-6">{{ $user->email }}</td>
        <td class="py-3 px-6">{{ $user->role->nama_role ?? 'No Role' }}</td>
        <td class="py-3 px-6">
            <a href="{{ route('user.edit', $user->id) }}"
                class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Hapus</button>
            </form>
        </td>
    </tr>
@endforeach
