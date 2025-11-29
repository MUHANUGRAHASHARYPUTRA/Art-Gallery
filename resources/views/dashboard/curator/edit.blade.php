<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Edit Challenge</h1>
                <p class="mt-2 text-lg text-gray-500">Update event details.</p>
            </div>

            <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="flex flex-col">
                    <label class="block text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Current Banner</label>
                    @if($challenge->banner_path)
                        <img src="{{ Storage::url($challenge->banner_path) }}" class="h-48 w-full object-cover rounded-2xl mb-4 bg-gray-100">
                    @endif
                    
                    <div class="relative group">
                        <label for="banner" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-sm font-medium text-gray-500">Change Banner (Optional)</p>
                            <input id="banner" name="banner" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('banner')" />
                </div>

                <div class="space-y-2">
                    <label for="title" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Event Title</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition font-bold text-xl" value="{{ old('title', $challenge->title) }}" required>
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="start_date" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition" value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="space-y-2">
                        <label for="end_date" class="text-sm font-bold text-gray-900 uppercase tracking-wider">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition" value="{{ old('end_date', $challenge->end_date->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition resize-none">{{ old('description', $challenge->description) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label for="rules" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Rules & Guidelines</label>
                    <textarea name="rules" id="rules" rows="4" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-black focus:bg-white focus:ring-0 transition resize-none">{{ old('rules', $challenge->rules) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('curator.challenges') }}" class="px-6 py-3 rounded-full font-bold text-gray-500 hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition">
                        Update Challenge
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>