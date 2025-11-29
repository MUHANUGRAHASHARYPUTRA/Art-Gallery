<x-app-layout>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <div class="mb-12 text-center" data-aos="fade-down">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-4">
                    Edit <span class="text-indigo-600">Challenge</span>
                </h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    Update the details of your event. Keep the community informed.
                </p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up"
                data-aos-delay="200">
                <div class="p-8 md:p-12">
                    <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Challenge
                                Banner</label>

                            <div class="relative group">
                                <label for="banner"
                                    class="relative flex flex-col items-center justify-center w-full h-64 md:h-80 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition duration-300 overflow-hidden">

                                    <div class="absolute inset-0">
                                        @if ($challenge->banner_path)
                                            <img id="current-banner" src="{{ Storage::url($challenge->banner_path) }}"
                                                class="w-full h-full object-cover opacity-100 transition duration-300 group-hover:opacity-40">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center group-hover:bg-indigo-50 transition"
                                                id="upload-placeholder">
                                                <div class="text-center text-gray-400 group-hover:text-indigo-600">
                                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span class="font-bold">Upload New Banner</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <img id="banner-preview"
                                        class="absolute inset-0 w-full h-full object-cover hidden z-10" />

                                    <div
                                        class="absolute inset-0 flex items-center justify-center z-20 pointer-events-none">
                                        <span
                                            class="bg-black/50 text-white px-4 py-2 rounded-lg font-bold text-sm opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                                            Change Image
                                        </span>
                                    </div>

                                    <input id="banner" name="banner" type="file" class="hidden" accept="image/*"
                                        onchange="previewBanner(event)" />
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
                                    value="{{ old('title', $challenge->title) }}" required>
                                <x-input-error :messages="$errors->get('title')" />
                            </div>

                            <div class="space-y-2">
                                <label for="start_date"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full px-5 py-3 rounded-xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition font-medium"
                                    value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}" required>
                                <x-input-error :messages="$errors->get('start_date')" />
                            </div>

                            <div class="space-y-2">
                                <label for="end_date"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Deadline</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full px-5 py-3 rounded-xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition font-medium"
                                    value="{{ old('end_date', $challenge->end_date->format('Y-m-d')) }}" required>
                                <x-input-error :messages="$errors->get('end_date')" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="description"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:border-indigo-500 focus:bg-white focus:ring-0 transition resize-none text-lg leading-relaxed placeholder-gray-400"
                                    placeholder="Describe the theme...">{{ old('description', $challenge->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" />
                            </div>

                            <div class="space-y-2">
                                <label for="rules"
                                    class="block text-sm font-bold text-gray-900 uppercase tracking-wider">Rules &
                                    Requirements</label>
                                <div class="bg-gray-50 rounded-2xl p-2">
                                    <textarea name="rules" id="rules" rows="4"
                                        class="w-full px-4 py-3 rounded-xl bg-transparent border-none focus:ring-0 transition resize-none text-sm text-gray-600 placeholder-gray-400"
                                        placeholder="List the rules...">{{ old('rules', $challenge->rules) }}</textarea>
                                </div>
                                <x-input-error :messages="$errors->get('rules')" />
                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('curator.challenges') }}"
                                class="text-gray-500 font-bold hover:text-gray-900 transition">Cancel</a>

                            <button type="submit"
                                class="group relative px-8 py-4 bg-black text-white font-bold rounded-full overflow-hidden shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-1">
                                <span class="relative z-10 group-hover:text-white transition">Save Changes</span>
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
                    const current = document.getElementById('current-banner');

                    // Show new image
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');

                    // Hide old image visually (optional, but preview covers it anyway due to z-index)
                    if (current) current.classList.add('opacity-0');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
