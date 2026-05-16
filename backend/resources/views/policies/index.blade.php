<x-app-layout>
    <x-slot name="header">
        POLICIES
    </x-slot>

    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-8 py-6 border-b border-gray-50">
                <div>
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Policy Registry</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Manage all insurance policies</p>
                </div>
                <a href="{{ route('policies.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-zimnat-blue text-white rounded-lg font-black text-xs uppercase tracking-widest hover:bg-zimnat-blue-dark transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    New Policy
                </a>
            </div>

            @if(session('success'))
                <div class="mx-8 mt-6 p-4 bg-green-50 border-l-4 border-zimnat-green text-zimnat-green text-xs font-black uppercase tracking-widest">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-50">
                            <th class="px-8 py-5">Policy #</th>
                            <th class="px-6 py-5">Client Name</th>
                            <th class="px-6 py-5">Type / Plan</th>
                            <th class="px-6 py-5">Final Price</th>
                            <th class="px-6 py-5">Renewal</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($policies as $policy)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <span class="text-sm font-black text-zimnat-blue uppercase tracking-tight">{{ $policy->policy_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $policy->client->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500 uppercase">
                                {{ $policy->type->name ?? 'N/A' }}
                                <span class="block text-[10px] text-gray-400 font-black tracking-widest">{{ $policy->plan_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500 uppercase">${{ number_format($policy->final_price, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500">{{ $policy->renewal_date }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($policy->status) {
                                        'Active' => 'bg-green-100 text-zimnat-green',
                                        'Expired' => 'bg-red-100 text-red-600',
                                        'Pending Renewal' => 'bg-orange-100 text-orange-600',
                                        default => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $statusClass }}">
                                    {{ $policy->status }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('policies.show', $policy) }}" class="p-2 text-gray-400 hover:text-zimnat-blue transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('policies.edit', $policy) }}" class="p-2 text-gray-400 hover:text-zimnat-green transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('policies.destroy', $policy) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Are you sure?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($policies->hasPages())
                <div class="px-8 py-6 border-t border-gray-50">
                    {{ $policies->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
