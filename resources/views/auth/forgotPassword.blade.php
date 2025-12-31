@extends('layouts.base')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8"
         x-data="{ type: 'email' }">

        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-700">
                Forgot Password
            </h1>

            @if ($errors->has('message'))
                <p class="text-sm text-red-600 mt-2">
                    {{ $errors->first('message') }}
                </p>
            @endif

            <p class="text-gray-500 text-sm mt-1">
                Recover your account securely
            </p>
        </div>

        <!-- Toggle -->
        <div class="flex bg-gray-100 rounded-xl p-1 mb-6">
            <button
                type="button"
                @click="type = 'email'"
                :class="type === 'email'
                    ? 'bg-white shadow text-emerald-600'
                    : 'text-gray-500'"
                class="flex-1 py-2 rounded-lg text-sm font-medium transition">
                Email
            </button>

            <button
                type="button"
                @click="type = 'phone_number'"
                :class="type === 'phone_number'
                    ? 'bg-white shadow text-emerald-600'
                    : 'text-gray-500'"
                class="flex-1 py-2 rounded-lg text-sm font-medium transition">
                Mobile
            </button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password-otpSend') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="type" :value="type">

            <!-- Email -->
            <div x-show="type === 'email'">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="example@email.com"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2
                           focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Mobile -->
            <div x-show="type === 'phone_number'">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Mobile Number
                </label>
                <input
                    type="text"
                    name="phone_number"
                    placeholder="01XXXXXXXX"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2
                           focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full px-6 py-3 bg-gradient-to-br
                       from-emerald-500 to-teal-600 text-white
                       rounded-xl font-medium hover:opacity-90
                       transition-all shadow-md">
                Send OTP
            </button>

            <!-- Back -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                   class="text-sm text-emerald-600 hover:underline">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
