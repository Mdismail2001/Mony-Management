@extends('layouts.base')

@section('content')
<div class="min-h-screen flex justify-center items-center bg-slate-100 p-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-700">Login</h1>
            {{-- Success message --}}
            @if (session('message'))
                <p class="text-sm text-green-600 mb-3">
                    {{ session('message') }}
                </p>
            @endif

            <p class="text-gray-500 text-sm mt-1">Access your account securely</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Phone Number -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-600 mb-1">
                    Phone Number
                </label>
                <input
                    type="text"
                    id="phone_number"
                    name="phone_number"
                    value="{{ old('phone_number') }}"
                    placeholder="Enter your phone number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    required
                />
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    required
                />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        class="text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                    />
                    <span class="ml-2 text-gray-600">Remember me</span>
                </label>
                <a href="{{ route('password-request') }}" class="text-emerald-600 hover:underline">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium"
            >
                Sign In
            </button>
        </form>
    </div>
</div>
@endsection
