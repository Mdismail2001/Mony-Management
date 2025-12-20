@extends('layouts.base')

@section('title', 'All Members')

@section('content')

<div class="h-screen overflow-hidden bg-white flex flex-col">
    {{-- Header --}}
    @if (!empty($showHeader) && $showHeader)
        <x-header :user="auth()->user()" />
    @endif
        
    {{-- Layout Wrapper (Sidebar + Page Content) --}}
    <div class=" flex flex-1 pt-16 h-full">
        @if (!empty($showSidebar) && $showSidebar)     
            <x-sideNave />
        @endif

    <main class="flex-1 overflow-y-auto p-6 lg:p-8 {{ (!empty($showSidebar) && $showSidebar) ? 'lg:ml-64' : '' }}">
        <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                {{-- Left: Title --}}
                <h2 class="text-lg font-semibold text-slate-800">
                    All Transactions
                </h2>

                {{-- Right: Filter --}}
                <form method="GET" class="flex items-center gap-3">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search member or community..."
                        class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg
                            focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    />

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm text-white
                            bg-gradient-to-r from-emerald-400 to-teal-400
                            rounded-lg
                            hover:from-emerald-500 hover:to-teal-500">
                        Search
                    </button>


                    @if(request('search'))
                        <a href="{{ route('all-transactions') }}"
                        class="px-3 py-2 text-sm bg-slate-200 rounded-lg hover:bg-slate-300">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">No</th>
                        <th class="px-6 py-3 text-left font-medium">Member Name</th>
                        <th class="px-6 py-3 text-left font-medium">Last Deposit</th>
                        <th class="px-6 py-3 text-left font-medium">Total Deposit</th>
                        <th class="px-6 py-3 text-left font-medium">Deposit Type</th>
                        <th class="px-6 py-3 text-left font-medium">Community Name</th>
                        <th class="px-6 py-3 text-left font-medium">Community Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transactions as $index => $transaction)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $transaction->member_name }}</td>
                        <td class="px-6 py-4">{{ number_format($transaction->last_deposit ?? 0, 2) }}</td>
                        <td class="px-6 py-4">{{ number_format($transaction->member_total ?? 0, 2) }}</td>
                        <td class="px-6 py-4">--</td>
                        <td class="px-6 py-4">{{ $transaction->community_name }}</td>
                        <td class="px-6 py-4">{{ number_format($transaction->community_total ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-500">
                            No transactions found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    </div>
    

</div>

@endsection