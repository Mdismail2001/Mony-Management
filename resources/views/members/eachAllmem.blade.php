@extends('layouts.base')

@section('title', 'All Members')

@section('content')

<div class="overflow-x-auto ">

    {{-- Back Button --}}
    <div class="p-4">
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
        title="All Members"
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
                // 'route' => route('members.export', request()->query())
            ]
        ]"
    />
    <table class="w-full min-w-[600px]">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Community</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Last Deposit</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total Amount</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
        @forelse ($community->members as $index => $member)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3 text-sm font-medium">
                    {{ $index + 1 }}
                </td>

                {{-- Name --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center shadow">
                            <span class="text-sm font-semibold text-white">
                                {{ strtoupper(substr($member->user->name ?? 'N', 0, 1)) }}
                            </span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $member->user->name ?? 'N/A' }}
                        </span>
                    </div>
                </td>

                {{-- Phone --}}
                <td class="px-4 py-3 text-sm text-gray-700">
                    {{ $member->user->phone_number ?? 'N/A' }}
                </td>

                {{-- Community --}}
                <td class="px-4 py-3 text-sm text-gray-700">
                    {{ $community->name }}
                </td>

                {{-- Role --}}
                <td class="px-4 py-3">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $member->role === 'admin'
                            ? 'bg-purple-100 text-purple-700 border border-purple-200'
                            : 'bg-gray-100 text-gray-700 border border-gray-200' }}">
                        {{ ucfirst($member->role) }}
                    </span>
                </td>

                {{-- Last Deposit --}}
                <td class="px-4 py-3 text-sm text-gray-700">
                    {{ number_format($member->last_payment ?? 0, 2) }}
                </td>

                {{-- Total Amount --}}
                <td class="px-4 py-3 text-sm font-semibold text-emerald-500">
                    {{ number_format($member->total_amount ?? 0, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center">
                    <p class="text-gray-600 font-medium">No members found</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@endsection
