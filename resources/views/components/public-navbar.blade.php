<nav x-data="{ scrolled: false, mobileOpen: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)" 
     :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-4' : 'bg-transparent py-6'"
     class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-transparent">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center">
            
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-gray-900 flex items-center gap-1">
                <span>Art</span><span class="text-indigo-600">Gallery</span>.
            </a>

            <div class="hidden md:block flex-1 max-w-md mx-8">
                <form action="{{ route('home') }}" method="GET" class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full pl-11 pr-4 py-2.5 rounded-full bg-gray-100 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-0 text-sm transition duration-200" 
                           placeholder="Search artwork...">
                </form>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('artworks.create') }}" class="hidden md:inline-block text-sm font-bold text-gray-900 hover:text-indigo-600 transition">
                            + Submit Work
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full bg-black text-white text-sm font-bold hover:bg-gray-800 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                Sign up
                            </a>
                        @endif
                    @endauth
                @endif

                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" @click.away="mobileOpen = false" class="md:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-full shadow-lg py-4 px-6 flex flex-col gap-4" style="display: none;">
        <form action="{{ route('home') }}" method="GET" class="relative">
            <input type="text" name="search" class="block w-full pl-4 pr-4 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-0 text-sm" placeholder="Search...">
        </form>
        @auth
            <a href="{{ route('artworks.create') }}" class="block text-sm font-bold text-gray-900">Submit Work</a>
        @endauth
    </div>
</nav>