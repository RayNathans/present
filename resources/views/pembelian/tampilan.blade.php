<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPOLUBOGO | Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@heroicons/react/outline" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Pembelian</x-header-dashboard>
            <div class="flex justify-between items-center mb-4">
                <!-- Limit Control -->
                <x-limit route="pembelian.index" />

                <div class="flex items-center gap-4">
                    <!-- Search Form -->
                    <x-search route="pembelian.index" />
                    <!-- Add New pembelian Button -->
                    <div>
                        <a href="{{ route('pembelian.create') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">
                            Tambah Pembelian Baru</a>
                    </div>
                </div>
            </div>

            <!-- Pembelian -->
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gray-900 text-white">
                        <th class="px-4 py-2 border-b text-left">
                            <a
                                href="{{ route('pembelian.index', ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                ID Transaksi
                                @if (request('sort') === 'id')
                                    <i
                                        class="fa {{ request('direction') === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fa fa-sort"></i> <!-- Default Sort Icon -->
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 border-b text-left">
                            <a
                                href="{{ route('pembelian.index', ['sort' => 'tanggal_transaksi', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Tanggal Transaksi
                                @if (request('sort') === 'tanggal_transaksi')
                                    <i
                                        class="fa {{ request('direction') === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fa fa-sort"></i> <!-- Default Sort Icon -->
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 border-b text-left">
                            <a
                                href="{{ route('pembelian.index', ['sort' => 'total_harga', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Total Harga
                                @if (request('sort') === 'total_harga')
                                    <i
                                        class="fa {{ request('direction') === 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i>
                                @else
                                    <i class="fa fa-sort"></i> <!-- Default Sort Icon -->
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 border-b text-left">Nama User</th>
                        <th class="px-4 py-2 border-b text-left">Bahan Baku yang Dipesan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembelians as $pembelian)
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-center" id="pagination">
                {{ $pembelians->appends(['search' => request('search'), 'limit' => request('limit'), 'sort' => request('sort'), 'direction' => request('direction')])->links('pagination::tailwind') }}
            </div>

            <!-- Pagination Links -->
        </main>
    </div>

    <script>
        // Handle search input change
        // Fungsi untuk menangani pencarian dan pagination
        function updateMenus(page = 1, search = '', limit = '') {
            $.ajax({
                url: '/pembelians', // Sesuaikan URL dengan rute controller
                method: 'GET',
                data: {
                    search: search,
                    limit: limit,
                    page: page
                },
                success: function(response) {
                    // Update menu list
                    $('#menuList').html(response.pembelians);

                    // Update pagination links
                    $('#pagination').html(response.pagination);
                }
            });
        }

        // Pencarian input
        $('#searchInput').on('input', function() {
            var search = $(this).val();
            var limit = $('#limit').val(); // Ambil limit yang dipilih
            updateMenus(1, search, limit); // Panggil updateMenus untuk halaman pertama
        });

        // Handle pagination click
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var search = $('#searchInput').val(); // Ambil nilai pencarian
            var limit = $('#limit').val(); // Ambil limit yang dipilih
            updateMenus(page, search, limit); // Panggil updateMenus dengan halaman yang diinginkan
        });
    </script>
</body>

</html>
