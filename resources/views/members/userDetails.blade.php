@extends('layouts.base')

@section('title', $member->user->name . ' - User Details')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Community</span>
            </a>
        </div>

        {{-- Page Header with User Avatar --}}
        <div class="mb-8 flex items-center gap-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-md overflow-hidden">
                 @if($member->user->photo)
                    <!-- Show user photo filling the entire circle -->
                        <img src="{{ asset('storage/' . $member->user->photo) }}" 
                        alt="{{ $member->user->name }}" 
                    class="w-full h-full object-cover">
                @else
                    <!-- Show default user icon -->
                    <div class="w-full h-full flex items-center justify-center bg-gray-400 text-white text-2xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="w-10 h-10" 
                            fill="currentColor" 
                            viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    {{ $member->user->name }}
                </h1>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $member->role === 'admin' ? 'bg-purple-100 text-purple-600 border border-purple-300' : 'bg-gray-100 text-gray-600 border border-gray-300' }}">
                        {{ ucfirst($user->role ?? 'member') }}
                    </span>
                    <span class="text-gray-500 text-sm">
                        Member since {{ $member->created_at ? \Carbon\Carbon::parse($member->created_at)->format('M Y') : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Contact Information Card --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Contact Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Address</label>
                            <p class="text-gray-700 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $member->user->email ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone Number</label>
                            <p class="text-gray-700 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $member->user->phone_number ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">User ID</label>
                            <p class="text-gray-700 mt-1 font-mono text-sm">
                                #{{ str_pad($member->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Communities Joined --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <p class="text-sm font-medium text-gray-500 mb-1">Communities Joined</p>
                    <p class="text-3xl font-bold text-gray-800">
                         {{ $member->community->name }}
                    </p>
                </div>

                {{-- Total Contributions --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Contributions</p>
                    <p class="text-3xl font-bold text-gray-800">
                       {{ '$' . number_format($member->total_contributed ?? 0, 2) }} 
                    </p>
                </div>

                {{-- Last Activity --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <p class="text-sm font-medium text-gray-500 mb-1">Last Activity</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $member->last_payment ?? 'No activity yet' }}
                    </p>
                </div>

                {{-- Account Status --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <p class="text-sm font-medium text-gray-500 mb-1">Account Status</p>
                    <p class="text-lg font-semibold text-emerald-600">Active</p>
                </div>
            </div>
        </div>

        {{-- Communities Membership Table --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Community Memberships
                </h2>
                <p class="text-sm text-gray-500 mt-1">All communities this user belongs to</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Community</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Contributed</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Deposit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center border border-emerald-200">
                                        <span class="text-sm font-bold text-emerald-500">
                                            {{ strtoupper(substr($community->name ?? 'C', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $member->community->name }}</p>
                                        <p class="text-xs text-gray-500">Min: ${{ number_format($member->community->min_amount, 2) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $member->role === 'admin' ? 'bg-purple-100 text-purple-600 border border-purple-300' :
                                       ($member->role === 'leader' ? 'bg-blue-100 text-blue-600 border border-blue-300' :
                                        'bg-gray-100 text-gray-600 border border-gray-300') }}">
                                    {{ ucfirst($community->pivot->role ?? 'member') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">
                                    ${{ number_format($member->total_amount ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $member->last_payment ? $member->last_payment : '0'}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
