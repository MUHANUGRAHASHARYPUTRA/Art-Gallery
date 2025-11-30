<x-guest-layout>
    <div class="text-center">
        <div class="mx-auto w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <h2 class="text-3xl font-black text-gray-900 mb-2">Account Pending</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Thank you for registering as a Curator! <br>
            Your account is currently under review by our administrators. 
            Please check back later or contact support if this takes too long.
        </p>

        <div class="bg-gray-50 p-4 rounded-xl text-sm text-gray-600 mb-8">
            <span class="font-bold text-gray-900">Status:</span> 
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 ml-2">
                Pending Approval
            </span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-black text-white font-bold rounded-xl hover:bg-gray-800 transition">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>