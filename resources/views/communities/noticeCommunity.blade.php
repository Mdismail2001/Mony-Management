@extends('layouts.base')

@section('title', 'Create Notice')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 p-6">

    <div class="w-full max-w-2xl bg-white rounded-xl shadow border border-slate-200 p-6">

        {{-- Title --}}
        <div class="mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-slate-800">
                Create Community Notice
            </h2>
            <p class="text-sm text-slate-500">
                Notify members with an important announcement
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('notice-store', $community->id) }}" class="space-y-6">
            @csrf
            {{-- Notice Type --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Notice Type
                </label>
                <select name="notice_type"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg
                               focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="deposit">Deposit Reminder</option>
                    <option value="info">Information</option>
                    <option value="warning">Warning</option>
                </select>
            </div>
            {{-- For Month --}}
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">
            For Month
        </label>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>

            <input type="month"
                   name="notice_month"
                   required
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg
                          text-slate-900 placeholder-slate-400
                          focus:outline-none focus:border-emerald-500
                          focus:ring-2 focus:ring-emerald-500/20 transition-all">
        </div>
    </div>

            {{-- Notice Message --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Notice Message
                </label>
                <textarea name="notice"
                          rows="4"
                          required
                          placeholder="Please deposit your monthly amount before the deadline."
                          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg
                                 focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>

            {{-- Deadline --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Last Date (Deadline)
                </label>
                <input type="date"
                       name="notice_due_date"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg
                              focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 bg-slate-200 rounded-lg hover:bg-slate-300 text-sm">
                    Cancel
                </a>

                <button type="submit"
                        class="px-5 py-2 text-white rounded-lg text-sm
                               bg-gradient-to-r from-emerald-500 to-teal-500
                               hover:from-emerald-600 hover:to-teal-600 transition-all">
                    Publish Notice
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
