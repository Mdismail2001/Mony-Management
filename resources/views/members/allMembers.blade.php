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
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">All Members</h2>

                    <!-- Search -->
                    <form method="GET" action="{{ route('all-members') }}">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search member or community..."
                            class="w-56 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </form>
                </div>
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">No</th>
                                <th class="px-6 py-3 text-left font-medium">Name</th>
                                <th class="px-6 py-3 text-left font-medium">Community</th>
                                <th class="px-6 py-3 text-left font-medium">Mobile</th>
                                <th class="px-6 py-3 text-left font-medium">Last Deposit</th>
                                <th class="px-6 py-3 text-left font-medium">Last Activity</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            {{-- Example Row --}}
                            @foreach ($members as $index => $member)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-600">{{$index + 1}}</td>

                                <td class="px-6 py-4 flex items-center space-x-3">
                                    @if(!empty($member->photo))
                                        <img 
                                            src="{{ asset('storage/' . $member->photo) }}" 
                                            alt="{{ $member->member_name }}"
                                            class="w-8 h-8 rounded-full object-cover"
                                        >
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-semibold">
                                            {{ strtoupper(substr($member->member_name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <span class="font-medium text-slate-800">
                                        {{ $member->member_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{$member->community_name}}</td>

                                <td class="px-6 py-4 text-slate-700">{{$member->phone_number}}</td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium text-center">
                                         {{ $member->last_payment !== null
                                                ? number_format((float) $member->last_payment, 2)
                                                : '0.00'
                                        }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    N/A
                                </td>
                            </tr>
                            @endforeach
                            {{-- Empty State --}}
                            {{-- 
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                    No members found
                                </td>
                            </tr> 
                            --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
    

</div>

@endsection