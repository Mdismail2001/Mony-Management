@extends('layouts.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-slate-700">
    <main class="p-6 lg:p-8">
        
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Dashboard Overview</h1>
                <p class="text-slate-400">Monitor your community financial health at a glance</p>
            </div>
            {{-- controller message show --}}
{{-- Controller success message (auto hide after 5 seconds) --}}
@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 5000)" 
        x-show="show"
        x-transition
        class="mt-4 bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg text-sm flex items-center gap-2"
    >
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
@endif
            {{-- end message show --}}
            <a href="{{ route('community-create') }}"
               class="mt-4 lg:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/50 hover:shadow-emerald-900/70">
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
                $icon = $iconMap[$card['title']] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />';
            @endphp
            
            <a href="{{ $card['route'] ?? '#' }}" class="group relative bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6 hover:border-slate-700 transition-all hover:shadow-xl hover:shadow-slate-900/50">
                <!-- Icon -->
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-slate-800/50 rounded-xl group-hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $icon !!}
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <h3 class="text-sm font-medium text-slate-400 mb-2">{{ $card['title'] }}</h3>
                <div class="space-y-1">
                    <p class="text-2xl font-bold text-white">{{ $card['value_1'] }}</p>
                    @if(!empty($card['value_2']))
                        <p class="text-lg font-semibold text-slate-300">{{ $card['value_2'] }}</p>
                    @endif
                </div>
            </a>
        @endforeach
    </section>        
        <!-- Charts Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Income vs Expenses Chart -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Monthly Income vs Expenses</h3>
                        <p class="text-sm text-slate-400">Financial trend overview</p>
                    </div>
                    <div class="flex gap-4 text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <span class="text-slate-400">Income</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <span class="text-slate-400">Expenses</span>
                        </div>
                    </div>
                </div>
                <div class="w-full h-64 flex items-center justify-center border border-dashed border-slate-700 rounded-xl">
                    <span class="text-slate-500 text-sm">Chart Visualization</span>
                </div>
            </div>

            <!-- Top Spending Categories -->
            <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white mb-1">Top Spending Categories</h3>
                    <p class="text-sm text-slate-400">Breakdown by expense type</p>
                </div>
                <div class="space-y-4">
                    @php
                        $categories = [
                            ['name' => 'Food & Dining', 'amount' => '$12,430', 'percentage' => 35, 'color' => 'bg-blue-500'],
                            ['name' => 'Utilities', 'amount' => '$8,120', 'percentage' => 25, 'color' => 'bg-emerald-500'],
                            ['name' => 'Transportation', 'amount' => '$5,780', 'percentage' => 20, 'color' => 'bg-amber-500'],
                            ['name' => 'Shopping', 'amount' => '$4,600', 'percentage' => 20, 'color' => 'bg-rose-500']
                        ];
                    @endphp
                    
                    @foreach($categories as $category)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300 font-medium">{{ $category['name'] }}</span>
                                <span class="text-white font-semibold">{{ $category['amount'] }}</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                <div class="{{ $category['color'] }} h-full rounded-full transition-all duration-500" 
                                     style="width: {{ $category['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Recent User Activity -->
        <section class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Recent User Activities</h3>
                    <p class="text-sm text-slate-400">Latest community actions and updates</p>
                </div>
                <button class="px-4 py-2 text-sm text-slate-400 hover:text-white border border-slate-700 hover:border-slate-600 rounded-lg transition-colors">
                    View All
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-800">
                            <th class="text-left py-3 px-4 font-medium text-slate-400">User</th>
                            <th class="text-left py-3 px-4 font-medium text-slate-400">Activity</th>
                            <th class="text-left py-3 px-4 font-medium text-slate-400">Date</th>
                            <th class="text-right py-3 px-4 font-medium text-slate-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @php
                            $activities = [
                                ['user' => 'John Doe', 'activity' => 'Added new transaction', 'date' => 'Nov 10, 2025', 'status' => 'completed'],
                                ['user' => 'Mary Smith', 'activity' => 'Updated category', 'date' => 'Nov 09, 2025', 'status' => 'completed'],
                                ['user' => 'Ali Khan', 'activity' => 'Deleted expense record', 'date' => 'Nov 08, 2025', 'status' => 'completed'],
                                ['user' => 'Sarah Johnson', 'activity' => 'Created new report', 'date' => 'Nov 07, 2025', 'status' => 'pending']
                            ];
                        @endphp
                        
                        @foreach($activities as $activity)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-emerald-400 font-medium">
                                            {{ substr($activity['user'], 0, 1) }}
                                        </div>
                                        <span class="text-white font-medium">{{ $activity['user'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-slate-300">{{ $activity['activity'] }}</td>
                                <td class="py-4 px-4 text-slate-400">{{ $activity['date'] }}</td>
                                <td class="py-4 px-4 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $activity['status'] === 'completed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
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
@endsection
