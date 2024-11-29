<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff;
            box-shadow: 0 10px 60px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 30px 40px;
        }

        h1,
        h2 {
            text-align: center;
            color: #444;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 28px;
        }

        h2 {
            font-size: 18px;
            color: #777;
            margin-top: 0;
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-logo img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header p {
            margin: 0;
            font-size: 16px;
            color: #555;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 15px 20px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        td {
            font-size: 16px;
            color: #555;
        }

        .table-img {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
        }

        /* Totals */
        .totals {
            margin-top: 30px;
        }

        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .totals div span {
            font-size: 16px;
            color: #333;
        }

        .totals div span.value {
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Buttons */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .print-button,
        .back-button {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .print-button {
            background-color: #4caf50;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        .back-button {
            background-color: #e74c3c;
        }

        .back-button:hover {
            background-color: #c0392b;
        }

        @media print {
            .button-group {
                display: none;
            }

            body {
                background-color: white;
                /* White background for printing */
            }

            .container {
                box-shadow: none;
                /* Remove shadow for print */
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-logo">
                <!-- Replace with your logo -->
                <img src="{{ asset('logo.png') }}" alt="Logo Restoran">
            </div>
            <h1>Restoran Kami</h1>
            <h2>Alamat: Jl. Sehat Selalu No.123, Jakarta | Telp: 021-12345678</h2>
        </div>

        <!-- Transaction Details -->
        <h2>Nota No:</strong> {{ $laporanPenjualan->id}}</h2>
        <p><strong>Tanggal:</strong> {{ $laporanPenjualan->tanggal_transaksi->format('d-m-Y H:i') }}</p>
        <p><strong>Pelanggan:</strong> {{ $laporanPenjualan->pelanggan->nama_pelanggan ?? 'Tidak Ada' }}</p>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($laporanPenjualan->detailTransaksiPenjualans as $key => $detail)
                    <tr>
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td class="py-4">
                            <!-- Pastikan gambar dapat diakses di PDF dengan menggunakan public_path() -->
                            <img src="{{ asset('storage/' . $detail->menu->gambar_menu) }}" class="table-img rounded"
                                alt="Product Image">
                            <p>{{ $detail->menu->nama_menu }}</p>
                        </td>
                        <td class="py-4">{{ $detail->jumlah_menu }}</td>
                        <td class="py-4">Rp {{ number_format($detail->menu->harga_menu, 0, ',', '.') }}</td>
                        <td class="py-4 text-right">Rp {{ number_format($detail->total_harga_per_menu, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals">
            <div>
                <span>Total Bayar:</span>
                <span class="value">Rp {{ number_format($laporanPenjualan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <a href="{{ route('laporan.penjualan') }}" class="back-button">Kembali</a>
            {{-- <button class="print-button" onclick="window.print()">Cetak Nota</button> --}}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah berkunjung ke Restoran Kami.</p>
            <p>Semoga Anda menikmati hidangan kami. Sampai jumpa lagi!</p>
        </div>
    </div>

</body>

</html>
