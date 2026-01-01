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
            $columns = ['No', 'Member Name', 'Community', 'Mobile', 'Last Deposit', 'Last Activity'];

            $rows = $members->map(function($m) {
                return [
                    $m->member_name,
                    $m->community_name,
                    $m->phone_number,
                    number_format($m->last_payment ?? 0, 2),
                    '--',
                ];
            });
            @endphp
            @include('components.data-table', [
            'title' => 'All Members',
            'searchField' => 'search',
            'searchPlaceholder' => 'Search member or community...',
            'columns' => $columns,
            'rows' => $rows
            ])
        </main>

    </div>
    
</div>

@endsection