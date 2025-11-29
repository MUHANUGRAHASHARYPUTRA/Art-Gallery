<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <a href="/" class="inline-flex items-center text-gray-500 hover:text-black mb-6 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Gallery
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <div class="lg:col-span-2">
                    <div class="rounded-3xl overflow-hidden shadow-sm bg-gray-100">
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-auto object-contain max-h-[80vh]">
                    </div>
                </div>

                <div class="space-y-8">
                    
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $artwork->title }}</h1>
                        <div class="flex items-center gap-3 mt-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                {{ substr($artwork->user->name, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('profile.show', $artwork->user) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 hover:underline transition">
                                    {{ $artwork->user->name }}
                                </a>
                                <p class="text-xs text-gray-500">Published {{ $artwork->created_at->diffForHumans() }}</p>
                            </div>
                            
                            @auth
                                @if(Auth::id() !== $artwork->user->id && !$artwork->user->isFollowedBy(Auth::user()))
                                    <form action="{{ route('profile.follow', $artwork->user) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-2 py-1 rounded-lg">
                                            + Follow
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="flex gap-3 flex-wrap" x-data="{ shareUrl: '{{ route('artworks.show', $artwork) }}', shareTitle: '{{ $artwork->title }}' }">
                        
                        <form action="{{ route('artworks.like', $artwork) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold transition border {{ $artwork->isLikedBy(Auth::user()) ? 'bg-red-50 text-red-600 border-red-200' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 {{ $artwork->isLikedBy(Auth::user()) ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>{{ $artwork->likes->count() }}</span>
                            </button>
                        </form>

                        <button @click="
                            if (navigator.share) {
                                navigator.share({ title: shareTitle, url: shareUrl }).catch(console.error);
                            } else {
                                navigator.clipboard.writeText(shareUrl);
                                alert('Link copied to clipboard!');
                            }
                        " class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-gray-700 font-bold hover:bg-gray-50 transition border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            Share
                        </button>

                        @auth
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'collection-modal')" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Save
                            </button>

                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'report-modal')" class="flex items-center gap-2 px-3 py-2.5 rounded-full text-gray-400 hover:text-red-600 transition ml-auto" title="Report Content">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </button>

                            <x-modal name="collection-modal" focusable>
                                <div class="p-6">
                                    <h2 class="text-lg font-bold text-gray-900 mb-4">Save to Moodboard</h2>
                                    
                                    @if(Auth::user()->collections->isEmpty())
                                        <p class="text-sm text-gray-500 mb-4">You don't have any collections yet.</p>
                                        <form action="{{ route('collections.store') }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="text" name="name" placeholder="New Collection Name" class="flex-1 rounded-lg border-gray-300 text-sm" required>
                                            <button class="bg-black text-white px-4 py-2 rounded-lg text-sm font-bold">Create</button>
                                        </form>
                                    @else
                                        <div class="space-y-2 max-h-60 overflow-y-auto">
                                            @foreach(Auth::user()->collections as $collection)
                                                <form action="{{ route('collections.toggle', $artwork) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="collection_id" value="{{ $collection->id }}">
                                                    <button class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition group">
                                                        <span class="font-medium text-gray-700">{{ $collection->name }}</span>
                                                        @if($collection->artworks->contains($artwork->id))
                                                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded">Saved</span>
                                                        @else
                                                            <span class="text-xs font-bold text-gray-400 group-hover:text-black">Add +</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <form action="{{ route('collections.store') }}" method="POST" class="flex gap-2">
                                                @csrf
                                                <input type="text" name="name" placeholder="Create new collection..." class="flex-1 rounded-lg border-gray-300 text-sm" required>
                                                <button class="bg-gray-100 text-gray-900 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200">Create</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </x-modal>

                            <x-modal name="report-modal" focusable>
                                <form method="post" action="{{ route('artworks.report', $artwork) }}" class="p-6">
                                    @csrf
                                    <h2 class="text-lg font-bold text-gray-900">Report this Artwork</h2>
                                    <p class="mt-1 text-sm text-gray-600">Please select a reason why this content is inappropriate.</p>

                                    <div class="mt-6">
                                        <x-input-label for="reason" value="Reason" />
                                        <select name="reason" id="reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="Inappropriate Content">Inappropriate Content (SARA/Pornography)</option>
                                            <option value="Copyright Violation">Copyright Violation / Plagiarism</option>
                                            <option value="Spam">Spam or Misleading</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                        <x-danger-button class="ms-3">Submit Report</x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        @endauth
                    </div>

                    <div class="prose prose-sm text-gray-600">
                        <p>{{ $artwork->description }}</p>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Comments ({{ $artwork->comments->count() }})</h3>
                        
                        @auth
                            <form action="{{ route('artworks.comment', $artwork) }}" method="POST" class="mb-8">
                                @csrf
                                <div class="relative">
                                    <input type="text" name="body" class="w-full px-4 py-3 pr-12 rounded-full bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 transition" placeholder="Add a comment..." required>
                                    <button type="submit" class="absolute right-2 top-2 p-1.5 bg-black text-white rounded-full hover:bg-gray-800 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="p-4 bg-gray-50 rounded-xl text-center mb-6">
                                <p class="text-sm text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">log in</a> to like or comment.</p>
                            </div>
                        @endauth

                        <div class="space-y-6">
                            @foreach($artwork->comments as $comment)
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-sm text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>