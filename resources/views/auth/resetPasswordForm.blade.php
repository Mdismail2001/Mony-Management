@extends('layouts.base')
@section('title','Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-700">
                Reset Password
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Enter your new password to secure your account
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('reset-password') }}" class="space-y-5">
            @csrf

            <!-- New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    required
                >
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full px-6 py-3 bg-gradient-to-br from-emerald-500 to-teal-600
                       text-white rounded-xl font-medium hover:opacity-90 transition-all shadow-md"
            >
                Reset Password
            </button>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:underline mt-3 inline-block">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
