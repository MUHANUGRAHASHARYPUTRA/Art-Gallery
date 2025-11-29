<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ArtGallery') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white text-gray-900 font-sans flex flex-col min-h-screen overflow-x-hidden">

    <x-public-navbar />

    <main class="flex-grow pt-28">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-16">
            <div class="flex flex-col md:flex-row items-end justify-between gap-8">
                <div class="max-w-2xl" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="text-5xl md:text-7xl font-black tracking-tighter leading-tight mb-6">
                        Discover. <br>
                        Create. <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Inspire.</span>
                    </h1>
                    <p class="text-lg text-gray-500 font-medium max-w-lg" data-aos="fade-up" data-aos-delay="200">
                        The ultimate platform for digital artists to showcase their portfolio, join challenges, and get
                        discovered.
                    </p>
                </div>

                <div class="w-full md:w-auto overflow-x-auto pb-2 no-scrollbar" data-aos="fade-left"
                    data-aos-delay="400">
                    <div class="flex gap-3">
                        <a href="{{ route('home') }}"
                            class="px-6 py-3 rounded-full text-sm font-bold transition whitespace-nowrap border {{ !request('category') ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                            All Work
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('home', ['category' => $category->slug, 'search' => request('search')]) }}"
                                class="px-6 py-3 rounded-full text-sm font-bold transition whitespace-nowrap border {{ request('category') == $category->slug ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black hover:text-black' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            @if ($artworks->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200"
                    data-aos="fade-in">
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">No artworks found.</h3>
                    <p class="text-gray-500">Be the first to upload something amazing!</p>
                    @auth
                        <a href="{{ route('artworks.create') }}"
                            class="mt-6 px-6 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition">Upload
                            Artwork</a>
                    @endauth
                </div>
            @else
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach ($artworks as $artwork)
                        <div class="break-inside-avoid relative group" data-aos="fade-up" data-aos-offset="100">
                            <div
                                class="rounded-2xl overflow-hidden bg-gray-100 relative shadow-sm hover:shadow-xl transition duration-500 ease-out transform hover:-translate-y-1">
                                <a href="{{ route('artworks.show', $artwork) }}">
                                    <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}"
                                        class="w-full h-auto object-cover transition duration-700 ease-in-out group-hover:scale-105">
                                </a>

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-6 pointer-events-none">
                                    <div
                                        class="transform translate-y-4 group-hover:translate-y-0 transition duration-300 pointer-events-auto">
                                        <h3 class="text-white font-bold text-lg leading-tight mb-1">
                                            {{ $artwork->title }}</h3>
                                        <div class="flex items-center justify-between mt-3">
                                            <a href="{{ route('profile.show', $artwork->user) }}"
                                                class="flex items-center gap-2 hover:opacity-80 transition">
                                                <div
                                                    class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-[10px] text-white font-bold">
                                                    {{ substr($artwork->user->name, 0, 1) }}
                                                </div>
                                                <span
                                                    class="text-gray-300 text-xs font-bold">{{ $artwork->user->name }}</span>
                                            </a>
                                            <div class="flex items-center gap-1 text-white">
                                                <svg class="w-4 h-4 fill-current text-red-500" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                                </svg>
                                                <span class="text-xs font-bold">{{ $artwork->likes->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </main>

    <x-public-footer />

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, // Kecepatan animasi
            once: true, // Animasi hanya sekali saat scroll ke bawah
            offset: 50, // Jarak trigger animasi
        });
    </script>
</body>

</html>
