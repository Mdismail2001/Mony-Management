@extends('layouts.base')

@section('title', 'Forgot Password')

@section('content')
{{-- Main Background Container --}}
<div class="relative min-h-screen w-full flex items-center justify-center bg-gray-900 overflow-hidden">
    
    {{-- Background Image Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/014/403/884/small/us-dollar-bills-and-candlestick-chart-showing-changes-in-price-of-money-photo.jpg" 
             class="w-full h-full object-cover opacity-30" 
             alt="Background">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 to-gray-900/40"></div>
    </div>

    {{-- Glassmorphism Card --}}
    <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl shadow-2xl p-8 mx-4"
         x-data="{ type: 'email' }">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20 ">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Recover Password</h1>
            
            @if ($errors->has('message'))
                <div class="mt-4 p-2 bg-red-500/20 border border-red-500/30 rounded-lg">
                    <p class="text-xs text-red-400 font-medium">{{ $errors->first('message') }}</p>
                </div>
            @endif

            <p class="text-emerald-300/80 text-sm mt-2">Choose your recovery method</p>
        </div>

        <div class="flex bg-white/5 border border-white/10 rounded-xl p-1 mb-8">
            <button
                type="button"
                @click="type = 'email'"
                :class="type === 'email'
                    ? 'bg-emerald-500 text-white shadow-lg'
                    : 'text-gray-400 hover:text-white'"
                class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300">
                Email
            </button>

            <button
                type="button"
                @click="type = 'phone_number'"
                :class="type === 'phone_number'
                    ? 'bg-emerald-500 text-white shadow-lg'
                    : 'text-gray-400 hover:text-white'"
                class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300">
                Mobile
            </button>
        </div>

        <form method="POST" action="{{ route('password-otpSend') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="type" :value="type">

            <div x-show="type === 'email'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0">
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-2 px-1">
                    Email Address
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="example@email.com"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all">
            </div>

            <div x-show="type === 'phone_number'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0">
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-2 px-1">
                    Mobile Number
                </label>
                <input
                    type="text"
                    name="phone_number"
                    placeholder="01XXXXXXXX"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all">
            </div>

            <button
                type="submit"
                class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-900/20 hover:scale-[1.02] active:scale-95 transition-all">
                Send OTP
            </button>

            <div class="text-center pt-4 border-t border-white/10">
                <a href="{{ route('login') }}"
                   class="text-sm text-emerald-400 font-bold hover:underline underline-offset-4">
                   ← Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection