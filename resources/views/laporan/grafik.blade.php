<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Grafik Laporan</x-header-dashboard>

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

            <!-- Grafik Penjualan dan Pembelian Bulanan -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Grafik Penjualan dan Pembelian Bulanan</h2>
                <canvas id="penjualanPembelianBulanan" width="400" height="200"></canvas>
                <script>
                    var ctx = document.getElementById('penjualanPembelianBulanan').getContext('2d');
                    var penjualanPembelianBulananChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($penjualanBulanan->pluck('bulan')),
                            datasets: [{
                                    label: 'Penjualan',
                                    data: @json($penjualanBulanan->pluck('total')),
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: true,
                                },
                                {
                                    label: 'Pembelian',
                                    data: @json($pembelianBulanan->pluck('total')),
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderWidth: 2,
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Bulan'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total (Rp)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw || 0;
                                            return context.dataset.label + ': Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <!-- Grafik Pengeluaran Tahunan -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Grafik Pengeluaran Tahunan</h2>
                <canvas id="pengeluaranTahunan" width="400" height="200"></canvas>
                <script>
                    var ctx2 = document.getElementById('pengeluaranTahunan').getContext('2d');
                    var pengeluaranTahunanChart = new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: @json($pengeluaranTahunan->pluck('tahun')),
                            datasets: [{
                                label: 'Total Pengeluaran Tahunan',
                                data: @json($pengeluaranTahunan->pluck('total')),
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>

            <!-- Menu Terbanyak -->
            <div>
                <h3 class="text-lg font-semibold">Menu dengan Penjualan Terbanyak</h3>
                <p>{{ $menuTerbanyak->nama_menu }} - Terjual
                    {{ $menuTerbanyak->detailTransaksiPenjualan->sum('jumlah_menu') }} kali</p>
            </div>
        </main>
    </div>

</body>

</html>
