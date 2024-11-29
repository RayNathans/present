<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@heroicons/react/outline" defer></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <x-header-dashboard>Laporan</x-header-dashboard>

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

            <!-- Pagination Links -->
            {{-- <div class="mt-4 flex justify-center">
                {{ $menus->links('pagination::tailwind') }}
            </div> --}}
        </main>
    </div>

</body>

</html>
