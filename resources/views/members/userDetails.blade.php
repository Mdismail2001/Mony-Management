
@extends('layouts.base')

@section('title', $member->user->name . ' - User Details')

@section('content')
<div class="min-h-screen bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Community</span>
            </a>
        </div>

        {{-- Page Header with User Avatar --}}
        <div class="mb-8 flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <span class="text-4xl font-bold text-white">
                    {{ strtoupper(substr($member->user->name ?? 'U', 0, 1)) }}
                </span>
            </div>
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent mb-2">
                    {{ $member->user->name }}
                </h1>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $member->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-slate-700/50 text-slate-300 border border-slate-600/50' }}">
                        {{ ucfirst($user->role ?? 'member') }}
                    </span>
                    <span class="text-slate-400 text-sm">
                        Member since {{ $member->created_at ? \Carbon\Carbon::parse($member->created_at)->format('M Y') : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Contact Information Card --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-1">
                <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl p-6 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Contact Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</label>
                            <p class="text-slate-200 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $member->user->email ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Phone Number</label>
                            <p class="text-slate-200 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $member->user->phone_number ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">User ID</label>
                            <p class="text-slate-200 mt-1 font-mono text-sm">
                                #{{ str_pad($member->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Communities Joined</p>
                    <p class="text-3xl font-bold text-white">
                         {{ $member->community->name }}
                    </p>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Total Contributions</p>
                    <p class="text-3xl font-bold text-white">
                       {{ '$' . number_format($member->total_contributed ?? 0, 2) }} 
                    </p>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Last Activity</p>
                    <p class="text-lg font-semibold text-white">
                        {{ $member->last_payment ?? 'No activity yet' }}
                    </p>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-400 mb-1">Account Status</p>
                    <p class="text-lg font-semibold text-emerald-400">Active</p>
                </div>
            </div>
        </div>

        {{-- Communities Membership Section --}}
        <div class="bg-slate-900/80 backdrop-blur-lg border border-slate-800/50 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-800/50">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Community Memberships
                </h2>
                <p class="text-sm text-slate-400 mt-1">All communities this user belongs to</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-800/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Community</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Contributed</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Last Deposit</th>
                            {{-- <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        {{-- @forelse($member->communities as $community) --}}
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-400/20 to-teal-500/20 flex items-center justify-center border border-emerald-500/30">
                                            <span class="text-sm font-bold text-emerald-400">
                                                {{ strtoupper(substr($community->name ?? 'C', 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-white">{{ $member->community->name }}</p>
                                            <p class="text-xs text-slate-400">Min: ${{ number_format($member->community->min_amount, 2) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $member->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 
                                           ($member->role === 'leader' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 
                                            'bg-slate-700/50 text-slate-300 border border-slate-600/50') }}">
                                        {{ ucfirst($community->pivot->role ?? 'member') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-white">
                                        ${{ number_format($member->total_amount ?? 0, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-300">
                                    {{ $member->last_payment ? \Carbon\Carbon::parse($member->last_payment)->format('M d, Y') : '—' }}
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
