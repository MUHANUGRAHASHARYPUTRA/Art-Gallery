<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">My Submissions</h1>
                <p class="text-gray-500 mt-1">History of challenges you have participated in.</p>
            </div>

            @if($submissions->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">No submissions found</h3>
                    <p class="text-gray-500 mt-2 mb-6">You haven't joined any challenges yet.</p>
                    <a href="{{ route('home') }}" class="px-6 py-3 bg-black text-white font-bold rounded-full hover:bg-gray-800 transition">
                        Find Challenges
                    </a>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Challenge</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted Artwork</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('challenges.show', $submission->challenge) }}" class="font-bold text-indigo-600 hover:underline">
                                            {{ $submission->challenge->title }}
                                        </a>
                                        <div class="text-xs text-gray-400 mt-1">Ended {{ $submission->challenge->end_date->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                <img src="{{ Storage::url($submission->artwork->image_path) }}" class="w-full h-full object-cover">
                                            </div>
                                            <a href="{{ route('artworks.show', $submission->artwork) }}" class="text-sm font-bold text-gray-900 hover:underline">
                                                {{ $submission->artwork->title }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $submission->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($submission->winner_rank)
                                            @if($submission->winner_rank == 1)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    🏆 1st Winner
                                                </span>
                                            @elseif($submission->winner_rank == 2)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                                    🥈 2nd Winner
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                                    🥉 3rd Winner
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs font-medium text-gray-400">Submitted</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>