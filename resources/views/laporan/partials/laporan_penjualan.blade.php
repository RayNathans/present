<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2 border-b text-left">ID Transaksi</th>
            <th class="px-4 py-2 border-b text-left">Tanggal Transaksi</th>
            <th class="px-4 py-2 border-b text-left">Total Harga</th>
            <th class="px-4 py-2 border-b text-left">Nama User</th>
            <th class="px-4 py-2 border-b text-left">Nama Pelanggan</th>
            <th class="px-4 py-2 border-b text-left">Menu yang Dipesan</th>
            <th class="px-4 py-2 border-b text-left">Aksi</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($laporanPenjualan as $penjualan)
            <tr>
                <td class="px-4 py-2 border-b">{{ $penjualan->id }}</td>
                <td class="px-4 py-2 border-b">{{ $penjualan->tanggal_transaksi }}</td>
                <td class="px-4 py-2 border-b">Rp{{ number_format($penjualan->total_harga, 2, ',', '.') }}
                </td>
                <td class="px-4 py-2 border-b">{{ $penjualan->user->name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border-b">{{ $penjualan->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                <td class="px-4 py-2 border-b">
                    <ul>
                        @foreach ($penjualan->detailTransaksiPenjualans as $detail)
                            <li>{{ $detail->menu->nama_menu }} - {{ $detail->jumlah_menu }}
                                {{ $detail->id_menu }} pcs</li>
                        @endforeach
                    </ul>
                </td>
                <td class="px-3 py-1 border-b">
                    <!-- Button Group in One Row -->
                    <div class="flex space-x-2">
                        <!-- Button Detail with Icon -->
                        <a href="{{ route('laporan.penjualan.detail', $penjualan->id) }}"
                            class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            <!-- Heroicon Data Icon for Detail -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none"
                                stroke="currentColor" class="w-3 h-3 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9h3m0 0h3m-3 0v3m0-3V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2h-3a2 2 0 00-2 2v3z" />
                            </svg>
                            <span>Detail</span>
                        </a>

                        <!-- Button Cetak Nota with Icon -->
                        <a href="{{ route('laporan.penjualan.pdf', $penjualan->id) }}"
                            class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                            <!-- Heroicon Print Icon for Cetak Nota -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 5H18M6 9H18M6 13H18M6 17H18M3 21H21V7H3V21Z" />
                            </svg>
                            <span>Cetak Nota</span>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>