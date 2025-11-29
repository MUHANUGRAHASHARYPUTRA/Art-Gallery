<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Admin Overview</h1>
                <p class="text-gray-500 mt-1">System performance and pending tasks.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Users</div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Artworks</div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_artworks'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Categories</div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['total_categories'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
                    @if($stats['pending_curators'] > 0)
                        <div class="absolute right-0 top-0 w-2 h-full bg-red-500"></div>
                    @endif
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Pending Curators</div>
                    <div class="text-4xl font-black text-gray-900">{{ $stats['pending_curators'] }}</div>
                    @if($stats['pending_curators'] > 0)
                        <a href="{{ route('admin.users') }}" class="text-xs font-bold text-red-500 hover:underline mt-2 block">Action Needed</a>
                    @endif
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-900 mb-6">Control Center</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('admin.categories') }}" class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Category Manager</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Create, edit, or delete artwork categories to keep the platform organized.</p>
                </a>

                <a href="{{ route('admin.users') }}" class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">User & Curator</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Manage user roles and approve new curator applications.</p>
                </a>

                <a href="{{ route('admin.moderation') }}" class="group bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Moderation Queue</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Review reported content and take action to maintain safety.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>