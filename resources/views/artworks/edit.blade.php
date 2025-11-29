<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Edit Artwork</h1>
                <p class="mt-2 text-lg text-gray-500">Update details or change the image.</p>
            </div>

            <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Current Image</label>
                    <img src="{{ Storage::url($artwork->image_path) }}" class="h-64 w-auto object-contain rounded-xl shadow-md mb-6 bg-gray-50 border">
                    
                    <div class="relative group w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-500">
                                <p class="text-sm font-medium">Click to change image (Optional)</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                        </label>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Title</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition" value="{{ old('title', $artwork->title) }}" required>
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="space-y-2">
                        <label for="category" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Category</label>
                        <select name="category_id" id="category" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition appearance-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $artwork->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 transition">{{ old('description', $artwork->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('artworks.manage') }}" class="px-6 py-3 rounded-full font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition">
                        Update Artwork
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>