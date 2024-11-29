<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@heroicons/react/outline" defer></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Laporan Pembelian</x-header-dashboard>

            <!-- Search and Limit Controls -->
            <div class="flex justify-between items-center mb-4">
                <!-- Limit Control -->
                <div class="flex items-center gap-4">
                    <h1>Pilih Kategori Laporan</h1>
                    <button type="button" class="px-4 py-2 rounded bg-gray-900 hover:bg-gray-700">
                        <a href="/laporan_penjualan" class="text-white font-semibold">Penjualan</a>
                    </button>
                    <button type="button" class="px-4 py-2 rounded bg-gray-900 hover:bg-gray-700">
                        <a href="/laporan_pembelian" class="text-white font-semibold">Pembelian</a>
                    </button>
                    <button type="button" class="px-4 py-2 rounded bg-gray-900 hover:bg-gray-700">
                        <a href="/grafik-laporan" class="text-white font-semibold">Grafik Penjualan</a>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <form action="{{ route('laporan.pembelian') }}" method="GET" id="filter-form"
                    class="flex items-end gap-4">
                    <div>
                        <label for="limit" class="block text-sm font-medium text-gray-700">Limit:</label>
                        <select name="limit" id="limit"
                            class="form-control border border-gray-300 rounded-lg px-4 py-2 shadow mr-2">
                            <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal
                            Mulai</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ request('start_date', $startDate) }}"
                            class="border border-gray-300 rounded-lg px-4 py-1.5 shadow mr-2">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date', $endDate) }}"
                            class="border border-gray-300 rounded-lg px-4 py-1.5 shadow mr-2">
                    </div>
                    <button type="submit"
                        class="bg-gray-900 text-white px-4 py-2 ml-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Tabel Laporan Penjualan -->
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gray-900 text-white">
                        <th class="px-4 py-2 border-b text-left">ID Transaksi</th>
                        <th class="px-4 py-2 border-b text-left">Tanggal Transaksi</th>
                        <th class="px-4 py-2 border-b text-left">Total Harga</th>
                        <th class="px-4 py-2 border-b text-left">Nama User</th>
                        <th class="px-4 py-2 border-b text-left">Bahan Baku yang Dipesan</th>
                        <th class="px-4 py-2 border-b text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanPembelian as $pembelian)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $pembelian->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $pembelian->tanggal_transaksi }}</td>
                            <td class="px-4 py-2 border-b">Rp{{ number_format($pembelian->total_harga, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border-b">{{ $pembelian->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border-b">
                                <ul>
                                    @foreach ($pembelian->detailTransaksipembelian as $detail)
                                        <li>{{ $detail->bahanbaku->nama_bahan_baku }} -
                                            {{ $detail->jumlah_per_bahan_baku }} pcs</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-3 py-1 border-b">
                                <!-- Button Group in One Row -->
                                <div class="flex space-x-2">
                                    <!-- Button Detail with Icon -->
                                    <a href="{{ route('laporan.pembelian.detail', $pembelian->id) }}"
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
                                    <a href="{{ route('laporan.pembelian.pdf', $pembelian->id) }}"
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

            <!-- Pagination Links (Jika Diperlukan) -->
            <div class="mt-4 flex justify-center">
                {{ $laporanPembelian->links('pagination::tailwind') }}
            </div>
        </main>
    </div>
    <script>
        document.getElementById('limit').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    </script>
</body>

</html>
