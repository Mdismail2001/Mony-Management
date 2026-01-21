@extends('layouts.base')

@section('title', $community->name . ' Details')

@section('content')
{{-- check the exsiting user role --}}
@php
    $loggedUserMember = $community->members->where('user_id', auth()->id())->first();
    $loggedUserRole = $loggedUserMember->role ?? null; // leader or member
@endphp

{{-- Updated background to match dark theme from header/sidebar/dashboard --}}
<div class="min-h-screen bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('Dashboard') }}"
            class="inline-flex items-center gap-2 text-slate-600 hover:text-emerald-500 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Dashboard</span>
            </a>
        </div>

        {{-- Page Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between bg-white p-4 rounded-lg shadow-sm">
            <div class="mb-4 md:mb-0 pl-2">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2 truncate">{{ $community->name }}</h1>
                <p class="text-gray-500 text-sm sm:text-base">Manage community details and member information</p>
            </div>

            {{-- Message --}}
            @if(session('success'))
                <div 
                    x-data="{ show: true }" 
                    x-init="setTimeout(() => show = false, 5000)" 
                    x-show="show"
                    x-transition
                    class="mt-2 md:mt-0 bg-emerald-100 border border-emerald-300 text-emerald-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2 w-full md:w-auto"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Action Buttons --}}
            @if ($loggedUserRole === 'leader')
                <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                    <!-- Notice Button -->
                    <a href="{{ route('community-notice', $community->id) }}" 
                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-emerald-500 text-gray-800 hover:text-white rounded-lg transition-all border border-gray-300 hover:border-emerald-500"
                    title="Notice Community">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>

                        <span class="text-sm font-medium">Create Notice</span>
                    </a>


                    <!-- Edit Button -->
                    <a href="{{ route('community-edit', $community->id) }}" 
                    class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-emerald-500 text-gray-800 hover:text-white rounded-lg transition-all border border-gray-300 hover:border-emerald-500"
                    title="Edit Community">
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm font-medium">Edit</span>
                    </a>

                    <!-- Delete Button -->
                    <button onclick="if(confirm('Are you sure you want to delete this community? This action cannot be undone.')) { window.location.href='{{ route('delete-community', $community->id) }}'; }"
                            class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-red-500 text-gray-800 hover:text-white rounded-lg transition-all border border-gray-300 hover:border-red-500"
                            title="Delete Community">
                        <svg class="w-5 h-5 text-gray-600 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="text-sm font-medium">Delete</span>
                    </button>
                </div>
            @endif

            {{-- Member Notices --}}
            @if ($loggedUserRole !== 'leader' && !empty($showNotices))
                <div class="relative w-full sm:w-[460px]  overflow-hidden">

                    <div class="space-y-1">
                        @foreach ($showNotices as $notice)
                            @php
                                $textColor = match ($notice['type']) {
                                    'warning' => 'text-red-600',
                                    'deposit' => 'text-yellow-700',
                                    'info'    => 'text-green-600',
                                    default   => 'text-gray-700',
                                };

                                $badgeColor = match ($notice['type']) {
                                    'warning' => 'bg-red-100 text-red-700',
                                    'deposit' => 'bg-yellow-100 text-yellow-700',
                                    'info'    => 'bg-green-100 text-green-700',
                                    default   => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <div class="flex items-center justify-between gap-2">

                                {{-- Marquee Message --}}
                                <div class="relative overflow-hidden flex-1">
                                    <div class="animate-marquee whitespace-nowrap text-sm font-medium {{ $textColor }}">
                                        • {{ $notice['message'] }}
                                    </div>
                                </div>

                                {{-- Right Fixed Badge --}}
                                <div class="flex-shrink-0 w-24 flex justify-center">
                                    @php
                                        $badgeText = ($notice['type'] === 'deposit' && !empty($notice['due_date']))
                                            ? \Carbon\Carbon::parse($notice['due_date'])->format('d M Y')
                                            : strtoupper($notice['type']);
                                    @endphp

                                    <span
                                        class="
                                            inline-flex items-center justify-center
                                            w-20 h-6
                                            text-xs font-semibold
                                            rounded-lg
                                            {{ $badgeColor }}
                                        "
                                    >
                                        {{ $badgeText }}
                                    </span>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endif
                
        </div>

        {{-- Community Stats Cards --}}
        <div class="grid grid-cols-3 gap-4 mb-8">

            {{-- Deposit Card --}}
            <a href="{{ route('transactions-form', [
                    'member_id' => $loggedUserMember->id,
                    'community_id' => $community->id
                ]) }}"
            class="block bg-white rounded-xl border border-gray-200
                    p-3 sm:p-4 lg:p-6
                    shadow hover:shadow-lg hover:border-emerald-400 transition-all">

                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">
                            Make a Deposit
                        </p>
                        <p class="text-sm sm:text-lg lg:text-2xl font-bold text-emerald-600 truncate">
                            Deposit Now
                        </p>
                    </div>

                    <div
                        class="w-7 h-7 sm:w-9 sm:h-9 lg:w-12 lg:h-12
                            bg-gradient-to-br from-emerald-500 to-teal-500
                            rounded-lg flex items-center justify-center shadow">
                        <svg
                            class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Minimum Amount --}}
            <div
                class="bg-white rounded-xl border border-gray-200
                    p-3 sm:p-4 lg:p-6
                    shadow hover:shadow-lg transition-all">

                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">
                            Minimum Amount
                        </p>
                        <p class="text-sm sm:text-lg lg:text-2xl font-bold text-gray-900 truncate">
                            {{ number_format($community->min_amount, 2) }}
                        </p>
                    </div>

                    <div
                        class="w-7 h-7 sm:w-9 sm:h-9 lg:w-12 lg:h-12
                            bg-gradient-to-br from-emerald-400 to-teal-400
                            rounded-lg flex items-center justify-center shadow">
                        <svg
                            class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                                    3 .895 3 2-1.343 2-3 2m0-8
                                    c1.11 0 2.08.402 2.599 1M12 8V7
                                    m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1
                                    M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Amount --}}
            <div
                class="bg-white rounded-xl border border-gray-200
                    p-3 sm:p-4 lg:p-6
                    shadow hover:shadow-lg transition-all">

                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">
                            Total Amount
                        </p>
                        <p class="text-sm sm:text-lg lg:text-2xl font-bold text-gray-900 truncate">
                            {{ number_format($community->total_amount, 2) }}
                        </p>
                    </div>

                    <div
                        class="w-7 h-7 sm:w-9 sm:h-9 lg:w-12 lg:h-12
                            bg-gradient-to-br from-amber-400 to-orange-400
                            rounded-lg flex items-center justify-center shadow">
                        <svg
                            class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01
                                    M9 14h.01M12 14h.01M15 11h.01
                                    M12 11h.01M9 11h.01M7 21h10
                                    a2 2 0 002-2V5a2 2 0 00-2-2H7
                                    a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- Transactions Section --}}
        <div class="mb-8 bg-white rounded-xl border border-gray-200 shadow overflow-hidden">
            {{-- Section Header --}}
            <div class="px-6 py-5 border-b border-gray-200
                        flex items-center justify-between gap-4">

                {{-- Title --}}
                <div class="min-w-0">
                    <h2 class="text-xl font-bold text-gray-900 truncate">
                        Transactions History
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 truncate">
                        Total transactions: {{ $community->transactions->count() }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 shrink-0">

                    {{-- See More Button --}}
                    <a href="{{ route('eachAllTransactions', $community->id) }}"
                    class="inline-flex items-center gap-2
                            px-3 py-2
                            sm:px-4 sm:py-2.5
                            bg-gray-100 text-gray-700 text-sm font-medium
                            rounded-lg
                            hover:bg-gray-200
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300
                            transition-all shadow-sm">

                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m6 0l-3-3m3 3l-3 3"/>
                        </svg>

                        <span class="">See More</span>
                    </a>
                </div>
            </div>

            {{-- Transaction Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($community->transactions as $index => $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{$index + 1}}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center flex-shrink-0 shadow">
                                            <span class="text-sm font-semibold text-white">{{ strtoupper(substr($transaction->member->user->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{$transaction->member->user->name}}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($transaction->amount, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ \Carbon\Carbon::createFromFormat('Y-m', $transaction->month)->format('F Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm font-semibold {{ $transaction->status == 1 ? 'text-emerald-500' : ($transaction->status == 2 ? 'text-red-500' : 'text-yellow-500') }}">
                                    @if ($transaction->status == 1) Approved
                                    @elseif ($transaction->status == 2) Rejected
                                    @else Pending
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($loggedUserRole === 'leader')
                                        {{-- Leader: View --}}
                                        <a href="{{ route('view-transaction', $transaction->id) }}"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-blue-500
                                                text-gray-800 hover:text-white rounded-lg border border-gray-200
                                                hover:border-blue-500 transition-all text-sm">
                                            View
                                        </a>

                                    @elseif(
                                        $transaction->status != 1 &&
                                        $transaction->member->user_id === auth()->id()
                                    )
                                        {{-- Member: Edit only own & not approved --}}
                                        <a href="{{ route('transaction-edit-form', $transaction->id) }}"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-blue-500
                                                text-gray-800 hover:text-white rounded-lg border border-gray-200
                                                hover:border-blue-500 transition-all text-sm">
                                            Edit
                                        </a>

                                    @else
                                        {{-- No action --}}
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-medium">No transactions yet</p>
                                        <p class="text-sm text-gray-500">Get started by creating your first transaction</p>
                                        <a href="{{ route('transactions-form', ['member_id' => auth()->user()->id, 'community_id' => $community->id]) }}"
                                        class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Deposit Now
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Members Section --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow overflow-hidden mb-8">
            {{-- Section Header --}}
            <div class="px-6 py-5 border-b border-gray-200
                        flex items-center justify-between gap-4">

                {{-- Title --}}
                <div class="min-w-0">
                    <h2 class="text-xl font-bold text-gray-900 truncate">
                        Community Members
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 truncate">
                        Total members: {{ $community->members->count() }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 shrink-0">

                    {{-- Add Member (Leader Only) --}}
                    @if ($loggedUserRole === 'leader')
                        <a href="{{ route('create-member', $community->id) }}"
                        class="inline-flex items-center gap-2
                                px-3 py-2
                                sm:px-4 sm:py-2.5
                                bg-gradient-to-r from-emerald-500 to-teal-500
                                text-white text-sm font-medium
                                rounded-lg
                                hover:from-emerald-600 hover:to-teal-600
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500
                                transition-all shadow">

                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>

                            <span class="">Add Member</span>
                        </a>
                    @endif
                                        {{-- See More Button --}}
                    <a href="{{ route('eachAllMembers', $community->id) }}"
                        class="inline-flex items-center gap-2
                            px-3 py-2
                            sm:px-4 sm:py-2.5
                            bg-gray-100 text-gray-700 text-sm font-medium
                            rounded-lg
                            hover:bg-gray-200
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300
                            transition-all shadow-sm">

                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m6 0l-3-3m3 3l-3 3"/>
                        </svg>

                        <span class="">See More</span>
                    </a>
                </div>
            </div>

            {{-- Members Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Deposit</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Amount</th>
                            @if($loggedUserRole === 'leader')
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($community->members as $index => $member)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center flex-shrink-0 shadow">
                                            <span class="text-sm font-semibold text-white">{{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $member->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $member->user->phone_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $member->role === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200' : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                                        {{ ucfirst($member->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ number_format ($member->last_payment ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-emerald-500">{{ number_format($member->total_amount ?? 0, 2) }}</td>
                                @if ($loggedUserRole === 'leader')
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <!-- View Button -->
                                            <a href="{{ route('member-details', $member->id) }}" 
                                            class="p-2 bg-gray-100 hover:bg-blue-500 text-gray-800 hover:text-white rounded-lg transition-all"
                                            title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('edit-member', $member->id) }}" 
                                            class="p-2 bg-gray-100 hover:bg-emerald-500 text-gray-800 hover:text-white rounded-lg transition-all"
                                            title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <button onclick="if(confirm('Are you sure you want to remove this member?')) { window.location.href='{{ route('delete-member', $member->id) }}'; }"
                                                    class="p-2 bg-gray-100 hover:bg-red-500 text-gray-800 hover:text-white rounded-lg transition-all"
                                                    title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-medium">No members yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Get started by creating your first member</p>
                                        <a href="{{ route('create-member', $community->id) }}"
                                        class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow">
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
