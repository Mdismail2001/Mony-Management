@extends('layouts.base')

@section('title', 'Add Member')

@section('content')
<div class="min-h-screen bg-white p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-xl mx-auto">
        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-6 sm:p-8 border border-gray-200">
            
            <!-- Heading -->
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-900 text-center sm:text-left">
                Add New Member
            </h2>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('store-member') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input type="email" name="email" required
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 px-4 py-3 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-gray-400"
                        placeholder="user@example.com">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 px-4 py-3 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        <option value="">Select Role</option>
                        <option value="leader">Leader</option>
                        <option value="member">Member</option>
                    </select>
                </div>

                <!-- Hidden Community ID -->
                <input type="hidden" name="community_id" value="{{ $community->id }}">

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-medium py-3 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-md">
                    Add Member
                </button>
            </form>

            <!-- Back Link -->
            <div class="mt-6 text-center sm:text-left">
                <a href="{{ route('communities', $community->id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Community
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
