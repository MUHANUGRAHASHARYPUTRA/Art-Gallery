<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-black shadow-sm border border-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Moderation Queue</h1>
                    <p class="text-gray-500">Review and take action on reported content.</p>
                </div>
            </div>

            @if($reports->isEmpty())
                <div class="bg-white p-10 rounded-3xl text-center shadow-sm">
                    <p class="text-green-600 font-bold text-lg">✨ Clean! No pending reports.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($reports as $report)
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-48 flex-shrink-0">
                                <div class="relative h-32 md:h-full rounded-xl overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($report->artwork->image_path) }}" class="w-full h-full object-cover">
                                    <a href="{{ route('artworks.show', $report->artwork) }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 hover:opacity-100 transition text-white font-bold text-xs">View Original</a>
                                </div>
                            </div>

                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Report: {{ $report->reason }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Reported by <span class="font-bold">{{ $report->reporter->name }}</span> 
                                            • {{ $report->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">Pending</span>
                                </div>

                                <div class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-700">
                                    <p class="font-bold mb-1">Content Detail:</p>
                                    <p>"{{ $report->artwork->title }}" by {{ $report->artwork->user->name }}</p>
                                </div>

                                <div class="mt-6 flex gap-3">
                                    <form action="{{ route('admin.moderation.takedown', $report) }}" method="POST" onsubmit="return confirm('Are you sure? This will DELETE the artwork permanently.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition">
                                            Take Down Content
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.moderation.dismiss', $report) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200 transition">
                                            Dismiss Report
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>