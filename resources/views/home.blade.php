<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                    <a href="/menus"
                        class="{{ request()->is('/menus') ? 'underline' : 'none' }} text-xl font-semibold text-gray-900">Menu</a>
                    <a href="/members"
                        class="{{ request()->is('/members') ? 'underline' : 'none' }} text-xl font-semibold text-gray-900">Member</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <a href="login" class="text-xl font-semibold px-6 py-2 text-white bg-[rgba(53,179,78)] rounded-lg hover:bg-green-700">Log in <span
                            aria-hidden="true"></span></a>
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
                                <a href="{{ route('login') }}" 
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">
                                Log in
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="relative h-screen isolate px-6 pt-14 lg:px-8" x-data="imageSlider()" x-init="initSlider()">
            <div class="absolute bottom-0 inset-x-0 -z-10 transform-gpu overflow-hidden" aria-hidden="true">
                <img src="bg_bawah.png" alt="background"
                    class="w-full sm:h-32 md:h-48 lg:h-64 xl:h-72 object-cover object-bottom">
            </div>
            <div
                class="font-poppins py-10 sm:py-20 lg:py-36 flex flex-col lg:flex-row-reverse items-center z-10 justify-between gap-6 lg:gap-0">

                <!-- Container Gambar untuk Slide -->
                <div class="relative w-full max-w-xl h-96 overflow-hidden transition duration-1000">
                    <template x-for="(image, index) in images" :key="index">
                        <img :src="image"
                            :class="{ 'opacity-100 scale-100': currentImageIndex ===
                                index, 'opacity-0 scale-0': currentImageIndex !== index }"
                            class="absolute inset-0 w-full h-full object-contain transition-all duration-500 ease-in-out"
                            alt="Slide Image">
                    </template>
                </div>


                <!-- Teks -->
                <div class="max-w-3xl text-center lg:text-left">
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-gray-900">Menghadirkan
                        Cita Rasa</h1>
                    <h2 class="mt-2 text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900">Yang
                        Menggugah Selera</h2>
                    <p class="mt-6 text-lg font-medium text-gray-500 sm:text-2xl/8">Datang dan rasakan sendiri
                        bagaimana kami menyajikan kelezatan di setiap hidangan.</p>
                </div>
            </div>
        </div>

        <script>
            function imageSlider() {
                return {
                    images: ['nasgor.png', 'ayam.png', 'telur.png'],
                    currentImageIndex: 0,
                    fadeIn: true,
                    intervalDuration: 4500,
                    initSlider() {
                        setInterval(() => {
                            this.fadeIn = false;
                            setTimeout(() => {
                                this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
                                this.fadeIn = true;
                            }, 1500);
                        }, this.intervalDuration);
                    }
                }
            }
        </script>

        <style>
            .scale-100 {
                transform: scale(1);
            }

            .scale-0 {
                transform: scale(0);
            }

            .opacity-100 {
                opacity: 1;
            }

            .opacity-0 {
                opacity: 0;
            }
        </style>

    </div>

</body>

</html>
