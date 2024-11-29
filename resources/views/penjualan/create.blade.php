<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>

</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Tambah Penjualan</h1>
            <p id="currentTime" class="text-gray-600"></p>
        </div>
        <!-- Error umum -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Content -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <div class="grid grid-cols-4 gap-4">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal_transaksi" class="font-semibold block text-gray-700">Tanggal</label>
                    <input type="date" id="tanggal_transaksi" class="w-full px-4 py-2 border rounded-lg" />
                    @error('tanggal_transaksi')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pegawai -->
                <div>
                    <label for="pegawai" class="font-semibold block text-gray-700">Pegawai</label>
                    <input type="text" id="pegawai"
                        class="w-full px-4 py-2 font-semibold border rounded-lg bg-white focus:outline-none cursor-default"
                        value="{{ Auth::user()->name }}" placeholder="Nama pegawai" readonly />
                </div>
                <div>
                    <p class="text-md
                     text-gray-700 font-semibold">Pelanggan</p>
                    <div>
                        <input type="text" id="pelanggan"
                            class="w-full font-semibold px-4 py-2 border rounded-lg bg-white focus:outline-none cursor-default"
                            placeholder="Nama pelanggan" readonly />
                        <p class="text-md
                     text-gray-700 font-semibold mt-2">Member</p>
                        <input type="text" id="member"
                            class="w-full font-semibold px-4 py-2 border rounded-lg bg-white focus:outline-none cursor-default"
                            placeholder="Nama Member" readonly />
                        <p id="member"></p>
                    </div>
                </div>

                <div>
                    <label for="nomor_meja" class="font-semibold block text-gray-700">Nomor Meja</label>
                    <input type="text" id="nomor_meja" name="nomor_meja"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none"
                        placeholder="Masukkan Nomor Meja" />
                    <input type="hidden" id="id_pelanggan" name="id_pelanggan" />
                </div>
            </div>

            <div class="mt-4">
                <!-- Pilihan -->
                <button class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 mr-2"
                    id="pilih-produk-btn">Pilih Menu</button>
                <button class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 mr-2"
                    id="pilih-pelanggan-btn">Pilih Pelanggan</button>
            </div>

            <!-- Modal untuk memilih bahan baku -->
            <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-auto max-w-md mx-auto mt-10 overflow-y-auto">
                    <h2 class="text-xl font-semibold mb-4 text-center text-gray-800">Pilih Menu</h2>

                    <!-- Table Container with Scroll -->
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full table-auto text-gray-800 border-collapse">
                            <thead class="bg-white sticky top-0 z-10">
                                <tr class="border-b">
                                    <th class="px-0 py-3 text-left">No</th>
                                    <th class="px-0 py-3 text-left">Nama Menu</th>
                                    <th class="px-0 py-3 text-left">Harga</th>
                                    <th class="px-0 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr class="border-b hover:bg-gray-100">
                                        <td class="px-0 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-0 py-3">{{ $menu->nama_menu }}</td>
                                        <td class="px-0 py-3">Rp {{ number_format($menu->harga_menu, 0, ',', '.') }}
                                        </td>
                                        <td class="px-0 py-3">
                                            <button
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                                onclick="pilihMenu({{ $menu->id }}, '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">
                                                Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Input Jumlah -->
                    <div class="mt-6">
                        <label for="jumlah-bahan" class="font-semibold block text-gray-700 mb-2">Jumlah</label>
                        <input type="number" id="jumlah_menu"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan jumlah" min="1">
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <button id="close-modal"
                            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>


            <div id="pelanggan-modal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-auto max-w-md mx-auto mt-10">
                    <h2 class="text-xl font-semibold mb-4 text-center text-gray-800">Pilih Pelanggan</h2>

                    <!-- Table Container with Scroll -->
                    <div class="max-h-96 overflow-y-auto">
                        <table class="min-w-full table-auto text-gray-800">
                            <thead class="bg-white sticky top-0 z-10">
                                <tr class="border-b">
                                    <th class="px-0 py-3 text-left">No</th>
                                    <th class="px-0 py-3 text-left">Nama Pelanggan</th>
                                    <th class="px-0 py-3 text-left">Progress Transaksi</th>
                                    <th class="px-0 py-3 text-left">Member</th>
                                    <th class="px-0 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggans as $pelanggan)
                                    <tr class="border-b hover:bg-gray-100">
                                        <td class="px-0 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-0 py-3">{{ $pelanggan->nama_pelanggan }}</td>
                                        <td class="px-0 py-3">Rp
                                            {{ number_format($pelanggan->progressTransaksi, 0, ',', '.') }}
                                        </td>
                                        <td class="px-0 py-3">{{ $pelanggan->member->nama_member ?? 'Non-Member' }}
                                        </td>
                                        <td class="px-0 py-3">
                                            <button
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                                onclick="pilihPelanggan(
                                        {{ $pelanggan->id }},
                                        '{{ $pelanggan->nama_pelanggan }}',
                                        '{{ $pelanggan->progressTransaksi }}',
                                        '{{ $pelanggan->member->nama_member ?? 'Non-Member' }}',
                                        '{{ $pelanggan->member->diskon_member ?? '0' }}'
                                    )">
                                                Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <button id="close-pelanggan-modal"
                            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">Tutup</button>
                    </div>
                </div>
            </div>



            <!-- Modal Edit Transaksi -->
            <div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-w-md mx-auto">
                    <h2 class="text-xl font-semibold mb-4 text-center text-gray-800">Edit Transaksi</h2>

                    <!-- Form untuk edit bahan baku dan jumlah -->
                    <div class="mt-4">
                        <label for="edit-bahan-baku" class="block text-gray-700 mb-2">Nama Menu</label>
                        <input type="text" id="edit-bahan-baku"
                            class="w-full px-4 py-2 border rounded-lg bg-gray-200 focus:outline-none cursor-default"
                            readonly />
                    </div>
                    <div class="mt-4">
                        <label for="edit-jumlah" class="block text-gray-700 mb-2">Jumlah Menu</label>
                        <input type="number" id="edit-jumlah" class="w-full px-4 py-2 border rounded-lg"
                            min="1" />
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <button id="close-edit-modal"
                            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">Tutup</button>
                        <button id="save-edit-btn"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">Simpan</button>
                    </div>
                </div>
            </div>



            <!-- Tabel Transaksi -->
            <div class="mt-6">
                <table class="w-full border-collapse rounded-lg shadow-md" id="tabel-transaksi">
                    <thead>
                        <tr class="bg-gray-900 text-white">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Menu</th>
                            <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                            <th class="border border-gray-300 px-4 py-2">Harga per Satuan</th>
                            <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transaksi-list">
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada transaksi!</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total dan Bayar -->
            <div class="flex justify-between items-center mt-6">
                <div>
                    <p class="text-md text-gray-700 font-bold mb-2">Subtotal</p>
                    <input type="text" id="subtotal"
                        class="w-full px-4 py-2 border rounded-lg bg-white focus:outline-none cursor-default"
                        placeholder="Subtotal Pembayaran" readonly />
                    <p class="text-md
                     text-gray-700 font-bold mt-2 mb-2">Diskon Member</p>
                    <input type="text" id="diskon_member"
                        class="w-full px-4 py-2 border rounded-lg bg-white focus:outline-none cursor-default"
                        placeholder="Diskon Member" readonly />
                    <p class="text-xl text-gray-700 px-4 py-2 font-bold">Total Pembayaran</p>
                    <div class="flex row-auto">
                        <p class="text-xl text-gray-700 px-4 py-2 font-bold">Rp</p>
                        <p class="text-xl text-gray-700 w-full px-4 py-2 border border-black rounded-lg bg-gray-200 focus:outline-none cursor-default font-medium"
                            id="total-bayar">0,00</p>
                    </div>
                </div>
                <div class="flex flex-col space-y-6 ">

                    <!-- Input untuk Nominal -->
                    <div class="flex flex-col space-y-2">
                        <label for="nominal_bayar" class="text-lg font-semibold">Nominal</label>
                        <input type="number" id="nominal_bayar" name="nominal_bayar"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan nominal pembayaran" min="0" step="500.00" />
                    </div>

                    <!-- Input untuk Kembalian -->
                    <div class="flex flex-col space-y-2">
                        <label for="kembalian" class="text-lg font-semibold">Kembalian</label>
                        <input type="number" id="kembalian" name="kembalian"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Kembalian" readonly />
                    </div>

                    <!-- Tombol Proses Bayar -->
                    <div class="flex items-center space-x-4">
                        <button type="button"
                            class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700"
                            onclick="window.location='{{ route('penjualan.index') }}'">Cancel</button>
                        <button id="bayar-btn"
                            class="bg-green-600 font-semibold text-white px-6 py-2 rounded-lg shadow hover:bg-green-700">
                            Bayar
                        </button>
                    </div>

                </div>

                <!-- Tombol Proses Bayar -->
            </div>
        </div>
    </div>
    </div>

    <script>
        function updateDateTime() {
            // Mendapatkan tanggal dan waktu saat ini
            const currentDate = new Date();

            // Format tanggal menjadi YYYY-MM-DD
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Menambahkan 1 untuk bulan
            const day = String(currentDate.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;

            // Set nilai default pada input tanggal
            document.getElementById('tanggal_transaksi').value = formattedDate;

            // Menampilkan waktu saat ini dalam format HH:mm:ss
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            const formattedTime = `${hours}:${minutes}`;

            // Set nilai waktu di elemen #currentTime
            document.getElementById('currentTime').innerText = `Waktu Saat Ini: ${formattedTime}`;
        }

        // Memanggil fungsi untuk mengupdate tanggal dan waktu
        updateDateTime();

        // Mengupdate waktu setiap detik agar tetap real-time
        setInterval(updateDateTime, 1000);
        let menuDipilih = []; // Array untuk menyimpan bahan baku yang dipilih
        let totalBayar = 0;
        let total = 0;

        // Menambahkan event listener untuk tombol "Pilih Produk"
        document.getElementById('pilih-produk-btn').addEventListener('click', () => {
            console.log('Tombol Pilih Produk diklik');
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden'); // Menampilkan modal
        });

        document.getElementById('pilih-pelanggan-btn').addEventListener('click', () => {
            console.log('Tombol Pilih Pelanggan diklik');
            const modal = document.getElementById('pelanggan-modal');
            modal.classList.remove('hidden'); // Menampilkan modal
        });

        // Fungsi untuk memilih bahan baku
        function pilihMenu(idMenu, namaMenu, harga) {
            const jumlah = document.getElementById('jumlah_menu').value;
            if (jumlah <= 0) {
                alert("Jumlah tidak valid");
                return;
            }

            const subtotal = harga * jumlah;

            // Menambah bahan baku yang dipilih ke dalam array
            menuDipilih.push({
                id_menu: idMenu,
                nama: namaMenu,
                jumlah: jumlah,
                harga: harga,
                subtotal: subtotal
            });

            // Menampilkan bahan baku yang dipilih di tabel transaksi
            tampilkanTransaksi();

            // Menutup modal
            document.getElementById('modal').classList.add('hidden');
        }

        function pilihPelanggan(idPelanggan, namaPelanggan, progresTransaksi, namaMember, diskonMember) {
            document.getElementById('pelanggan').value = namaPelanggan; // Menampilkan nama pelanggan
            document.getElementById('member').value = namaMember;
            document.getElementById('diskon_member').value = `Diskon: ${diskonMember * 100}%`;
            document.getElementById('id_pelanggan').value = idPelanggan; // Menampilkan nama pelanggan
            document.getElementById('pelanggan-modal').classList.add('hidden'); // Menutup modal pelanggan

            hitungTotal();

            document.getElementById('pelanggan-modal').classList.add('hidden');
        }

        document.getElementById('close-pelanggan-modal').addEventListener('click', function() {
            document.getElementById('pelanggan-modal').classList.add('hidden');
        });

        // Menampilkan modal pelanggan saat tombol pilih pelanggan diklik
        document.getElementById('pilih-pelanggan-btn').addEventListener('click', function() {
            document.getElementById('pelanggan-modal').classList.remove('hidden'); // Menampilkan modal
        });

        // Menampilkan modal menu saat tombol pilih produk diklik
        document.getElementById('pilih-produk-btn').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden'); // Menampilkan modal
        });

        // Fungsi untuk menampilkan transaksi di tabel
        // Fungsi untuk menampilkan transaksi di tabel
        function tampilkanTransaksi() {
            const transaksiList = document.getElementById('transaksi-list');
            transaksiList.innerHTML = '';

            menuDipilih.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td class="border border-gray-300 px-4 py-2">${index + 1}</td>
            <td class="border border-gray-300 px-4 py-2">${item.nama}</td>
            <td class="border border-gray-300 px-4 py-2">${item.jumlah}</td>
            <td class="border border-gray-300 px-4 py-2">Rp ${item.harga.toLocaleString()}</td>
            <td class="border border-gray-300 px-4 py-2">Rp ${item.subtotal.toLocaleString()}</td>
            <td class="border border-gray-300 px-4 py-2">
                <div class="flex justify-center space-x-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" onclick="editTransaksi(${index})">Ubah</button>
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200" onclick="hapusTransaksi(${index})">Hapus</button>
                </div>
            </td>
        `;
                transaksiList.appendChild(row);
            });

            // Panggil fungsi hitungTotal untuk memperbarui subtotal dan total bayar
            hitungTotal();
        }


        // Update total bayar
        totalBayar = total;
        document.getElementById('total-bayar').textContent = `${totalBayar}`;

        // Fungsi untuk menghapus transaksi
        function hapusTransaksi(index) {
            menuDipilih.splice(index, 1);
            tampilkanTransaksi();
        }

        function editTransaksi(index) {
            // Pastikan modal edit ada dan tampil
            const modal = document.getElementById('edit-modal');
            modal.classList.remove('hidden'); // Menampilkan modal

            // Menampilkan data transaksi yang akan diedit
            const transaksi = menuDipilih[index];
            document.getElementById('edit-bahan-baku').value = transaksi.nama;
            document.getElementById('edit-jumlah').value = transaksi.jumlah;

            // Menyimpan index yang sedang diedit
            document.getElementById('save-edit-btn').onclick = function() {
                const jumlahBaru = document.getElementById('edit-jumlah').value;
                if (jumlahBaru <= 0) {
                    alert("Jumlah tidak valid");
                    return;
                }

                // Update data transaksi yang sudah diedit
                const subtotalBaru = transaksi.harga * jumlahBaru;
                menuDipilih[index] = {
                    ...transaksi,
                    jumlah: jumlahBaru,
                    subtotal: subtotalBaru
                };

                // Menutup modal dan memperbarui tampilan tabel
                document.getElementById('edit-modal').classList.add('hidden');
                tampilkanTransaksi();
            };
        }

        // Menutup modal edit saat tombol tutup diklik
        document.getElementById('close-edit-modal').addEventListener('click', function() {
            document.getElementById('edit-modal').classList.add('hidden');
        });

        // Menutup modal saat tombol tutup diklik
        document.getElementById('close-modal').addEventListener('click', () => {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden'); // Menutup modal
        });
        console.log(menuDipilih);

        // Menangani klik tombol "Proses Bayar"
        document.querySelector('#bayar-btn').addEventListener('click', function() {
            const totalHarga = parseFloat(document.getElementById('total-bayar').innerText.replace('Rp ', '')
                .replace('.', '').trim());
            const nominalBayar = parseFloat(document.getElementById('nominal_bayar').value);

            if (isNaN(nominalBayar) || nominalBayar <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Nominal tidak valid!',
                    text: 'Masukkan nominal yang valid untuk pembayaran.'
                });
                return;
            }

            const kembalian = nominalBayar - totalHarga;

            // Validasi Pembayaran
            if (kembalian < 0) {
                // Jika nominal bayar kurang dari total harga, tampilkan pesan kesalahan
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Kurang!',
                    text: `Nominal yang dimasukkan kurang dari total harga. Sisa pembayaran: Rp ${Math.abs(kembalian).toLocaleString()}`
                });
                return; // Jangan lanjutkan jika pembayaran kurang
            } else {
                // Jika pembayaran cukup, tampilkan kembalian dan lanjutkan
                document.getElementById('kembalian').value = kembalian.toLocaleString();
            }

            // Validasi data transaksi sebelum mengirim ke server
            const transaksiData = menuDipilih.map(item => ({
                id_menu: item.id_menu,
                jumlah: item.jumlah,
                subtotal: item.subtotal
            }));

            const tanggalTransaksi = document.getElementById('tanggal_transaksi').value;
            const idUser = 1; // Ambil ID pengguna yang terautentikasi
            const idPelanggan = document.getElementById('id_pelanggan').value; // Ambil ID pelanggan
            const nomorMeja = document.getElementById('nomor_meja').value;

            if (!tanggalTransaksi) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal transaksi harus diisi!'
                });
                return;
            }

            if (transaksiData.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tidak ada menu yang dipilih!'
                });
                return;
            }

            if (!nomorMeja) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nomor meja harus diisi!'
                });
                return;
            }

            if (!idPelanggan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pelanggan harus dipilih!'
                });
                return;
            }

            // Kirim data transaksi ke backend jika semuanya valid
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: `Kembalian Anda: Rp ${kembalian.toLocaleString()}`
            }).then(() => {
                // Pengiriman data transaksi ke backend hanya jika pembayaran berhasil
                fetch('/penjualan', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            tanggal: tanggalTransaksi,
                            menu: transaksiData,
                            id_user: idUser,
                            id_pelanggan: idPelanggan,
                            nomor_meja: nomorMeja
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi Berhasil!',
                                text: 'Transaksi berhasil disimpan.',
                                showCancelButton: true,
                                confirmButtonText: 'OK',
                                cancelButtonText: 'Print Nota',
                                reverseButtons: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to the main page after confirmation
                                    window.location.href = '/penjualan';
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Redirect to the Print Nota page
                                    window.location.href = `/nota/${data.id_transaksi}`;
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan!',
                                text: 'Terjadi kesalahan, coba lagi!'
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan!',
                            text: 'Terjadi kesalahan, coba lagi!'
                        });
                    });
            });
        });


        function hitungTotal() {
            // Hitung subtotal
            let subtotal = menuDipilih.reduce((total, item) => total + item.subtotal, 0);

            // Ambil diskon dari input 'diskon_member'
            const diskonInput = document.getElementById('diskon_member').value;
            const diskonPersen = parseFloat(diskonInput.replace(/[^0-9.-]+/g, '')) || 0;
            const diskon = (diskonPersen / 100) * subtotal;

            // Hitung total bayar
            const totalBayar = subtotal - diskon;

            // Update tampilan subtotal dan total bayar
            document.getElementById('subtotal').value = `Rp ${subtotal.toLocaleString()}`;
            document.getElementById('total-bayar').textContent = `Rp ${totalBayar.toLocaleString()}`;

            return {
                subtotal,
                diskon,
                totalBayar
            };
        }
    </script>
</body>

</html>
