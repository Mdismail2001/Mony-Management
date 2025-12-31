@extends('layouts.base')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-200 p-6">

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Forgot Password</h2>
            @if ($errors->has('message'))
                <p class="text-sm text-red-600 mt-2">
                    {{ $errors->first('message') }}
                </p>
            @endif
            <p class="text-sm text-gray-500 mt-1">
                Recover your account using email or mobile number
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password-otpSend') }}" class="space-y-5">
            @csrf

            <!-- Recovery Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Recovery Method
                </label>

                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="type" value="email" checked
                               class="text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm text-gray-700">Email</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="type" value="phone_number"
                               class="text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm text-gray-700">Mobile Number</span>
                    </label>
                </div>
            </div>

            <!-- Email Input -->
            <div id="emailField">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="example@email.com"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
            </div>

            <!-- Mobile Input -->
            <div id="mobileField" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mobile Number
                </label>
                <input
                    type="text"
                    name="phone_number"
                    placeholder="01XXXXXXXX"
                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                >
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg font-semibold transition">
                Send OTP
            </button>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:underline">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Toggle Script -->
<script>
    const radios = document.querySelectorAll('input[name="type"]');
    const emailField = document.getElementById('emailField');
    const mobileField = document.getElementById('mobileField');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'email') {
                emailField.classList.remove('hidden');
                mobileField.classList.add('hidden');
            } else {
                mobileField.classList.remove('hidden');
                emailField.classList.add('hidden');
            }
        });
    });
</script>
@endsection
