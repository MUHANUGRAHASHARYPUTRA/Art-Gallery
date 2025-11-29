<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ArtGallery') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-x-hidden">
        <div class="min-h-screen flex bg-white">
            
            <div class="hidden lg:block lg:w-1/2 relative overflow-hidden bg-black">
                <img src="https://images.unsplash.com/photo-1579783902614-a3fb39279c0f?w=1600&q=80" 
                     class="absolute inset-0 h-full w-full object-cover opacity-80"
                     data-aos="zoom-out" data-aos-duration="1500">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-16">
                    <h2 class="text-white text-5xl font-black tracking-tighter mb-4" data-aos="fade-up" data-aos-delay="300">Inspire & <br>Be Inspired.</h2>
                    <p class="text-gray-300 text-lg" data-aos="fade-up" data-aos-delay="500">Join the world's most vibrant community of digital artists and creators.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-white">
                <div class="w-full max-w-md space-y-8" data-aos="fade-left" data-aos-duration="1000">
                    <div class="text-center lg:text-left">
                        <a href="/" class="text-3xl font-black tracking-tighter text-gray-900">
                            Hi<span class="text-indigo-600">YouCan</span>.
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>

        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>