@extends('layouts.base')
@section('title','Verify OTP')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('submit-otp') }}"
          class="bg-white p-6 rounded-xl shadow w-full max-w-sm">
        @csrf

        <h2 class="text-xl font-bold mb-4">Verify OTP</h2>

        {{-- Success message --}}
        @if (session('message'))
            <p class="text-sm text-green-600 mb-3">
                {{ session('message') }}
            </p>
        @endif

        {{-- Validation error --}}
        @error('otp')
            <p class="text-sm text-red-600 mb-3">
                {{ $message }}
            </p>
        @enderror

        <input type="text"
               name="otp"
               maxlength="6"
               class="w-full border rounded-lg p-2 mb-4"
               placeholder="Enter 6 digit OTP">

        <button class="w-full bg-emerald-600 text-white py-2 rounded-lg">
            Verify
        </button>
    </form>
</div>
@endsection


