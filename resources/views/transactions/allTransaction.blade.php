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

    <main class="flex-1 overflow-y-auto lg:p-6 {{ (!empty($showSidebar) && $showSidebar) ? 'lg:ml-64' : '' }}">
        @php
        $columns = [
            'No','Member Name', 'Last Deposit', 'Total Deposit',
            'Deposit Type', 'Community Name', 'Community Total'
        ];

        $rows = $transactions->map(function($t) {
            return [
                $t->member_name,
                number_format($t->last_deposit ?? 0, 2),
                number_format($t->member_total ?? 0, 2),
                '--',
                $t->community_name,
                number_format($t->community_total ?? 0, 2)
            ];
        });
        @endphp

        @include('components.data-table', [
            'title' => 'All Transactions',
            'searchField' => 'search',
            'searchPlaceholder' => 'Search member or community...',
            'columns' => $columns,
            'rows' => $rows,
            'downloadRoute' => 'all-transactions',
        ])
    </main>

    </div>
    

</div>

@endsection