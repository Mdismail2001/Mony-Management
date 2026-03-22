@extends('layouts.base')
@section('title', 'Confirmation')
@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Join Community
        </h2>

        <p class="text-gray-600 mb-6">
            You are invited to join 
            <strong class="text-emerald-600">{{ $community->name }}</strong>
            as a 
            <strong>{{ ucfirst($role) }}</strong>.
        </p>

        <form action="{{ route('community.accept') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <button type="submit"
                class="w-full bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium">
                ✅ Confirm & Join
            </button>
        </form>

        <a href="{{ url()->previous() }}"
           class="block mt-4 text-sm text-gray-500 hover:underline">
            Cancel
        </a>

    </div>

</div>

@endsection