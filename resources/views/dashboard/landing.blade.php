@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')
<div class="h-screen overflow-hidden bg-white flex flex-col">
    {{-- Header --}}
    @if (!empty($showHeader) && $showHeader)
        <x-header :user="$user" />
    @endif

    {{-- Layout Wrapper (Sidebar + Page Content) --}}
    <div class="flex flex-1 pt-16 h-full">
        @if (!empty($showSidebar) && $showSidebar)     
            <x-sideNave />
        @endif
    
        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8 {{ (!empty($showSidebar) && $showSidebar) ? 'lg:ml-64' : '' }}">
            
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
                    <p class="text-gray-600">Monitor your community financial health at a glance</p>
                </div>

                {{-- Controller success message --}}
                @if(session('success'))
                    <div 
                        x-data="{ show: true }" 
                        x-init="setTimeout(() => show = false, 5000)" 
                        x-show="show"
                        x-transition
                        class="mt-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2"
                        >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('community-create') }}"
                   class="mt-4 lg:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-500 transition-all shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Community
                </a>
            </div>

            <!-- Overview Cards -->
            @php
                $cardCount = count($cards);
                $gridClass = match($cardCount) {
                    1 => 'grid-cols-1',
                    2 => 'grid-cols-1 md:grid-cols-2',
                    3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
                    default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4'
                };
            @endphp
            <section class="grid {{ $gridClass }} gap-6 mb-8">
                @foreach($cards as $card)
                    @php
                        $iconMap = [
                            'Total Communities' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />',
                            'Total Members' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                            'Total Income' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />',
                            'Total Expenses' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />'
                        ];
                        $icon = $iconMap[$card['title']] ?? '';
                    @endphp
                    
                    <a href="{{ $card['route'] ?? '#' }}" class="group relative bg-gray-100 border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-emerald-600 rounded-xl flex items-center justify-center w-12 h-12">
                                <span class="text-white text-xl font-bold">
                                    {{ strtoupper(substr($card['title'], 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $card['title'] }}</h3>
                        <p class="text-gray-600 font-bold">{{ $card['value_1'] }}</p>
                        @if(!empty($card['value_2']))
                            <p class="text-gray-500 font-semibold">{{ $card['value_2'] }}</p>
                        @endif
                    </a>

                @endforeach
            </section>
          
            <!-- Charts Section -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Monthly Income vs Expenses</h3>
                            <p class="text-gray-500 text-sm">Financial trend overview</p>
                        </div>
                    </div>
                    <div class="w-full h-64 flex items-center justify-center border border-dashed border-gray-300 rounded-xl">
                        <span class="text-gray-400 text-sm">Chart Visualization</span>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Top Spending Categories</h3>
                    <p class="text-gray-500 text-sm mb-6">Breakdown by expense type</p>

                    @foreach([
                        ['name' => 'Food & Dining', 'amount' => '$12,430', 'percentage' => 35, 'color' => 'bg-blue-500'],
                        ['name' => 'Utilities', 'amount' => '$8,120', 'percentage' => 25, 'color' => 'bg-emerald-500'],
                        ['name' => 'Transportation', 'amount' => '$5,780', 'percentage' => 20, 'color' => 'bg-amber-500'],
                        ['name' => 'Shopping', 'amount' => '$4,600', 'percentage' => 20, 'color' => 'bg-rose-500']
                    ] as $category)
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm font-medium">
                                <span class="text-gray-700">{{ $category['name'] }}</span>
                                <span class="text-gray-900">{{ $category['amount'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="{{ $category['color'] }} h-full" style="width: {{ $category['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Recent Activities -->
            <section class="bg-white border border-gray-200 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Recent User Activities</h3>
                        <p class="text-sm text-gray-500">Latest community actions and updates</p>
                    </div>
                    <button class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        View All
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-600">User</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Activity</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Date</th>
                                <th class="text-right py-3 px-4 font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach([
                                ['user' => 'John Doe', 'activity' => 'Added new transaction', 'date' => 'Nov 10, 2025', 'status' => 'completed'],
                                ['user' => 'Mary Smith', 'activity' => 'Updated category', 'date' => 'Nov 09, 2025', 'status' => 'completed'],
                                ['user' => 'Ali Khan', 'activity' => 'Deleted expense record', 'date' => 'Nov 08, 2025', 'status' => 'completed'],
                                ['user' => 'Sarah Johnson', 'activity' => 'Created new report', 'date' => 'Nov 07, 2025', 'status' => 'pending']
                            ] as $activity)
                                <tr class="hover:bg-gray-100 transition">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-emerald-500 font-medium">
                                                {{ substr($activity['user'], 0, 1) }}
                                            </div>
                                            <span class="text-gray-900 font-medium">{{ $activity['user'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-700">{{ $activity['activity'] }}</td>
                                    <td class="py-4 px-4 text-gray-500">{{ $activity['date'] }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                            {{ $activity['status'] === 'completed'
                                                ? 'bg-emerald-100 text-emerald-600 border border-emerald-300'
                                                : 'bg-amber-100 text-amber-600 border border-amber-300' }}">
                                            {{ ucfirst($activity['status']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection
