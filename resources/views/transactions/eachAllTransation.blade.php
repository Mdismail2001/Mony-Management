@extends('layouts.base')

@section('title', 'All Transaction')

@section('content')

<div class="overflow-x-auto ">

    {{-- Back Button --}}
    <div class="m-4 mt-6">
        <a href="{{ route('communities', $community->id) }}"
           class="inline-flex items-center gap-2 text-slate-600 hover:text-emerald-500 transition-colors group">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-medium">Back to Community</span>
        </a>
    </div>
    {{-- Member Filtring option --}} 
    <x-filter-bar
        title="Transactions History" 
        search-field="search"
        search-placeholder="Name or Community..."
        :filters="[
            'year' => range(date('Y'), date('Y') - 3),
            'month' => [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ]
        ]"
        :actions="[
            [
                'label' => 'Download',
                'route' => route('eachAllTransactions', array_merge(request()->query(), [
                    'id' => $community->id, 
                    'excelfile' => true
                ]))            
            ]
        ]"
    />

    <table class="w-full min-w-[600px]">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Month</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($community->transactions as $index => $transaction)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{$index + 1}}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
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
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{-- PAGINATION UI OUTSIDE TABLE --}}
    <div class=" px-4 ">
        <x-pagination :paginator="null" />
    </div>
</div>

@endsection
