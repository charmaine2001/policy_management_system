<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <!-- Stat Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8"
         x-data="{
            vals: [{{ $stats['total_policies'] }}, {{ $stats['active_policies'] }}, {{ $stats['expired_policies'] }}, {{ $stats['pending_queries'] }}, {{ $stats['resolved_queries'] }}],
            displayed: [0,0,0,0,0]
         }"
         x-init="
            setTimeout(() => {
                vals.forEach((end, i) => {
                    let start = 0, dur = 800, step = 16;
                    let inc = end / (dur / step);
                    let iv = setInterval(() => {
                        start = Math.min(start + inc, end);
                        displayed[i] = Math.floor(start);
                        if (start >= end) clearInterval(iv);
                    }, step);
                });
            }, 200);
         "
    >
        <!-- Total Policies -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl hover:shadow-zimnat-blue/5 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-zimnat-blue group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-[10px] font-black text-zimnat-blue bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-md">SUMMARY</span>
            </div>
            <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total Policies</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-black text-gray-900 dark:text-white" x-text="displayed[0]">{{ $stats['total_policies'] }}</p>
                <span class="text-[10px] font-black text-blue-500 tracking-tighter">↑ 12%</span>
            </div>
        </div>

        <!-- Active Policies -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-zimnat-green/5 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-2xl bg-green-50 flex items-center justify-center text-zimnat-green group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black text-zimnat-green bg-green-50 px-2 py-1 rounded-md">LIVE</span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Active Policies</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-black text-gray-900" x-text="displayed[1]">{{ $stats['active_policies'] }}</p>
                <span class="text-[10px] font-black text-zimnat-green tracking-tighter">↑ 5%</span>
            </div>
        </div>

        <!-- Expired Policies -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black text-red-500 bg-red-50 px-2 py-1 rounded-md">EXPIRED</span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Expired</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-black text-gray-900" x-text="displayed[2]">{{ $stats['expired_policies'] }}</p>
            </div>
        </div>

        <!-- Pending Queries -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black text-orange-500 bg-orange-50 px-2 py-1 rounded-md">URGENT</span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Open Queries</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-black text-gray-900" x-text="displayed[3]">{{ $stats['pending_queries'] }}</p>
                <span class="w-2 h-2 rounded-full bg-orange-500 pulse-dot"></span>
            </div>
        </div>

        <!-- Resolved Queries -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-2xl bg-zimnat-blue/5 flex items-center justify-center text-zimnat-blue group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-[10px] font-black text-zimnat-blue bg-zimnat-blue/5 px-2 py-1 rounded-md">DONE</span>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Resolved Today</p>
            <div class="flex items-baseline gap-2">
                <p class="text-3xl font-black text-gray-900" x-text="displayed[4]">{{ $stats['resolved_queries'] }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Policies Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
            <div class="flex items-center justify-between px-8 py-6 border-b border-gray-50">
                <h2 class="font-black text-xs uppercase tracking-[0.2em] text-gray-400">Recent Policies</h2>
                <a href="{{ route('policies.index') }}" class="text-[10px] font-black text-zimnat-blue flex items-center gap-2 hover:text-zimnat-green transition-colors uppercase tracking-widest">
                    View Registry <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 bg-gray-50/50">
                            <th class="px-8 py-4">Policy Number</th>
                            <th class="px-4 py-4">Client</th>
                            <th class="px-4 py-4">Type</th>
                            <th class="px-4 py-4">Renewal</th>
                            <th class="px-4 py-4">Status</th>
                            <th class="px-8 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentPolicies ?? [] as $policy)
                            <tr class="hover:bg-gray-50/80 transition-all group">
                                <td class="px-8 py-5">
                                    <span class="text-xs font-black text-zimnat-blue tracking-tight">{{ $policy->policy_number }}</span>
                                </td>
                                <td class="px-4 py-5 text-xs font-bold text-gray-700">{{ $policy->client->name ?? 'N/A' }}</td>
                                <td class="px-4 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-tight">{{ $policy->insurance_type }}</td>
                                <td class="px-4 py-5 text-xs font-bold text-gray-500">
                                    {{ $policy->renewal_date ? \Carbon\Carbon::parse($policy->renewal_date)->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-4 py-5">
                                    @php
                                        $statusClass = match(strtolower($policy->status)) {
                                            'active' => 'bg-green-50 text-zimnat-green border-green-100',
                                            'expired' => 'bg-red-50 text-red-600 border-red-100',
                                            'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            default => 'bg-gray-50 text-gray-600 border-gray-100'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusClass }}">
                                        {{ $policy->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('policies.show', $policy) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-zimnat-blue hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side: Quick Actions & Activity Summary -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-6">
                <h2 class="font-black text-xs uppercase tracking-[0.2em] text-gray-400 mb-6 px-2">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('policies.create') }}" class="flex items-center justify-between w-full p-4 bg-zimnat-blue text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-zimnat-blue-dark transition-all shadow-lg shadow-zimnat-blue/20 group">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            New Policy
                        </span>
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3"/></svg>
                    </a>
                    <a href="{{ route('queries.index') }}" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 border-2 border-gray-50 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:border-zimnat-green hover:text-zimnat-green transition-all group">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            Client Queries
                        </span>
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3"/></svg>
                    </a>
                    <a href="{{ route('users.index') }}" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 border-2 border-gray-50 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:border-zimnat-blue hover:text-zimnat-blue transition-all group">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Manage Users
                        </span>
                        <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Activity Summary -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8"
                 x-data="{
                    active: {{ $stats['active_policies'] }},
                    expired: {{ $stats['expired_policies'] }},
                    pending: {{ $stats['pending_queries'] }},
                    get total() { return this.active + this.expired + this.pending; },
                    get activePct() { return this.total > 0 ? Math.round((this.active / this.total) * 100) : 0; },
                    get expiredPct() { return this.total > 0 ? Math.round((this.expired / this.total) * 100) : 0; },
                    get pendingPct() { return this.total > 0 ? Math.round((this.pending / this.total) * 100) : 0; }
                 }">
                <h2 class="font-black text-xs uppercase tracking-[0.2em] text-gray-400 mb-8">Activity Distribution</h2>
                
                <div class="h-4 flex rounded-full overflow-hidden mb-8 bg-gray-50 p-1">
                    <div :style="'width: ' + activePct + '%'" class="bg-zimnat-green rounded-full shadow-lg shadow-zimnat-green/20 transition-all duration-1000"></div>
                    <div :style="'width: ' + expiredPct + '%'" class="bg-red-500 rounded-full shadow-lg shadow-red-500/20 mx-1 transition-all duration-1000"></div>
                    <div :style="'width: ' + pendingPct + '%'" class="bg-orange-500 rounded-full shadow-lg shadow-orange-500/20 transition-all duration-1000"></div>
                </div>

                <div class="space-y-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-zimnat-green ring-4 ring-green-50"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Active Policies</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-black text-gray-900" x-text="active"></span>
                            <span class="text-[10px] font-black text-zimnat-green bg-green-50 px-2 py-0.5 rounded-md" x-text="activePct + '%'"></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-red-500 ring-4 ring-red-50"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Expired Policies</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-black text-gray-900" x-text="expired"></span>
                            <span class="text-[10px] font-black text-red-500 bg-red-50 px-2 py-0.5 rounded-md" x-text="expiredPct + '%'"></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-orange-500 ring-4 ring-orange-50"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pending Queries</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-black text-gray-900" x-text="pending"></span>
                            <span class="text-[10px] font-black text-orange-500 bg-orange-50 px-2 py-0.5 rounded-md" x-text="pendingPct + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
