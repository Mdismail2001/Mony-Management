@extends('layouts.base')

@section('content')
<div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 mx-auto mt-10">
    <div class="text-center mb-6">
        <div class="bg-emerald-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-emerald-700">Complete Your Registration</h1>
        <p class="text-gray-600 mt-2">You've been invited to join <strong>{{ $community->name }}</strong></p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invite.register') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
        <input type="hidden" name="community_id" value="{{ $communityId }}" />
        <input type="hidden" name="role" value="{{ $role }}" />

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
            <input type="text" value="{{ $phoneNumber }}" readonly
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" />
            <p class="text-xs text-gray-500 mt-1">This phone number is pre-assigned to you</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500" 
                   placeholder="Enter your full name" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500" 
                   placeholder="your.email@example.com" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500" 
                   placeholder="Create a password (min. 6 characters)" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500" 
                   placeholder="Re-enter your password" />
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-xs text-blue-800">
                <strong>Note:</strong> By registering, you'll automatically join <strong>{{ $community->name }}</strong> as a <strong>{{ ucfirst($role) }}</strong>.
            </p>
        </div>

        <button type="submit"
                class="w-full bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium">
            Create Account & Join Community
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('loginForm') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                Login here
            </a>
        </p>
    </div>
</div>
@endsection