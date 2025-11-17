@extends('layouts.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-12  ">

    <!-- MAIN CONTENT -->
    <main class="col-span-1 lg:col-span-12 p-6">

      {{-- Community create button --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('community-create') }}"
               class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                + Create Community
            </a>
        </div>

        <!-- Overview Cards -->
        <section class="flex flex-wrap gap-6 mb-10 justify-between">
            @foreach($cards as $card)
                @if(!empty($card['route']))
                  <a href="{{ $card['route'] }}" class="flex-1 min-w-[200px] bg-white shadow rounded-xl p-5 border-l-4 {{ $card['border'] }} hover:shadow-lg transition">
                      <h2 class="{{ $card['subtitle_color'] }}">{{ $card['title'] }}</h2>
                      <p class="text-xl font-semibold {{ $card['text_color'] }} mt-1">{{ $card['value_1'] }}</p>
                      <p class="text-xl font-semibold {{ $card['text_color'] }}">{{$card['value_2']}}</p>
                  </a>
                @else
                    <a href="{{ $card['route'] }}" class="flex-1 min-w-[200px] bg-white shadow rounded-xl p-5 border-l-4 {{ $card['border'] }} hover:shadow-lg transition">
                      <h2 class="{{ $card['subtitle_color'] }}">{{ $card['title'] }}</h2>
                      <p class="text-xl font-semibold {{ $card['text_color'] }} mt-1">{{ $card['value_1'] }}</p>
                      <p class="text-xl font-semibold {{ $card['text_color'] }}">{{$card['value_2']}}</p>
                  </a>
                @endif
            @endforeach
        </section>
        
        <!-- Charts Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Monthly Income vs Expenses</h3>
                <div class="w-full h-64 flex items-center justify-center text-gray-400 text-sm">
                    [ Chart Placeholder ]
                </div>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Top Spending Categories</h3>
                <ul class="text-sm text-gray-600 space-y-3">
                    <li class="flex justify-between"><span>Food & Dining</span><span class="font-semibold">$12,430</span></li>
                    <li class="flex justify-between"><span>Utilities</span><span class="font-semibold">$8,120</span></li>
                    <li class="flex justify-between"><span>Transportation</span><span class="font-semibold">$5,780</span></li>
                    <li class="flex justify-between"><span>Shopping</span><span class="font-semibold">$4,600</span></li>
                </ul>
            </div>
        </section>

        <!-- Recent User Activity -->
        <section class="bg-white shadow rounded-xl p-6 overflow-x-auto">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent User Activities</h3>
            <table class="w-full text-sm">
                <thead class="border-b text-gray-600">
                    <tr>
                        <th class="text-left py-2">User</th>
                        <th class="text-left py-2">Activity</th>
                        <th class="text-left py-2">Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">John Doe</td>
                        <td>Added new transaction</td>
                        <td>Nov 10, 2025</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">Mary Smith</td>
                        <td>Updated category</td>
                        <td>Nov 09, 2025</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">Ali Khan</td>
                        <td>Deleted expense record</td>
                        <td>Nov 08, 2025</td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>
</div>

<!-- Optional Mobile Sidebar Toggle -->
@endsection
