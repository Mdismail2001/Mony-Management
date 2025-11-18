@extends('layouts.base')

@section('title', $community->name . ' Details')

@section('content')
{{-- Updated background to match dark theme from header/sidebar/dashboard --}}
<div class="min-h-screen bg-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            {{-- Updated text colors for dark theme --}}
            <a href="{{ route('adminDashboard') }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Dashboard</span>
            </a>
        </div>

        {{-- Page Header --}}
        <div class="mb-8">
            {{-- Updated text colors for dark theme --}}
            <h1 class="text-4xl font-bold text-white mb-2 text-balance">{{ $community->name }}</h1>
            <p class="text-slate-400">Manage community details and member information</p>
        </div>

        {{-- Community Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Updated cards to dark glass-morphism style --}}
            <div class="bg-slate-900/80 backdrop-blur-lg rounded-xl border border-slate-800 p-6 shadow-lg hover:shadow-emerald-500/10 hover:border-slate-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Community Name</p>
                        <p class="text-2xl font-bold text-white">{{ $community->name }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-lg rounded-xl border border-slate-800 p-6 shadow-lg hover:shadow-emerald-500/10 hover:border-slate-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Minimum Amount</p>
                        <p class="text-2xl font-bold text-white">${{ number_format($community->min_amount, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-lg rounded-xl border border-slate-800 p-6 shadow-lg hover:shadow-emerald-500/10 hover:border-slate-700 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-1">Total Amount</p>
                        <p class="text-2xl font-bold text-white">${{ number_format($community->total_amount, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Members Section --}}
        {{-- Updated to dark glass-morphism style --}}
        <div class="bg-slate-900/80 backdrop-blur-lg rounded-xl border border-slate-800 shadow-lg overflow-hidden">
            {{-- Section Header --}}
            <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Community Members</h2>
                    <p class="text-sm text-slate-400 mt-1">{{ $community->members->count() }} total member(s)</p>
                </div>
                <a href="{{ route('create-member', $community->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Member
                </a>
            </div>

            {{-- Members Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-800/50 border-b border-slate-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Last Deposit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($community->members as $index => $member)
                            <tr class="hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-white font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/20">
                                            <span class="text-sm font-semibold text-white">
                                                {{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-sm font-medium text-white">{{ $member->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">{{ $member->user->phone_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $member->role === 'admin' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-slate-700 text-slate-300 border border-slate-600' }}">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $member->last_payment ? \Carbon\Carbon::parse($member->last_payment)->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-emerald-400">
                                    ${{ number_format($member->total_amount ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('user-details',$member->id ) }}"
                                       class="inline-flex items-center gap-1 text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors">
                                        View
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">No members yet</p>
                                            <p class="text-sm text-slate-400 mt-1">Get started by creating your first member</p>
                                        </div>
                                        <a href="{{ route('create-member', $community->id) }}"
                                           class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg shadow-emerald-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Create First Member
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
