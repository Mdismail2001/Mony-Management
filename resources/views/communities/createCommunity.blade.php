@extends('layouts.base')

@section('title', 'Create Community')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Create New Community</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('community-store') }}" method="POST">
        @csrf

        {{-- Community Name --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Community Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200">
        </div>

        {{-- Minimum Amount --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Amount *</label>
            <input type="number" name="min_amount" value="{{ old('min_amount') }}" required
                   class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-200">
        </div>


        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Create Community
        </button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('adminDashboard') }}" class="text-gray-600 hover:text-gray-800">
            ⬅ Back to Dashboard
        </a>
    </div>
</div>
@endsection
