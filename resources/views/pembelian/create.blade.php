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
            <h1 class="text-2xl font-bold">Tambah Pembelian</h1>
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
            <div class="grid grid-cols-2 gap-4">
                <!-- Tanggal -->
                <div>
                    <label for="tanggal_transaksi" class="block font-semibold text-gray-700">Tanggal</label>
                    <input type="date" id="tanggal_transaksi" class="w-full px-4 py-2 border rounded-lg" />
                    @error('tanggal_transaksi')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Pegawai -->
                <div>
                    <label for="pegawai" class="block font-semibold text-gray-700">Pegawai</label>
                    <input type="text" id="pegawai"
                        class="w-full px-4 py-2 font-semibold border rounded-lg focus:outline-none cursor-default"
                        value="{{ Auth::user()->name }}" placeholder="Nama pegawai" readonly />
                </div>
            </div>

            <div class="mt-4">
                <!-- Pilihan -->
                <button class="bg-gray-900 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 mr-2"
                    id="pilih-produk-btn">Pilih Produk</button>
            </div>

            <!-- Modal untuk memilih bahan baku -->
            <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-auto max-w-md mx-auto mt-10">
                    <h2 class="text-xl font-semibold mb-4 text-center text-gray-800">Pilih Bahan Baku</h2>

                    <table class="min-w-full table-auto text-gray-800 ">
                        <thead>
                            <tr class="border-b">
                                <th class="px-0 py-3 text-left">No</th>
                                <th class="px-0 py-3 text-left">Nama Bahan Baku</th>
                                <th class="px-0 py-3 text-left">Harga</th>
                                <th class="px-0 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bahanBakus as $bahan)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-0 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-0 py-3">{{ $bahan->nama_bahan_baku }}</td>
                                    <td class="px-0 py-3">Rp {{ number_format($bahan->harga_bahan_baku, 0, ',', '.') }}
                                    </td>
                                    <td class="px-0 py-3">
                                        <button
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                            onclick="pilihBahan({{ $bahan->id }}, '{{ $bahan->nama_bahan_baku }}', {{ $bahan->harga_bahan_baku }})">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        <tbody>
                    </table>

                    <!-- Input Jumlah -->
                    <div class="mt-6">
                        <label for="jumlah-bahan" class="block text-gray-700 mb-2">Jumlah</label>
                        <input type="number" id="jumlah_per_bahan_baku"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Masukkan jumlah" min="1">
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <button id="close-modal"
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
                        <label for="edit-bahan-baku" class="block text-gray-700 mb-2">Nama Bahan Baku</label>
                        <input type="text" id="edit-bahan-baku"
                            class="w-full px-4 py-2 border rounded-lg bg-gray-200 focus:outline-none cursor-default"
                            readonly />
                    </div>
                    <div class="mt-4">
                        <label for="edit-jumlah" class="block text-gray-700 mb-2">Jumlah</label>
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
                            <th class="border border-gray-300 px-4 py-2">Produk / Bahan Baku</th>
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
                    <p class="text-lg font-bold">Total Pembelian</p>
                <div class="flex row-auto">
                    <p class="text-xl text-gray-700 px-4 py-2 font-bold">Rp</p>
                    <p class="text-2xl text-gray-700 w-full px-4 py-2 border border-black rounded-lg bg-gray-200 focus:outline-none cursor-default font-medium" id="total-bayar">0,00</p>
                </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="button"
                            class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700"
                            onclick="window.location='{{ route('pembelian.index') }}'">Cancel</button>
                    <button id="bayar-btn"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">Proses
                        Bayar</button>
                </div>
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
        let bahanBakuDipilih = []; // Array untuk menyimpan bahan baku yang dipilih
        let totalBayar = 0;
        let total = 0;

        // Menambahkan event listener untuk tombol "Pilih Produk"
        document.getElementById('pilih-produk-btn').addEventListener('click', () => {
            console.log('Tombol Pilih Produk diklik');
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden'); // Menampilkan modal
        });

        // Fungsi untuk memilih bahan baku
        function pilihBahan(idBahan, namaBahan, harga) {
            const jumlah = document.getElementById('jumlah_per_bahan_baku').value;
            if (jumlah <= 0) {
                alert("Jumlah tidak valid");
                return;
            }

            const subtotal = harga * jumlah;

            // Menambah bahan baku yang dipilih ke dalam array
            bahanBakuDipilih.push({
                id_bahan_baku: idBahan,
                nama: namaBahan,
                jumlah: jumlah,
                harga: harga,
                subtotal: subtotal
            });

            // Menampilkan bahan baku yang dipilih di tabel transaksi
            tampilkanTransaksi();

            // Menutup modal
            document.getElementById('modal').classList.add('hidden');
        }

        // Fungsi untuk menampilkan transaksi di tabel
        // Fungsi untuk menampilkan transaksi di tabel
        function tampilkanTransaksi() {
            const transaksiList = document.getElementById('transaksi-list');
            transaksiList.innerHTML = '';

            let total = 0;
            bahanBakuDipilih.forEach((item, index) => {
                total += item.subtotal;

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

            // Update total bayar
            totalBayar = total;
            document.getElementById('total-bayar').textContent = `${totalBayar.toLocaleString()}`;
        }


        // Update total bayar
        totalBayar = total;
        document.getElementById('total-bayar').textContent = `${totalBayar}`;

        // Fungsi untuk menghapus transaksi
        function hapusTransaksi(index) {
            bahanBakuDipilih.splice(index, 1);
            tampilkanTransaksi();
        }

        function editTransaksi(index) {
            // Pastikan modal edit ada dan tampil
            const modal = document.getElementById('edit-modal');
            modal.classList.remove('hidden'); // Menampilkan modal

            // Menampilkan data transaksi yang akan diedit
            const transaksi = bahanBakuDipilih[index];
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
                bahanBakuDipilih[index] = {
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
        console.log(bahanBakuDipilih);

        // Menangani klik tombol "Proses Bayar"
        document.querySelector('#bayar-btn').addEventListener('click', function() {
            // Ambil data transaksi yang ada
            const transaksiData = bahanBakuDipilih.map(item => ({
                id_bahan: item.id_bahan_baku, // Sesuaikan dengan ID atau informasi yang benar
                jumlah: item.jumlah,
                subtotal: item.subtotal
            }));

            const tanggalTransaksi = document.getElementById('tanggal_transaksi').value;
            const idUser = 1; // Ganti dengan ID pengguna yang terautentikasi

            // Validasi
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
                    text: 'Tidak ada bahan baku yang dipilih!'
                });
                return;
            }

            for (let item of transaksiData) {
                if (item.jumlah <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Jumlah bahan baku tidak valid!'
                    });
                    return;
                }
            }

            // Kirim data transaksi ke backend
            fetch('/pembelian', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        tanggal: tanggalTransaksi,
                        bahan: transaksiData,
                        id_user: idUser // Ganti dengan ID user yang valid jika perlu
                    })
                })
                .then(response => {
                    // Cek status respons
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Debugging response
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: 'Transaksi berhasil ditambahkan!'
                        }).then(() => {
                            window.location.href = '/pembelian'; // Redirect setelah berhasil
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
    </script>
</body>

</html>
