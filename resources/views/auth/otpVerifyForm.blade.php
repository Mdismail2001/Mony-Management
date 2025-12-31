@extends('layouts.base')
@section('title','Verify OTP')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100 p-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-emerald-700">
                Verify OTP
            </h1>

            @if (session('message'))
                <p class="text-sm text-green-600 mt-2">
                    {{ session('message') }}
                </p>
            @endif

            <p class="text-gray-500 text-sm mt-1">
                Enter the 6-digit code sent to you
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('submit-otp') }}" class="space-y-5">
            @csrf

            <!-- OTP Input -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    OTP Code
                </label>
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    inputmode="numeric"
                    placeholder="••••••"
                    class="w-full text-center tracking-widest text-xl
                           border border-gray-300 rounded-lg px-4 py-3
                           focus:outline-none focus:ring-2
                           focus:ring-emerald-500"
                    required
                >

                @error('otp')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full px-6 py-3 bg-gradient-to-br
                       from-emerald-500 to-teal-600 text-white
                       rounded-xl font-medium hover:opacity-90
                       transition-all shadow-md">
                Verify OTP
            </button>

            <!-- Back -->
            <div class="text-center">
                <a href="{{ route('password-request') }}"
                   class="text-sm text-emerald-600 hover:underline">
                    Change recovery method
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
