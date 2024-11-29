@foreach ($members as $member)
    <tr class="border-b border-gray-300 hover:bg-gray-100">
        <td class="py-3 px-6">{{ $member->id }}</td>
        <td class="py-3 px-6">{{ $member->nama_member }}</td>
        <td class="py-3 px-6">{{ $member->diskon_member * 100 }}%</td>
        <td class="py-3 px-6">{{ number_format($member->batas_atas_member, 0, ',', '.') }}</td>
        <td class="py-3 px-6">{{ number_format($member->batas_bawah_member, 0, ',', '.') }}</td>
        <td class="py-3 px-6">
            <a href="{{ route('member.edit', $member) }}"
                class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('member.destroy', $member) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
