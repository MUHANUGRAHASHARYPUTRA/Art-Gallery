<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Challenges</h1>
                    <p class="text-gray-500 mt-1">Host events and discover talents.</p>
                </div>
                <a href="{{ route('curator.challenges.create') }}" class="px-6 py-3 bg-black text-white font-bold rounded-full hover:bg-gray-800 transition">
                    + Create Challenge
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($challenges as $challenge)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col h-full">
                        <div class="h-40 bg-gray-200 relative">
                            @if($challenge->banner_path)
                                <img src="{{ Storage::url($challenge->banner_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    <span class="text-sm font-bold">No Banner</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold {{ $challenge->isActive() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $challenge->isActive() ? 'Active' : 'Ended' }}
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $challenge->title }}</h3>
                            <div class="text-sm text-gray-500 space-y-1 mb-4 flex-1">
                                <p>📅 {{ $challenge->start_date->format('d M') }} - {{ $challenge->end_date->format('d M Y') }}</p>
                                <p>🎨 {{ $challenge->submissions_count }} Submissions</p>
                            </div>

                            <div class="flex gap-2 pt-4 border-t border-gray-50">
                                <a href="{{ route('challenges.show', $challenge) }}" class="flex-1 text-center py-2 bg-indigo-50 text-indigo-700 font-bold rounded-xl hover:bg-indigo-100 transition text-sm">
                                    View & Judge
                                </a>
                                <a href="{{ route('curator.challenges.edit', $challenge) }}" class="p-2 text-gray-400 hover:text-black transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('curator.challenges.destroy', $challenge) }}" method="POST" onsubmit="return confirm('Delete this challenge?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>