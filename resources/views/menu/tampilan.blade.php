<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPOLUBOGO | Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Menu</x-header-dashboard>

            <!-- Search and Limit Controls -->
            <div class="flex justify-between items-center mb-4">
                <!-- Limit Control -->
                <x-limit route="menu.index" />
                <div class="flex items-center gap-4">
                    <!-- Search Form -->
                    <x-search route="menu.index" />
                    <!-- Add New Menu Button -->
                    <div>
                        <a href="{{ route('menu.create') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">Tambah Menu Baru</a>
                    </div>
                </div>
            </div>

            <!-- Tabel Menu -->
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gray-900 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Menu</th>
                        <th class="py-3 px-6 text-left">Price</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="menuList">
                    @foreach ($menus as $menu)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $menu->id }}</td>
                            <td class="py-3 px-6 flex items-center">
                                <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}"
                                    class="w-16 h-16">
                                <span>{{ $menu->nama_menu }}</span>
                            </td>
                            <td class="py-3 px-6">{{ number_format($menu->harga_menu, 0, ',', '.') }} IDR</td>
                            <td class="py-3 px-6">
                                <a href="{{ route('menu.edit', $menu) }}"
                                    class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 delete-button"
                                        data-id="{{ $menu->id }}" data-name="{{ $menu->nama_menu }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4 flex justify-center" id="pagination">
                {{ $menus->appends(['search' => request('search'), 'limit' => request('limit')])->links('pagination::tailwind') }}
            </div>

        </main>
    </div>

    <script>
        // Handle search input change
        // Fungsi untuk menangani pencarian dan pagination
        function updateMenus(page = 1, search = '', limit = '') {
            $.ajax({
                url: '/menus', // Sesuaikan URL dengan rute controller
                method: 'GET',
                data: {
                    search: search,
                    limit: limit,
                    page: page
                },
                success: function(response) {
                    // Update menu list
                    $('#menuList').html(response.menus);

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

        document.addEventListener("DOMContentLoaded", function() {

            // Ambil semua tombol delete
            const deleteButtons = document.querySelectorAll('.delete-button');

            // Tambahkan event listener ke setiap tombol delete
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const menuId = this.getAttribute('data-id');
                    const menuName = this.getAttribute('data-name');
                    const form = this.closest('form'); // Ambil form delete terdekat

                    // Panggil API atau cek apakah member ini memiliki pelanggan terkait
                    $.ajax({
                        url: `/menu/check-menu/${menuId}`, // Endpoint pengecekan
                        method: 'GET',
                        success: function(response) {
                            if (response.has_detail_transaksi_penjualan) {
                                // Jika ada pelanggan terkait, tampilkan alert
                                Swal.fire({
                                    title: "Tidak bisa menghapus menu!",
                                    text: "Member ini terhubung dengan detail transaksi penjualan.",
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            } else {
                                // Jika tidak ada pelanggan, lanjutkan penghapusan
                                Swal.fire({
                                    title: `Apakah anda yakin ingin menghapus menu ${menuName}?`,
                                    text: "Data tidak dapat dikembalikan setelah dihapus!",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#d33",
                                    cancelButtonColor: "#3085d6",
                                    confirmButtonText: "Ya, hapus!",
                                    cancelButtonText: "Batal"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form
                                            .submit(); // Jika dikonfirmasi, submit form
                                    }
                                });
                            }
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>
