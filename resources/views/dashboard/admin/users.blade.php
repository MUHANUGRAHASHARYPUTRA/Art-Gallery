<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-black shadow-sm border border-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                    <p class="text-gray-500">Manage roles, approve curators, and suspend users.</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border  border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 ">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold capitalize
                                        {{ $user->role === 'curator' ? 'bg-purple-100 text-purple-800' : ($user->role === 'admin' ? 'bg-black text-white' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                                        </span>
                                    @elseif($user->status === 'suspended')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Suspended
                                        </span>
                                    @else
                                        <span class="text-sm font-bold text-green-600">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right flex justify-end items-center gap-2">
                                    
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $user->id }}')" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-200 transition">
                                        Edit
                                    </button>

                                    @if($user->role !== 'admin')
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete User">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <x-modal name="edit-user-{{ $user->id }}" focusable >
                                <form method="post" action="{{ route('admin.users.update', $user) }}" class="p-6 text-left">
                                    @csrf
                                    @method('PATCH')

                                    <h2 class="p-4 text-lg font-bold text-gray-900 mb-4">Edit User: {{ $user->name }}</h2>

                                    <div class="grid grid-cols-1 gap-6 p-4 bg-gray-50 rounded-2xl">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                                            <select name="role" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member</option>
                                                <option value="curator" {{ $user->role == 'curator' ? 'selected' : '' }}>Curator</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-2">Account Status</label>
                                            <select name="status" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                                <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>🛑 Suspended (Banned)</option>
                                            </select>
                                            <p class="text-xs text-gray-500 mt-2">Suspended users cannot login.</p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3 p-4">
                                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Update User</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>