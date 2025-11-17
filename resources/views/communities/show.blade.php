@extends('layouts.base')

@section('title', $community->name . ' Details')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    {{-- Community Title --}}
    <h2 class="text-3xl font-bold mb-6">{{ $community->name }} — Full Details</h2>

    {{-- Community Info Table --}}
    <table class="w-full text-sm border border-gray-200 border-collapse mb-6">
        <tbody>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 w-1/3 text-left">Community Name</th>
                <td class="border px-4 py-2">{{ $community->name }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2 text-left">Minimum Amount</th>
                <td class="border px-4 py-2">${{ $community->min_amount }}</td>
            </tr>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Total Amount</th>
                <td class="border px-4 py-2">${{ $community->total_amount }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2 text-left">Created At</th>
                <td class="border px-4 py-2">{{ $community->created_at->format('Y-m-d') }}</td>
            </tr>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Updated At</th>
                <td class="border px-4 py-2">{{ $community->updated_at->format('Y-m-d') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Create Member Button --}}
    <div class="flex justify-end mb-6">
        <a href="{{ route('create-member', $community->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Create Member
        </a>
    </div>

    {{-- Members Table --}}
    <h3 class="text-xl font-semibold mb-3">Members</h3>
    <table class="w-full text-sm border border-gray-200 border-collapse">
        <thead class="bg-gray-100 text-gray-700 text-left">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Last Deposit</th>
                <th class="border px-4 py-2">Total Amount</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($community->members as $index => $member)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $member->user->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $member->user->phone_number ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $member->role }}</td>
                    <td class="border px-4 py-2">{{ $member->last_payment ?? '-' }}</td>
                    <td class="border px-4 py-2">${{ $member->total_amount ?? 0 }}</td>
                    <td class="border px-4 py-2">
                        <a href="#"
                           class="text-blue-600 hover:underline">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center border px-4 py-2">No members yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Back Button --}}
    <div class="mt-6">
        <a href="{{ route('adminDashboard') }}"
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            ⬅ Back to Dashboard
        </a>
    </div>
</div>
@endsection
