@extends('layouts.base')

@section('title', 'Verify Email | Money Manager')

@section('content')
<div class="relative min-h-screen w-full flex items-center justify-center bg-gray-900 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/014/403/884/small/us-dollar-bills-and-candlestick-chart-showing-changes-in-price-of-money-photo.jpg"
             class="w-full h-full object-cover opacity-30"
             alt="Background">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 to-gray-900/40"></div>
    </div>

    {{-- Card --}}
    <div class="relative z-10 w-full max-w-md p-8 mx-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl shadow-2xl">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12H8m8 0l-3-3m3 3l-3 3M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-white">Verify Email</h1>
            <p class="text-emerald-300/80 text-sm mt-2">
                Enter your email to receive a verification code
            </p>

            {{-- Messages --}}
            @if (session('success'))
                <div class="mt-4 p-2 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
                    <p class="text-xs text-emerald-400 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-2 bg-red-500/20 border border-red-500/30 rounded-lg text-left">
                    <ul class="text-xs text-red-400 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Email Form --}}
        <form action="{{ route('send-otp') }}" method="POST"  class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-1 px-1">
                    Email Address
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="john@example.com"
                       required
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3
                              text-white placeholder-gray-500 focus:outline-none
                              focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all">
            </div>

            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600
                       text-white rounded-xl font-bold shadow-lg
                       shadow-emerald-900/20 hover:scale-[1.02]
                       active:scale-95 transition-all">
                Send Verification Code
            </button>
        </form>

        {{-- Footer --}}
        <div class="mt-8 pt-6 border-t border-white/10 text-center">
            <a href="{{ url()->previous() }}"
               class="text-sm text-gray-400 hover:text-emerald-400 transition">
                ← Go Back
            </a>
        </div>
    </div>
</div>
@endsection
