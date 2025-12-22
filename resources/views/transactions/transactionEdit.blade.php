@extends('layouts.base')

@section('title','Transaction Edit')

@section('content')
<div class=" mt-10 max-w-3xl mx-auto bg-white rounded-xl shadow border border-slate-200 p-6">

    {{-- Title --}}
    <h2 class="text-xl font-semibold text-slate-800 mb-6">
        Edit Transaction 
    </h2>

    {{-- Form --}}
    <form method="POST"
          action="{{ route('transaction-update', $transaction->id) }}"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- Amount --}}
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">
                Amount
            </label>
            <input type="number"
                   step="0.01"
                   name="amount"
                   value="{{ old('amount', $transaction->amount) }}"
                   required
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
        </div>

        {{-- Payment Date --}}
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">
                Payment Date
            </label>
            <input type="date"
                   id="payment_date"
                   name="date"
                   value="{{ old('date', $transaction->date) }}"
                   required
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
        </div>

        {{-- Month (editable, previous value selected) --}}
        <div class="col-span-2 md:col-span-1">
            <label class="block text-sm font-medium text-slate-700 mb-2">For Month</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                @php
                    $currentMonthValue = old('month', \Carbon\Carbon::parse($transaction->date)->format('Y-m'));
                @endphp

                <input type="month" name="month" value="{{ $currentMonthValue }}" required
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
            </div>
        </div>

        {{-- Proof --}}
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1">
                Proof of Payment
            </label>

            <input type="file"
                   name="proof"
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">

            @if($transaction->proof)
                <p class="text-sm mt-2">
                    Previous proof:
                    <a href="{{ asset('storage/'.$transaction->proof) }}"
                       target="_blank"
                       class="text-emerald-600 hover:underline">
                        📄 View PDF
                    </a>
                </p>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ url()->previous() }}"
               class="px-4 py-2 bg-slate-200 rounded-lg hover:bg-slate-300">
                Cancel
            </a>

            <button type="submit"
                    class="px-5 py-2 text-white rounded-lg
                           bg-gradient-to-r from-emerald-500 to-teal-500
                           hover:from-emerald-600 hover:to-teal-600">
                Update Transaction
            </button>
        </div>

    </form>
</div>

{{-- Auto-sync month when date changes --}}
<script>
    const dateInput = document.getElementById('payment_date');
    const monthSelect = document.getElementById('payment_month');

    dateInput.addEventListener('change', function () {
        if (!this.value) return;

        const date = new Date(this.value);
        const monthName = date.toLocaleString('default', { month: 'long' });
        const year = date.getFullYear();
        const newValue = `${monthName} ${year}`;

        [...monthSelect.options].forEach(option => {
            option.selected = option.value === newValue;
        });
    });
</script>
@endsection
