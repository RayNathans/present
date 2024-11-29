<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Gaya untuk tabel dan pencarian */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body class="h-full overflow-hidden">
    <div class="bg-white" x-data="{ isOpen: false }">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="logo.png" alt="">
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button @click="isOpen = !isOpen" type="button"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Open main menu</span>
                        <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="/"
                        class="{{ request()->is('/') ? 'underline' : 'none' }} text-xl font-semibold text-gray-900">Home</a>
                    <a href="menus"
                        class="{{ request()->is('menus') ? 'underline' : 'none' }} text-xl font-semibold text-gray-900">Menu</a>
                    <a href="members"
                        class="{{ request()->is('members') ? 'underline' : 'none' }} text-xl font-semibold text-gray-900">Member</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="login"
                        class="text-xl font-semibold px-6 py-2 text-white bg-[rgba(53,179,78)] rounded-lg hover:bg-green-700">Log
                        in <span aria-hidden="true"></span></a>
                </div>
            </nav>
            <!-- Mobile menu, show/hide based on menu open state. -->
            <div x-show="isOpen" class="lg:hidden" role="dialog" aria-modal="true">
                <!-- Background backdrop, show/hide based on slide-over state. -->
                <div class="fixed inset-0 z-50"></div>
                <div
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="/" class="-m-1.5 p-1.5">
                            <span class="sr-only">Your Company</span>
                            <img class="h-8 w-auto" src="logo.png" alt="">
                        </a>
                        <button @click="isOpen = !isOpen" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                            <span class="sr-only">Close menu</span>
                            <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="/"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Home</a>
                                <a href="/menus"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Menu</a>
                                <a href="/members"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Member</a>
                            </div>
                            <div class="py-6">
                                <a href="dashboard"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log
                                    in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="relative h-screen isolate px-6 pt-14 lg:px-8 overflow-hidden">
            <div class="absolute bottom-0 inset-x-0 -z-10 transform-gpu" aria-hidden="true">
                <img src="bg_bawah.png" alt="background"
                    class="w-full sm:h-32 md:h-48 lg:h-64 xl:h-72 object-cover object-bottom">
            </div>

            <div
                class="font-poppins mt-10 py-10 flex flex-col items-center z-10 max-w-xl mx-auto bg-gray-200 rounded-lg">
                <div class="search-container">
                    <x-search route="members.index" />
                </div>

                {{-- Tampilkan pesan berdasarkan kondisi --}}
                @if (isset($message))
                    <div class="text-center py-4">{{ $message }}</div>
                @endif

                {{-- Tampilkan tabel hanya jika ada hasil pencarian --}}
                @if (isset($pelanggans) && $pelanggans->count() > 0)
                    <div class="grid grid-cols-1 gap-6 mt-2">
                        @foreach ($pelanggans as $pelanggan)
                            <div class="bg-white shadow-md rounded-lg p-6">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="flex flex-col items-center">
                                        <p class="text-4xl font-bold text-gray-800">{{ $pelanggan->nama_pelanggan }}
                                        <p
                                            class="px-2 py-1 rounded-lg text-xl font-semibold 
                                                        {{ $pelanggan->member ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $pelanggan->member ? $pelanggan->member->nama_member : 'Non-Member' }}
                                        </p>
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-center mt-4">
                                        <p class="text-gray-800 text-xl font-semibold">Progress Transaksi:</p>
                                        <p class="font-semibold text-xl">Rp
                                            {{ number_format($pelanggan->progressTransaksi, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex flex-col items-center mt-4">
                                        <p class="text-gray-800 text-xl font-semibold">Status:</p>
                                        <p class="mt-1">
                                            <span
                                                class="px-2 py-1 rounded-lg text-xl font-semibold 
                                                {{ $pelanggan->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $pelanggan->status ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                @endif
            </div>
        </div>
</body>

</html>
