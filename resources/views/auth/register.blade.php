@extends('layouts.base')

@section('title', 'Create Account | Money Manager')

@section('content')
<div class="relative min-h-screen w-full flex items-center justify-center bg-gray-900 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <img
            src="https://static.vecteezy.com/system/resources/thumbnails/014/403/884/small/us-dollar-bills-and-candlestick-chart-showing-changes-in-price-of-money-photo.jpg"
            class="w-full h-full object-cover opacity-30"
            alt="Background"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 to-gray-900/40"></div>
    </div>

    {{-- Register Card --}}
    <div class="relative z-10 w-full max-w-md p-8 mx-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl shadow-2xl">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-white">Create Account</h1>
            <p class="text-emerald-300/80 text-sm mt-2">Complete your registration</p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-500/20 border border-red-500/30 rounded-lg text-left">
                    <ul class="text-xs text-red-400 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Form --}}
        <form action="{{ route('create-user') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold text-emerald-300 mb-1">Full Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
                    required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-emerald-500/50 focus:outline-none"
                >
            </div>

            {{-- Email (readonly) --}}
            <div>
                <label class="block text-xs font-semibold text-emerald-300 mb-1">Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $email ?? '') }}"
                    readonly
                    class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-emerald-300 cursor-not-allowed focus:outline-none"
                >
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-xs font-semibold text-emerald-300 mb-1">Phone Number</label>
                <input
                    type="text"
                    name="phone_number"
                    value="{{ old('phone_number', $phone_number ?? '') }}"
                    placeholder="01700000000"
                    required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-emerald-500/50 focus:outline-none"
                >
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-semibold text-emerald-300 mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-emerald-500/50 focus:outline-none"
                >
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-xs font-semibold text-emerald-300 mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-emerald-500/50 focus:outline-none"
                >
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-bold shadow-lg hover:scale-[1.02] active:scale-95 transition-all"
            >
                Create Account
            </button>
        </form>

        {{-- Footer --}}
        <div class="mt-8 pt-6 border-t border-white/10 text-center">
            <p class="text-gray-400 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:underline ml-1">
                    Sign In
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
