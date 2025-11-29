<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Share Your Work</h1>
                <p class="mt-2 text-lg text-gray-500">Showcase your creativity to the world.</p>
            </div>

            <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="relative group">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-[400px] border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-300 overflow-hidden">
                        
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-500 group-hover:text-gray-700">
                            <svg class="w-12 h-12 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-lg font-medium"><span class="font-bold">Click to upload</span> or drag and drop</p>
                            <p class="text-sm">SVG, PNG, JPG or GIF (MAX. 5MB)</p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                        
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden rounded-3xl" />
                    </label>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Artwork Title</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition duration-200 placeholder-gray-400 font-medium text-lg" placeholder="e.g. The Lost City" value="{{ old('title') }}" required>
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="space-y-2">
                        <label for="category" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Category</label>
                        <div class="relative">
                            <select name="category_id" id="category" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition duration-200 font-medium text-lg appearance-none cursor-pointer">
                                <option value="" disabled selected>Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('category_id')" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition duration-200 placeholder-gray-400 font-medium text-lg resize-none" placeholder="Tell us the story behind your masterpiece...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-full font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition transform hover:scale-105 duration-200">
                        Publish Artwork
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>