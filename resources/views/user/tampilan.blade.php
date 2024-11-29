<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@heroicons/react/outline" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>User</x-header-dashboard>

            <!-- Search and Limit Controls -->
            <div class="flex justify-between items-center mb-4">
                <!-- Limit Control -->
                <x-limit route="user.index" />
                <div class="flex items-center gap-4">
                    <!-- Search Form -->
                    <x-search route="user.index" />
                    <!-- Add New User Button -->
                    <div>
                        <a href="{{ route('user.create') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">Tambah
                            User Baru</a>
                    </div>
                </div>
            </div>

            <!-- Tabel Pengguna -->
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gray-900 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">{{ $user->role->nama_role ?? 'No Role' }}</td>
                            <td class="py-3 px-6">
                                <a href="{{ route('user.edit', $user->id) }}"
                                    class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 delete-button"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">Hapus</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4 flex justify-center" id="pagination">
                {{ $users->appends(['search' => request('search'), 'limit' => request('limit')])->links('pagination::tailwind') }}
            </div>
        </main>
    </div>

    <script>
        // Handle search input change
        // Fungsi untuk menangani pencarian dan pagination
        function updateMenus(page = 1, search = '', limit = '') {
            $.ajax({
                url: '/users', // Sesuaikan URL dengan rute controller
                method: 'GET',
                data: {
                    search: search,
                    limit: limit,
                    page: page
                },
                success: function(response) {
                    // Update menu list
                    $('#menuList').html(response.users);

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

                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-name');
                    const form = this.closest('form'); // Ambil form delete terdekat

                    // Tampilkan SweetAlert konfirmasi
                    $.ajax({
                        url: `/user/check-user/${userId}`, // Endpoint pengecekan
                        method: 'GET',
                        success: function(response) {
                            if (response.has_transaksi_penjualan) {
                                // Jika ada transaksi penjualan terkait, tampilkan alert
                                Swal.fire({
                                    title: "Tidak bisa menghapus user!",
                                    text: "User ini terhubung dengan Transaksi Penjualan.",
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            } else if (response.has_transaksi_pembelian) {
                                // Jika ada transaksi pembelian terkait, tampilkan alert
                                Swal.fire({
                                    title: "Tidak bisa menghapus user!",
                                    text: "User ini terhubung dengan Transaksi Pembelian.",
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            } else {
                                // Jika tidak ada transaksi terkait, lanjutkan penghapusan
                                Swal.fire({
                                    title: `Apakah anda yakin ingin menghapus user ${userName}?`,
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
