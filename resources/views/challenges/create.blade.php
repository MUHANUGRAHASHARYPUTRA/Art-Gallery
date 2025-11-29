<x-app-layout>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-4">
                    Host a <span class="text-indigo-600">Challenge</span>
                </h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    Ignite creativity in the community. Set the stage, define the rules, and discover the next big
                    artist.
                </p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up"
                data-aos-delay="200">
                <div class="p-8 md:p-12">
                    <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf

                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Challenge
                                Banner</label>

                            <div class="relative group">
                                <label for="banner"
                                    class="relative flex flex-col items-center justify-center w-full h-64 md:h-80 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition duration-300 overflow-hidden">

                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-400 group-hover:text-indigo-600 transition"
                                        id="upload-placeholder">
                                        <div
                                            class="w-16 h-16 rounded-full bg-white shadow-sm flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-bold">Click to upload banner</p>
                                        <p class="text-sm opacity-70">Recommended: 1920x600px (Max 5MB)</p>
                                    </div>

                                    <input id="banner" name="banner" type="file" class="hidden" accept="image/*"
                                        onchange="previewBanner(event)" />

                                    <img id="banner-preview"
                                        class="absolute inset-0 w-full h-full object-cover hidden transition duration-500" />

                                    <div id="preview-overlay"
                                        class="absolute inset-0 bg-black/40 hidden items-center justify-center text-white font-bold opacity-0 group-hover:opacity-100 transition">
                                        Change Image
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('banner')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="col-span-1 md:col-span-2 space-y-2">
                                <label for="title"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Event
                                    Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition font-bold text-2xl placeholder-gray-300"
                                    placeholder="e.g. Neon Cyberpunk 2077" value="{{ old('title') }}" required>
                                <x-input-error :messages="$errors->get('title')" />
                            </div>

                            <div class="space-y-2">
                                <label for="start_date"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full px-5 py-3 rounded-xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition font-medium"
                                    value="{{ old('start_date') }}" required>
                                <x-input-error :messages="$errors->get('start_date')" />
                            </div>

                            <div class="space-y-2">
                                <label for="end_date"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Deadline</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full px-5 py-3 rounded-xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition font-medium"
                                    value="{{ old('end_date') }}" required>
                                <x-input-error :messages="$errors->get('end_date')" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="description"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition resize-none text-lg leading-relaxed placeholder-gray-400"
                                    placeholder="Describe the theme, the mood, and what you are looking for...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" />
                            </div>

                            <div class="space-y-2">
                                <label for="rules"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Rules &
                                    Requirements</label>
                                <div class="bg-gray-50 rounded-2xl p-2">
                                    <textarea name="rules" id="rules" rows="4"
                                        class="w-full px-4 py-3 rounded-xl bg-transparent border-none focus:ring-0 transition resize-none text-sm text-gray-600 placeholder-gray-400"
                                        placeholder="- Original work only&#10;- Minimum resolution 1920x1080&#10;- No AI generated content">{{ old('rules') }}</textarea>
                                </div>
                                <x-input-error :messages="$errors->get('rules')" />
                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('curator.challenges') }}"
                                class="text-gray-500 font-bold hover:text-gray-900 transition">Cancel</a>

                            <button type="submit"
                                class="group relative px-8 py-4 bg-black text-white font-bold rounded-full overflow-hidden shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-1">
                                <span class="relative z-10 group-hover:text-white transition">Launch Challenge 🚀</span>
                                <div
                                    class="absolute inset-0 h-full w-full bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition duration-300">
                                </div>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewBanner(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('banner-preview');
                    const placeholder = document.getElementById('upload-placeholder');
                    const overlay = document.getElementById('preview-overlay');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    overlay.classList.remove('hidden'); // Enable overlay for changing
                    overlay.style.display = 'flex';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
