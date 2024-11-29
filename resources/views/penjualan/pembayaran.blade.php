<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPOLUBOGO | Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-qrcode/1.0/jquery.qrcode.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-5">Payment</h1>

            <div class="container mx-auto">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Penjualan</h2>

                    <!-- Informasi Penjualan -->
                    <div class="mt-6 space-y-4 border-b border-t border-gray-200 py-8 rounded-lg bg-gray-50 p-6">
                        <h4 class="text-lg font-semibold text-gray-900">Informasi Penjualan</h4>
                        <dl>
                            <dt class="text-base font-medium text-gray-900">Tanggal</dt>
                            <dd class="mt-1 text-base font-normal text-gray-500">{{ now()->format('l, d M Y') }}</dd>
                        </dl>
                        <dl>
                            <dt class="text-base font-medium text-gray-900">Pelanggan</dt>
                            <dd class="mt-1 text-base font-normal text-gray-500">{{ $customerName }}</dd>
                        </dl>
                        <dl>
                            <dt class="text-base font-medium text-gray-900">Nomor Meja</dt>
                            <dd class="mt-1 text-base font-normal text-gray-500">{{ $tableNumber }}</dd>
                        </dl>
                    </div>

                    <!-- Rincian Transaksi Penjualan -->
                    <div class="mt-6 rounded-lg bg-gray-50 p-6">
                        <div class="relative overflow-x-auto border-b border-gray-200">
                            <table class="w-full text-left font-medium text-gray-900 md:table-fixed">
                                <thead>
                                    <tr>
                                        <th class="py-4">No</th>
                                        <th class="py-4">Nama Menu</th>
                                        <th class="py-4">Jumlah</th>
                                        <th class="py-4 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($selectedMenus as $key => $menu)
                                        <tr>
                                            <td class="py-4">{{ $key + 1 }}</td>
                                            <td class="py-4">{{ $menu['name'] }}</td>
                                            <td class="py-4">{{ $menu['quantity'] }}</td>
                                            <td class="py-4 text-right">Rp
                                                {{ number_format($menu['price'] * $menu['quantity'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Bayar -->
                        <div class="mt-4 space-y-6">
                            <h4 class="text-xl font-semibold text-gray-900">Total Bayar</h4>
                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2">
                                <dt class="text-lg font-bold text-gray-900">Total</dt>
                                <dd class="text-lg font-bold text-gray-900">Rp
                                    {{ number_format($totalAmount, 0, ',', '.') }}</dd>
                            </dl>
                        </div>

                        <!-- Tombol Konfirmasi Pembayaran -->
                        <h2 class="text-lg font-semibold mb-4">Payment Options</h2>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="radio" name="paymentMethod" value="cash" checked>
                                <span class="ml-2">Cash</span>
                            </label>
                            <label class="flex items-center mt-2">
                                <input type="radio" name="paymentMethod" value="qris">
                                <span class="ml-2">QRIS</span>
                            </label>
                        </div>
                        <div class="my-5">
                            <button id="confirmPaymentButton"
                                class="bg-green-500 text-white w-full py-2 rounded-md hover:bg-green-600">
                                Confirm Payment
                            </button>
                            <button id="printReceiptButton"
                                class="bg-blue-500 text-white w-full py-2 rounded-md hover:bg-blue-600">
                                Print Receipt
                            </button>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div id="qrisSection" class="hidden mt-4">
                        <h4 class="text-lg font-semibold mb-2">QRIS Code</h4>
                        <div id="qrisCode" class="border p-4 rounded-lg"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Data Dinamis dari Backend
        const selectedMenus = @json($selectedMenus ?? []);
        const transactionId = @json($transactionId ?? '');
        const customerId = @json(session('customerId') ?? '');
        const tableNumber = @json(session('tableNumber') ?? '');
        const totalAmount = '{{ $totalAmount ?? 0 }}';

        // Debugging
        console.log("Selected Menus:", selectedMenus);
        console.log("Transaction ID:", transactionId);
        console.log("Customer ID:", customerId);
        console.log("Total Amount:", totalAmount);
        console.log("Table Number:", tableNumber);

        document.getElementById('confirmPaymentButton').addEventListener('click', function() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            const data = {
                transaction_id: transactionId, // Pastikan transactionId sudah ada dan valid
                customer_id: customerId, // Pastikan customerId sudah ada dan valid
                total_amount: totalAmount, // Pastikan totalAmount sudah ada dan valid
                table_number: tableNumber // Pastikan tableNumber sudah ada dan valid
            };

            // Jika memilih metode pembayaran cash
            if (paymentMethod === 'cash') {
                // Mengirim data ke server untuk konfirmasi pembayaran
                fetch('/penjualan/confirm-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content // CSRF Token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Pembayaran berhasil!",
                                text: "Pembayaran berhasil dikonfirmasi.",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                // Redirect kembali ke halaman penjualan setelah sukses
                                window.location.href =
                                "/penjualan"; // Arahkan kembali ke halaman penjualan
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal!",
                                text: data.message || "Terjadi kesalahan, coba lagi.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Terjadi kesalahan:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan, coba lagi!",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    });
            } else if (paymentMethod === 'qris') {
                // Jika memilih metode pembayaran QRIS
                const qrisData = `Payment for transaction ID: ${transactionId}`;
                console.log("QRIS Data:", qrisData);

                const qrisElement = $('#qrisCode');
                if (qrisElement.length === 0) {
                    console.error("Elemen QRIS dengan ID 'qrisCode' tidak ditemukan.");
                } else {
                    qrisElement.empty().qrcode({
                        width: 128,
                        height: 128,
                        text: qrisData
                    });
                    document.getElementById('qrisSection').classList.remove('hidden');
                }
            }
        });


        document.getElementById('printReceiptButton').addEventListener('click', function() {
            window.location.href = `/print-receipt/${transactionId}`;
        });
    </script>

</body>

</html>
