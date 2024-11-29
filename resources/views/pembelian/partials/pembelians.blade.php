@foreach ($bahanBakus as $bahanBaku)
    <tr class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b border-gray-200">{{ $bahanBaku->nama_bahan_baku }}</td>
        <td class="py-2 px-4 border-b border-gray-200">{{ $bahanBaku->jumlah_bahan_baku }}kg</td>
    </tr>
@endforeach
