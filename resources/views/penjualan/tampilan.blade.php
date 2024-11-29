    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SIPOLUBOGO | Penjualan</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body class="bg-gray-100 font-sans leading-normal tracking-normal">

        <div class="flex min-h-screen">

            <!-- Sidebar -->
            <x-sidebar></x-sidebar>

            <!-- Content Area -->
            <main class="flex-1 p-8">
                <!-- Header -->
                <x-header-dashboard>Penjualan</x-header-dashboard>

                <div class="container mx-auto mt-10 flex">

                    <!-- Data Menu -->
                    <div class="w-3/4 pr-4">
                        <h1 class="text-2xl font-bold mb-5">Tampilan Penjualan</h1>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($menus as $menu)
                                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $menu->gambar_menu) }}"
                                        alt="{{ $menu->nama_menu }} "
                                        class="w-full h-auto max-h-32 object-contain rounded-md mb-3 cursor-pointer"
                                        onclick="incrementQuantity('{{ $menu->id }}', '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">
                                    <div class="flex flex-col items-center w-full mb-2">
                                        <h2 class="font-semibold text-lg text-left">{{ $menu->nama_menu }}</h2>
                                        <p class="text-gray-700 text-right">
                                            {{ number_format($menu->harga_menu, 0, ',', '.') }} IDR</p>
                                    </div>
                                    <div class="flex items-center">
                                        <button type="button"
                                            class="bg-red-500 text-white w-9 h-9 flex items-center justify-center rounded-full hover:bg-red-600 mr-1"
                                            onclick="decrementQuantity('{{ $menu->id }}', '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">-</button>
                                        <input type="number" id="quantity_{{ $menu->id }}" value="0"
                                            class="w-20 h-10 text-center border border-gray-300 rounded-full"
                                            min="0"
                                            oninput="updateQuantity('{{ $menu->id }}', '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">
                                        <button type="button"
                                            class="bg-green-500 text-white w-9 h-9 flex items-center justify-center rounded-full hover:bg-green-600 ml-1"
                                            onclick="incrementQuantity('{{ $menu->id }}', '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sidebar Kanan -->
                    <aside class="w-1/4 bg-gray-300 rounded-lg shadow-md p-4 ml-4 flex flex-col justify-between">
                        <div>
                            <button
                                class="bg-green-400 font-semibold text-white w-full py-2 rounded-xl mb-5 hover:bg-green-600"
                                onclick="showAddCustomerModal()">
                                Tambah Pelanggan
                            </button>
                            <div class="bg-white rounded-lg">
                                <div class="p-4">
                                    <div id="selectedMenus" class="text-gray-900 mb-2">
                                        <p>0 Produk</p>
                                    </div>
                                    <h2 class="text-lg font-semibold mb-2">Nama Pelanggan (Member)</h2>

                                    <!-- Dropdown Pelanggan dengan Select2 -->
                                    <select id="customerName"
                                        class="border border-gray-300 rounded-full p-2 mb-2 w-full">
                                        <option value="">Pilih Nama Pelanggan</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <h2 class="text-lg font-semibold mb-2">Nomor Meja</h2>
                                    <input type="number" id="nomor_meja"
                                        class="border border-gray-300 rounded-full p-2 mb-4 w-full"
                                        placeholder="Masukkan nomor meja">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-300 pt-4">
                            <button class="bg-green-400 text-white w-full py-2 rounded-full hover:bg-green-600"
                                onclick="proceedToPayment()">
                                <p class="text-lg font-semibold">Bayar: <span id="payAmount">Rp 0</span></p>
                            </button>
                        </div>
                    </aside>
                </div>
            </main>
        </div>

        <!-- Modal Tambah Pelanggan -->
        <div id="addCustomerModal" class="hidden">
            <div class="fixed inset-0 flex bg-gray-900 bg-opacity-50 items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-1/3">
                    <h3 class="text-xl font-semibold mb-4">Tambah Pelanggan</h3>
                    <form id="addCustomerForm">
                        <div class="mb-4">
                            <label for="customerNameInput" class="block text-sm font-semibold">Nama Pelanggan</label>
                            <input type="text" id="customerNameInput"
                                class="w-full border border-gray-300 p-2 rounded-md" required>
                            <p id="nameError" class="text-red-500 text-sm mt-1 hidden">Nama pelanggan tidak boleh
                                kosong.</p>
                        </div>
                        <div class="mb-4">
                            <label for="customerPhoneInput" class="block text-sm font-semibold">Nomor Telepon</label>
                            <input type="text" id="customerPhoneInput"
                                class="w-full border border-gray-300 p-2 rounded-md">
                            <p id="phoneError" class="text-red-500 text-sm mt-1 hidden">Nomor telepon harus terdiri dari
                                minimal 12 digit.</p>
                        </div>
                        <div class="flex justify-between gap-5">
                            <button type="submit"
                                class="bg-green-500 text-white  py-2 px-4 mt-4 w-full rounded-md hover:bg-green-600">Tambah</button>
                            <button type="button" onclick="closeAddCustomerModal()"
                                class="bg-red-500 text-white  py-2 px-4 mt-4 w-full rounded-md hover:bg-red-600 ml-2">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="paymentModal" class="hidden opacity-0 translate-y-[-100%] transition-all duration-500 ease-out">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-1/2" id="modalContent">
                    <h3 class="text-xl font-semibold mb-4">Detail Transaksi Penjualan</h3>
                    <div id="paymentDetails" class="mb-4">
                        <!-- Detail transaksi akan diisi melalui JavaScript -->
                    </div>
                    <div class="flex justify-between">
                        <p class="font-semibold">Nama Pelanggan:</p>
                        <p id="customerNamePayment" class="font-semibold">-</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="font-semibold">Total Pembayaran:</p>
                        <p id="totalPayment" class="font-semibold">Rp 0</p>
                    </div>
                    <div class="flex justify-between gap-5">
                        <button onclick="proceedToPayment()"
                            class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 mt-4 w-full">
                            Bayar
                        </button>
                        <button id="cancelButton" type="button"
                            class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 mt-4 w-full">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            let selectedMenus = {};

            function incrementQuantity(menuId, menuName, menuPrice) {
                const quantityInput = document.getElementById(`quantity_${menuId}`);
                let quantity = parseInt(quantityInput.value) || 0;
                quantityInput.value = ++quantity;
                updateSelectedMenus(menuId, menuName, menuPrice, quantity);
            }

            function decrementQuantity(menuId, menuName, menuPrice) {
                const quantityInput = document.getElementById(`quantity_${menuId}`);
                let quantity = parseInt(quantityInput.value) || 0;
                if (quantity > 0) {
                    quantityInput.value = --quantity;
                    updateSelectedMenus(menuId, menuName, menuPrice, quantity);
                }
            }

            function updateSelectedMenus(menuId, menuName, menuPrice, quantity) {
                if (quantity === 0) {
                    delete selectedMenus[menuId];
                } else {
                    selectedMenus[menuId] = {
                        name: menuName,
                        quantity: quantity,
                        price: menuPrice,
                    };
                }
                renderSelectedMenus();
            }

            function renderSelectedMenus() {
                const selectedMenusDiv = document.getElementById('selectedMenus');
                selectedMenusDiv.innerHTML = '';
                let total = 0;
                let totalItems = 0;

                for (const id in selectedMenus) {
                    const {
                        name,
                        quantity,
                        price
                    } = selectedMenus[id];
                    const itemTotal = quantity * price;
                    total += itemTotal;
                    totalItems += quantity;

                    const menuElement = document.createElement('p');
                    menuElement.innerText = `${quantity} ${name} - ${itemTotal.toLocaleString()} IDR`;
                    selectedMenusDiv.appendChild(menuElement);
                }

                selectedMenusDiv.insertAdjacentHTML('afterbegin', `<p>${totalItems} Produk</p>`);
                document.getElementById('payAmount').innerText = `Rp${total.toLocaleString()}`;
            }

            function addCustomer() {
                const customerNameInput = document.getElementById('customerName');
                const tableNumberInput = document.getElementById('tableNumber');

                customerNameInput.value = prompt("Masukkan nama pelanggan:", customerNameInput.value);
                tableNumberInput.value = prompt("Masukkan nomor meja:", tableNumberInput.value);
            }

            function updateQuantity(menuId, menuName, menuPrice) {
                const quantityInput = document.getElementById(`quantity_${menuId}`);
                const quantity = parseInt(quantityInput.value) || 0; // Menggunakan 0 jika input tidak valid
                updateSelectedMenus(menuId, menuName, menuPrice, quantity);
            }
            $(document).ready(function() {
                $('#customerName').select2({
                    placeholder: "Cari nama pelanggan...",
                    allowClear: true
                });
            });

            function showAddCustomerModal() {
                document.getElementById('addCustomerModal').classList.remove('hidden');
            }

            function closeAddCustomerModal() {
                document.getElementById('addCustomerModal').classList.add('hidden');
            }

            function showPaymentDetails() {
                const selectedMenusDiv = document.getElementById('paymentDetails');
                const customerNamePayment = document.getElementById('customerNamePayment');
                const totalPayment = document.getElementById('totalPayment');
                const cancelButton = document.getElementById('cancelButton');
                const modalContent = document.getElementById('modalContent');

                // Mengambil nama pelanggan yang dipilih
                const customerId = document.getElementById('customerName').value;
                const customer = document.querySelector(`#customerName option[value="${customerId}"]`);
                const customerName = customer ? customer.text : "Pelanggan belum dipilih";

                customerNamePayment.innerText = customerName;

                // Menampilkan daftar menu yang dipesan
                let total = 0;
                selectedMenusDiv.innerHTML = ''; // Reset isi detail transaksi

                for (const id in selectedMenus) {
                    const {
                        name,
                        quantity,
                        price
                    } = selectedMenus[id];
                    const itemTotal = quantity * price;
                    total += itemTotal;

                    const menuElement = document.createElement('p');
                    menuElement.innerText = `${quantity} x ${name} - Rp ${itemTotal.toLocaleString()}`;
                    selectedMenusDiv.appendChild(menuElement);
                }

                // Menampilkan total pembayaran
                totalPayment.innerText = `Rp ${total.toLocaleString()}`;

                // Menampilkan modal pembayaran
                document.getElementById('paymentModal').classList.remove('hidden');
                document.getElementById('paymentModal').classList.add('translate-y-0');
                setTimeout(() => {
                    document.getElementById('paymentModal').classList.add('opacity-100');
                }, 10);

                cancelButton.addEventListener('click', function() {
                    paymentModal.classList.remove('opacity-100', 'translate-y-0');
                    paymentModal.classList.add('opacity-0', 'translate-y-[-100%]');
                    setTimeout(function() {
                        paymentModal.classList.add('hidden');
                    }, 500); // Sesuaikan dengan durasi animasi
                });
            }

            // Fungsi untuk menutup modal pembayara

            function checkCartBeforePayment() {
                const customerName = document.getElementById('customerName').value; // Ambil nama pelanggan
                const tableNumber = document.getElementById('nomor_meja').value; // Ambil nomor meja

                // Cek jika keranjang kosong
                if (Object.keys(selectedMenus).length === 0) {
                    Swal.fire({
                        title: "Keranjang Belum Terisi",
                        text: "Silakan tambahkan produk ke keranjang.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
                // Cek jika nama pelanggan belum diisi
                else if (!customerName.trim()) {
                    Swal.fire({
                        title: "Nama Pelanggan Belum Terisi",
                        text: "Silakan masukkan nama pelanggan.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
                // Cek jika nomor meja belum diisi
                else if (!tableNumber.trim()) {
                    Swal.fire({
                        title: "Nomor Meja Belum Terisi",
                        text: "Silakan masukkan nomor meja.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                } else {
                    proceedToPayment(); // Menampilkan rincian pembayaran jika semua valid
                }
            }

            function proceedToPayment() {
                const customerId = document.getElementById('customerName').value;
                const tableNumber = document.getElementById('nomor_meja').value;
                console.log("ID Pelanggan yang dipilih:", customerId);
                


                if (Object.keys(selectedMenus).length === 0) {
                    Swal.fire({
                        title: "Keranjang Belum Terisi",
                        text: "Silakan tambahkan produk ke keranjang.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
                // Cek jika nama pelanggan belum diisi
                else if (!customerId.trim()) {
                    Swal.fire({
                        title: "Nama Pelanggan Belum Terisi",
                        text: "Silakan masukkan nama pelanggan.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
                // Cek jika nomor meja belum diisi
                else if (!tableNumber.trim()) {
                    Swal.fire({
                        title: "Nomor Meja Belum Terisi",
                        text: "Silakan masukkan nomor meja.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // Menyiapkan data untuk dikirim ke backend
                const data = {
                    customer_id: customerId,
                    table_number: tableNumber,
                    selectedMenus: selectedMenus,
                    _token: document.querySelector('meta[name="csrf-token"]').content // CSRF Token
                };

                // Mengirimkan data transaksi penjualan ke backend menggunakan AJAX
                $.ajax({
                    fetch: '/penjualan/store', // Endpoint untuk menyimpan transaksi
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Sukses!",
                                text: "Transaksi berhasil disimpan!",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                // Redirect ke halaman pembayaran setelah berhasil
                                window.location.href =
                                    `/penjualan/pembayaran?customerId=${customerId}&tableNumber=${tableNumber}&menus=${encodeURIComponent(JSON.stringify(selectedMenus))}`;
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal!",
                                text: response.message || "Terjadi kesalahan, coba lagi.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat menyimpan transaksi.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            }



            // Fungsi untuk menambah pelanggan baru
            $('#addCustomerForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting

                const customerName = $('#customerNameInput').val().trim();
                const customerPhone = $('#customerPhoneInput').val().trim();

                // Reset error messages
                $('#nameError').addClass('hidden');
                $('#phoneError').addClass('hidden');

                let isValid = true;

                // Validate customer name
                if (!customerName) {
                    $('#nameError').removeClass('hidden');
                    isValid = false;
                }

                // Validate customer phone number (must be at least 12 digits)
                if (!customerPhone || customerPhone.length < 12 || isNaN(customerPhone)) {
                    $('#phoneError').removeClass('hidden');
                    isValid = false;
                }

                // If there are validation errors, do not proceed with AJAX request
                if (!isValid) {
                    return;
                }

                // If all validations pass, send the data via AJAX
                $.ajax({
                    url: '/pelanggan', // Ganti dengan URL API yang sesuai
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Pastikan token CSRF
                        nama_pelanggan: customerName,
                        noWA: customerPhone,
                    },
                    success: function(response) {
                        // Menambah pelanggan baru ke dropdown
                        $('#customerName').append(new Option(customerName, response.id)).trigger('change');
                        closeAddCustomerModal(); // Menutup modal
                        window.location.reload(); // Refresh halaman untuk melihat perubahan
                    }
                });
            });
        </script>
    </body>

    </html>
