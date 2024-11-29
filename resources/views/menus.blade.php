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
        /* Fade-in and slide-up animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Default state for the animated elements */
        .animated-element {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
    </style>
</head>

<body class="h-full">
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

        <div class="relative h-screen isolate px-6 pt-14 lg:px-8">
            <div class="fixed bottom-0 inset-x-0 -z-10 transform-gpu" aria-hidden="true">
                <img src="bg_bawah.png" alt="background"
                    class="w-full sm:h-32 md:h-48 lg:h-64 xl:h-72 object-cover object-bottom">
            </div>
            <div class="font-poppins py-10 items-center z-10 justify-between gap-6 lg:gap-0">

                <!-- Grid Menu dengan Animasi Scroll -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($menus as $menu)
                        <div x-data="{ isVisible: false }"
                            x-intersect:enter="isVisible = true; $el.classList.add('animate-fade-in-up');"
                            x-intersect:leave="isVisible = false; $el.classList.remove('animate-fade-in-up');"
                            class="animated-element bg-gray-200 rounded-lg shadow-md p-4 flex flex-col items-center transition duration-500 ease-out">
                            <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}"
                                class="w-full h-auto max-h-32 object-contain rounded-lg mb-3 cursor-pointer"
                                onclick="incrementQuantity('{{ $menu->id }}', '{{ $menu->nama_menu }}', {{ $menu->harga_menu }})">
                            <div class="flex flex-col items-center w-full mb-2">
                                <h2 class="font-semibold text-lg text-left">{{ $menu->nama_menu }}</h2>
                                <p class="text-gray-700 text-right">
                                    {{ number_format($menu->harga_menu, 0, ',', '.') }} IDR</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('intersect', (el, {
                expression
            }, {
                evaluateLater
            }) => {
                const evaluate = evaluateLater(expression);
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            evaluate();
                            // Hanya tambahkan animasi saat elemen terlihat
                            el.classList.add('animate-fade-in-up');
                        } else {
                            // Hapus animasi saat elemen tidak terlihat
                            el.classList.remove('animate-fade-in-up');
                        }
                    });
                }, {
                    threshold: 0.2
                });

                observer.observe(el);
            });
        });
    </script>

</body>

</html>
