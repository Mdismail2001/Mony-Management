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
        <!-- Form -->
        <form action="{{ route('store-transaction') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="member_id" value="{{ $memberId }}">
            <input type="hidden" name="community_id" value="{{ $communityId }}">

            <!-- Form Card -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-lg shadow-slate-200/50">
                <!-- Community Banking Info -->
                <div class="bg-white ">
                    <h1 class="text-lg font-bold text-slate-900 mb-2">
                        Banking Information
                    </h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach ($communityBankDetails as $detail)

                            @if($detail['type'] === 'Bank')
                                <!-- Bank Dropdown -->
                                <details class=" group border border-slate-200 rounded-lg bg-slate-50">
                                    <summary class="flex justify-between items-center cursor-pointer p-2 font-semibold text-slate-700">
                                        🏦 Bank
                                        <span class="transition-transform group-open:rotate-180">⌄</span>
                                    </summary>

                                    <ul class="px-4 pb-4 space-y-2 text-sm">
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Name</span>
                                            <span class="font-medium select-all">{{ $detail['bank_name'] }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Account</span>
                                            <span class="font-medium select-all">{{ $detail['bank_account_no'] }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Holder</span>
                                            <span class="font-medium select-all">{{ $detail['bank_holder_name'] }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Branch</span>
                                            <span class="font-medium select-all">{{ $detail['branch'] }}</span>
                                        </li>
                                    </ul>
                                </details>
                            @endif

                            @if($detail['type'] === 'Mobile Bank')
                                <!-- Mobile Bank Dropdown -->
                                <details class=" group border border-slate-200 rounded-lg bg-slate-50">
                                    <summary class="flex justify-between items-center cursor-pointer p-2 font-semibold text-slate-700">
                                        📱 Mobile Bank
                                        <span class="transition-transform group-open:rotate-180">⌄</span>
                                    </summary>

                                    <ul class="px-4 pb-4 space-y-2 text-sm">
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Service</span>
                                            <span class="font-medium select-all">{{ $detail['mobile_type'] }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Number</span>
                                            <span class="font-medium select-all">{{ $detail['mobile_account_no'] }}</span>
                                        </li>
                                        <li class="flex justify-between">
                                            <span class="text-slate-500">Holder</span>
                                            <span class="font-medium select-all">{{ $detail['mobile_holder_name'] }}</span>
                                        </li>
                                    </ul>
                                </details>
                            @endif

                        @endforeach

                    </div>
                </div>

                {{-- <h1 class="text-lg font-bold text-slate-900  border-b border-slate-200 pt-2">Submit Form</h1> --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                    
                    <!-- Amount -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Amount (RM)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-semibold">RM</span>
                            </div>
                            <input type="number" name="amount" step="0.01" required placeholder="0.00"
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
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
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
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
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                        </div>
                    </div>

                   <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Proof of Payment
                        </label>

                        <div class="relative">
                            <!-- Icon -->
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 00-5.656-5.656L5.757 10.757a6 6 0 108.486 8.486L20 13" />
                                </svg>
                            </div>

                            <!-- File Input -->
                            <input
                                type="file"
                                name="proof"
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-900
                                    file:hidden
                                    focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                            />
                        </div>

                        <p class="mt-1 text-xs text-slate-500">
                            Accepted formats: JPG, PNG, PDF
                        </p>
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
