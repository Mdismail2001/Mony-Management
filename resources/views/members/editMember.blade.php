@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-white py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Member</h1>
                <p class="mt-1 text-gray-600 text-sm sm:text-base">
                    Update member information and permissions
                </p>
            </div>

            <a href="{{ route('communities', $member->community->id) }}"
               class="flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Community
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xl overflow-hidden">
            <form action="{{ route('update-member', $member->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <!-- Profile Top -->
                <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-200">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-md">
                        <span class="text-2xl font-bold text-white">
                            {{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-center sm:text-left">
                        <h3 class="text-lg font-semibold text-gray-900">Profile Information</h3>
                        <p class="text-gray-500 text-sm">Update the member's personal details</p>
                    </div>

                    @if (session('success'))
                        <div class="ml-auto px-4 py-2 bg-emerald-500 text-white rounded-lg shadow">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Form Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $member->user->name) }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone_number"
                               value="{{ old('phone_number', $member->user->phone_number) }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('phone_number')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Role</label>
                        <select name="role"
                                class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="member" {{ old('role', $member->role) === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="leader" {{ old('role', $member->role) === 'leader' ? 'selected' : '' }}>Leader</option>
                        </select>
                        @error('role')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $member->user->email) }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('email')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Statistics -->
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Member Statistics</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs text-gray-500">Total Contributions</p>
                            <p class="text-lg font-semibold text-emerald-600 mt-1">
                                ${{ number_format($member->total_amount ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs text-gray-500">Last Payment</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $member->last_payment ?: '0' }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-xs text-gray-500">Joined Date</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('communities', $member->community->id) }}"
                       class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition shadow">
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
