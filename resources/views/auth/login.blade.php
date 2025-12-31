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
            <div x-data="{ show: false }">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Password
                </label>

                <div class="relative">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        placeholder="••••••••"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-12
                            focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        required
                    />

                    <button
                        type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-emerald-600"
                        aria-label="Toggle password visibility"
                    >
                        <!-- Eye icon -->
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.577 3.01 9.964 7.178a1 1 0 010 .644C20.577 16.49 16.638 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <!-- Eye slash icon -->
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3l18 18" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.585 10.585a2 2 0 002.83 2.83" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.88 4.243A10.477 10.477 0 0112 4.5c4.638 0 8.577 3.01 9.964 7.178a10.523 10.523 0 01-4.305 5.568" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.228 6.228A10.451 10.451 0 002.036 11.678a1 1 0 000 .644C3.423 16.49 7.36 19.5 12 19.5c1.48 0 2.905-.303 4.228-.85" />
                        </svg>
                    </button>
                </div>
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
                class=" w-full items-center gap-2 px-6 py-3 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-xl font-medium hover:opacity-90 transition-all shadow-md">
            
                Sign In
            </button>
        </form>
    </div>
</div>
@endsection
