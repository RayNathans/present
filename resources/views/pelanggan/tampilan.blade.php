<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPOLUBOGO | Pelanggan</title>
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
            <x-header-dashboard>Daftar Pelanggan</x-header-dashboard>

            <!-- Search and Limit Controls -->
            <div class="flex justify-between items-center mb-4">
                <!-- Limit Control -->
                <x-limit route="pelanggan.index" />
                <div class="flex items-center gap-4">
                    <!-- Search Form -->
                    <x-search route="pelanggan.index" />
                    <!-- Add New Pelanggan Button -->
                    <div>
                        <a href="{{ route('pelanggan.create') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">Tambah
                            Pelanggan Baru</a>
                    </div>
                </div>
            </div>

            <!-- Tabel Pelanggan -->
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-gray-900 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Social Media</th>
                        <th class="py-3 px-6 text-left">Progress Transaksi</th>
                        <th class="py-3 px-6 text-left">Member</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggans as $pelanggan)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $pelanggan->nama_pelanggan }}</td>
                            <td class="py-3 px-6">{{ $pelanggan->noWA }}</td>
                            <td class="py-3 px-6">{{ $pelanggan->progressTransaksi }}</td>
                            <td class="py-3 px-6">
                                {{ $pelanggan->member ? $pelanggan->member->nama_member : 'Non-Member' }}</td>
                            <td class="py-3 px-6">
                                {{ $pelanggan->status ? 'Aktif' : 'Tidak Aktif' }}
                            </td>
                            <td class="py-3 px-6">
                                <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                                    class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 delete-button"
                                        data-id="{{ $pelanggan->id }}" data-name="{{ $pelanggan->nama_pelanggan }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="mt-4 flex justify-center" id="pagination">
                {{ $pelanggans->appends(['search' => request('search'), 'limit' => request('limit')])->links('pagination::tailwind') }}
            </div>
        </main>
    </div>
    <script>
        // Handle search input change
        // Fungsi untuk menangani pencarian dan pagination
        function updateMenus(page = 1, search = '', limit = '') {
            $.ajax({
                url: '/pelanggans', // Sesuaikan URL dengan rute controller
                method: 'GET',
                data: {
                    search: search,
                    limit: limit,
                    page: page
                },
                success: function(response) {
                    // Update menu list
                    $('#menuList').html(response.pelanggans);

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

                    const pelangganId = this.getAttribute('data-id');
                    const pelangganName = this.getAttribute('data-name');
                    const form = this.closest('form'); // Ambil form delete terdekat

                    // Panggil API atau cek apakah member ini memiliki pelanggan terkait
                    $.ajax({
                        url: `/pelanggan/check-pelanggan/${pelangganId}`, // Endpoint pengecekan
                        method: 'GET',
                        success: function(response) {
                            if (response.has_transaksi_penjualan) {
                                // Jika ada pelanggan terkait, tampilkan alert
                                Swal.fire({
                                    title: "Tidak bisa menghapus member!",
                                    text: "Member ini masih terhubung dengan pelanggan. Silakan hapus pelanggan terlebih dahulu.",
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            } else {
                                // Jika tidak ada pelanggan, lanjutkan penghapusan
                                Swal.fire({
                                    title: `Apakah anda yakin ingin menghapus member ${pelangganName}?`,
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
