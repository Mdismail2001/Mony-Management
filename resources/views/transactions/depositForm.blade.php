@extends('layouts.base')
@section('title', 'Deposit Form')
@section('content')

<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-2">New Deposit</h2>
            <p class="text-slate-600">Record a new payment transaction for this member.</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="member_id" value="{{ $memberId }}">
            <input type="hidden" name="community_id" value="{{ $communityId }}">

            <!-- Context Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="h-10 w-10 rounded-full bg-emerald-50 flex items-center justify-center border border-emerald-100">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-slate-500">Recording deposit for</div>
                    <div class="font-medium text-slate-900 flex gap-3 text-sm mt-0.5">
                        <span>Member ID: <span class="text-emerald-600">{{ $memberId }}</span></span>
                        <span class="text-slate-300">|</span>
                        <span>Community ID: <span class="text-emerald-600">{{ $communityId }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-lg shadow-slate-200/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Amount -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Amount (RM)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-semibold">RM</span>
                            </div>
                            <input type="number" name="amount" step="0.01" required placeholder="0.00"
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Month Selection -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-slate-700 mb-2">For Month</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="month" name="month" required
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Deposit Date -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Transaction Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="date" name="date" required
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                    <!-- Proof Upload -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Payment Proof</label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-emerald-50 rounded-lg pointer-events-none group-hover:bg-emerald-100 transition-colors"></div>
                            <input type="file" name="proof" accept="image/*,application/pdf" required
                                class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-l-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-emerald-100 file:text-emerald-700
                                hover:file:bg-emerald-200
                                border border-slate-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:border-emerald-500 transition-all">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Accepted formats: JPG, PNG, PDF. Max size: 2MB</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-4">
                    <a href="{{ route('communities', $communityId) }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-lg shadow-emerald-900/10 transition-all transform active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Submit Deposit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
