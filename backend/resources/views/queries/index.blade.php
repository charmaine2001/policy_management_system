<x-app-layout>
    <x-slot name="header">
        CLIENT QUERIES
    </x-slot>

    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-8 py-6 border-b border-gray-50">
                <div>
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Query Center</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Manage and respond to client issues</p>
                </div>
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
                            <th class="px-8 py-5">Client Name</th>
                            <th class="px-6 py-5">Subject</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5">Date Received</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($queries as $query)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $query->client->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500 uppercase">{{ $query->subject }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($query->status) {
                                        'Resolved' => 'bg-green-100 text-zimnat-green',
                                        'Open' => 'bg-red-100 text-red-600',
                                        'In Progress' => 'bg-orange-100 text-orange-600',
                                        default => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $statusClass }}">
                                    {{ $query->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500">{{ $query->created_at->format('Y-m-d') }}</td>
                            <td class="px-8 py-4 text-right">
                                <a href="{{ route('queries.show', $query) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-zimnat-blue rounded-lg font-black text-[10px] uppercase tracking-widest hover:bg-zimnat-blue hover:text-white transition-all">
                                    View & Respond
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($queries->hasPages())
                <div class="px-8 py-6 border-t border-gray-50">
                    {{ $queries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
