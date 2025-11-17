@extends('layouts.base')

@section('title', $community->name . ' Details')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6">{{ $community->name }} — Full Details</h2>

    <table class="w-full text-sm border-collapse border border-gray-200">
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
    <div class="mt-6 mb-4 flex justify-end">
        <a href="{{ route('create-member',$community->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
           + Create Member
        </a>
    </div>

    {{-- Members Table --}}
    <h3 class="text-xl font-semibold mb-3">Members </h3>
    <table class="w-full text-sm border-collapse border border-gray-200 mb-6">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        {{-- <tbody>
            @forelse 
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $member->name }}</td>
                    <td class="border px-4 py-2">{{ $member->email }}</td>
                    <td class="border px-4 py-2">{{ $member->phone }}</td>
                    <td class="border px-4 py-2">
                        <a href="" class="text-blue-600">Edit</a> |
                        <form action="" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="border px-4 py-2 text-center" colspan="5">No members yet</td>
                </tr>
            @endforelse
        </tbody> --}}
    </table>

    <div>
        <a href="{{ route('adminDashboard') }}" 
           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            ⬅ Back to Dashboard
        </a>
    </div>
</div>
@endsection
