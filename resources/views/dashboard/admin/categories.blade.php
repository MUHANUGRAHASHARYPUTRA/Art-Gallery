<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-black shadow-sm border border-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                    <p class="text-gray-500">Organize artwork classifications.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    @foreach($categories as $category)
                        <div x-data="{ editing: false, name: '{{ $category->name }}' }" class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group">
                            
                            <div x-show="!editing" class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $category->name }}</h3>
                                <p class="text-xs text-gray-400 font-mono mt-1">/{{ $category->slug }} • {{ $category->artworks_count }} Artworks</p>
                            </div>

                            <form x-show="editing" action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex-1 flex gap-2 mr-4" style="display: none;">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" x-model="name" class="flex-1 px-4 py-2 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-0 transition" required>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold">Save</button>
                                <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold">Cancel</button>
                            </form>

                            <div x-show="!editing" class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition duration-200">
                                <button @click="editing = true" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="bg-black text-white p-8 rounded-3xl shadow-lg sticky top-24">
                        <h3 class="text-xl font-bold mb-4">Add New Category</h3>
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Category Name</label>
                                <input type="text" name="name" class="w-full px-4 py-3 rounded-xl bg-gray-800 border-transparent focus:border-gray-600 focus:ring-0 text-white placeholder-gray-500 transition" placeholder="e.g. Digital Art" required>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <button type="submit" class="w-full py-3 bg-white text-black font-bold rounded-xl hover:bg-gray-200 transition">
                                Create Category
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>