@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-slate-950 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">Edit Member</h1>
                <p class="mt-2 text-slate-400">Update member information and permissions</p>
            </div>
            <a href="{{ route('communities', $member->community->id) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-slate-800/50 text-slate-300 rounded-lg hover:bg-slate-800 hover:text-white transition-all border border-slate-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Members
            </a>
        </div>

        <!-- Edit Form Card -->
        <div class="bg-slate-900/80 backdrop-blur-lg rounded-2xl border border-slate-800/50 shadow-xl overflow-hidden">
            <form action="{{ route('update-member',$member->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Profile Section -->
                    <div class="flex items-center gap-6 pb-6 border-b border-slate-800">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <span class="text-2xl font-bold text-white">
                                {{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-white">Profile Information</h3>
                            <p class="text-sm text-slate-400">Update the member's personal details</p>
                        </div>
                        {{-- Message show --}}
                        @if (session('success'))
                            <div class="ml-auto px-4 py-2 bg-emerald-600 text-white rounded-lg shadow-md">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-300">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" 
                                    value="{{ old('name', $member->user->name) }}"
                                    class="block w-full pl-10 pr-3 py-2.5 bg-slate-950 border border-slate-800 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                    placeholder="John Doe">
                            </div>
                            @error('name')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-slate-300">Phone Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input type="numter" name="phone_number" id="phone_number" 
                                    value="{{ old('phone', $member->user->phone_number) }}"
                                    class="block w-full pl-10 pr-3 py-2.5 bg-slate-950 border border-slate-800 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                    placeholder="+1 (555) 000-0000">
                            </div>
                            @error('phone')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-slate-300">Role</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <select name="role" id="role" 
                                    class="block w-full pl-10 pr-10 py-2.5 bg-slate-950 border border-slate-800 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all appearance-none">
                                    <option value="member" {{ old('role', $member->role) === 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="leader" {{ old('role', $member->role) === 'leader' ? 'selected' : '' }}>Leader</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('role')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Selection -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-slate-300">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>                                </div>
                                <input type="email" name="email" id="email" 
                                    value="{{ old('email', $member->user->email) }}"
                                    class="block w-full pl-10 pr-3 py-2.5 bg-slate-950 border border-slate-800 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all"
                                    placeholder="+1 (555) 000-0000">
                            </div>
                            @error('email')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Info / Stats (Read Only) -->
                    <div class="mt-8 pt-6 border-t border-slate-800">
                        <h4 class="text-sm font-medium text-slate-400 mb-4 uppercase tracking-wider">Member Statistics</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                                <p class="text-xs text-slate-500">Total Contributions</p>
                                <p class="text-lg font-semibold text-emerald-400 mt-1">
                                    ${{ number_format($member->total_amount ?? 0, 2) }}
                                </p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                                <p class="text-xs text-slate-500">Last Payment</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    {{ $member->last_payment ? $member->last_payment  : '0' }}
                                </p>
                            </div>
                            <div class="bg-slate-950 p-4 rounded-lg border border-slate-800">
                                <p class="text-xs text-slate-500">Joined Date</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    {{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end gap-4 pt-6 border-t border-slate-800">
                    <a href="{{ route('communities', $member->community->id) }}" 
                       class="px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg shadow-emerald-500/20 focus:ring-2 focus:ring-emerald-500/50 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
