<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPOLUBOGO | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@heroicons/react/outline" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body x-data="{ open: false }" class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Dashboard</x-header-dashboard>

            <!-- Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Members -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
                    <svg class="h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a4 4 0 011.26-3A4 4 0 018 3h8a4 4 0 014 4v10a4 4 0 01-4 4H8a4 4 0 01-4-4V7z" />
                    </svg>
                    <div>
                        <p class="text-lg font-semibold">Total Members</p>
                        <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                    </div>
                </div>

                <!-- Outcome -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
                    <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                    </svg>
                    <div>
                        <p class="text-lg font-semibold">Outcome</p>
                        <p class="text-xl font-bold">Rp {{ number_format($totalOutcome, 2, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Income -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
                    <svg class="h-10 w-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                    </svg>
                    <div>
                        <p class="text-lg font-semibold">Income</p>
                        <p class="text-xl font-bold">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Jumlah Transaksi -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
                    <svg class="h-10 w-10 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 8h4m4 8H5m10 8H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <p class="text-lg font-semibold">Total Transactions</p>
                        <p class="text-2xl font-bold">{{ ($totalTransaksi) }}</p>
                    </div>
                </div>
            </div>

            <!-- Grafik Pendapatan Harian dan Bulanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Grafik Pendapatan Harian -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Pendapatan Harian</h3>
                    <canvas id="dailyRevenueChart"></canvas>
                </div>

                <!-- Grafik Pendapatan Bulanan -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Pendapatan Bulanan</h3>
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Inisialisasi Chart.js -->
    <script>
        // Data untuk Grafik Pendapatan Harian
        const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
        const dailyRevenueChart = new Chart(dailyRevenueCtx, {
            type: 'line',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: [200, 300, 250, 400, 450, 500, 550],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data untuk Grafik Pendapatan Bulanan
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: [1500, 2000, 1800, 2400, 2100, 2500, 3000, 2800, 3200, 3500, 4000, 3700],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
