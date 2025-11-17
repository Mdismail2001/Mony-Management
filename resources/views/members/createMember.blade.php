@extends('layouts.base')

@section('title', 'Add Member')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-2xl font-bold mb-6">Add New Member</h2>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store-member') }}" method="POST">
        @csrf

        <!-- Mobile -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Mobile Number</label>
            <input type="text" name="mobile" required
                class="w-full border px-3 py-2 rounded focus:ring focus:ring-indigo-300"
                placeholder="Enter mobile number">
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" required
                class="w-full border px-3 py-2 rounded focus:ring focus:ring-indigo-300">
                <option value="">Select Role</option>
                <option value="leader">Leader</option>
                <option value="member">Member</option>
            </select>
        </div>
        <input type="hidden" name="community_id" value="{{ $community->id }}">

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
            Add Member
        </button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('communities', $community->id) }}" class="text-gray-600 hover:text-gray-800">
            ⬅ Back to Community
        </a>
    </div>
</div>
@endsection
