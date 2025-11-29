<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Host a Challenge</h1>
                <p class="mt-2 text-lg text-gray-500">Inspire the community with a new creative event.</p>
            </div>

            <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Challenge Banner</label>
                    <div class="relative group">
                        <label for="banner" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition overflow-hidden">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-500">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm font-medium">Upload Banner Image</p>
                            </div>
                            <input id="banner" name="banner" type="file" class="hidden" accept="image/*" onchange="previewBanner(event)" />
                            <img id="banner-preview" class="absolute inset-0 w-full h-full object-cover hidden rounded-2xl" />
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('banner')" />
                </div>

                <div class="space-y-2">
                    <label for="title" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Event Title</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition font-bold text-xl" placeholder="e.g. Cyberpunk City 2077" value="{{ old('title') }}" required>
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="start_date" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition" value="{{ old('start_date') }}" required>
                        <x-input-error :messages="$errors->get('start_date')" />
                    </div>
                    <div class="space-y-2">
                        <label for="end_date" class="text-sm font-bold text-gray-900 uppercase tracking-wider">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition" value="{{ old('end_date') }}" required>
                        <x-input-error :messages="$errors->get('end_date')" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition resize-none" placeholder="What is this challenge about?">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div class="space-y-2">
                    <label for="rules" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Rules & Guidelines</label>
                    <textarea name="rules" id="rules" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition resize-none" placeholder="e.g. No AI art allowed, minimum resolution 1080p...">{{ old('rules') }}</textarea>
                    <x-input-error :messages="$errors->get('rules')" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('curator.challenges') }}" class="px-6 py-3 rounded-full font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition transform hover:scale-105 duration-200">
                        Launch Challenge
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewBanner(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('banner-preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>