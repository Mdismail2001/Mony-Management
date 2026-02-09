@extends('layouts.base')
@section('title','Verify OTP')

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
    <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl shadow-2xl p-8 mx-4">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20 ">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Verify Code</h1>

            @if (session('message'))
                <div class="mt-4 p-2 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
                    <p class="text-xs text-emerald-400 font-medium">{{ session('message') }}</p>
                </div>
            @endif

            <p class="text-emerald-300/80 text-sm mt-2">Enter the 6-digit security code</p>
        </div>

        <form  action="{{ route('verify-otp') }}" method="POST" class="space-y-6">
            @csrf

            <div class="text-center">
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-4 px-1">
                    OTP Code
                </label>
                
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    placeholder="••••••"
                    class="w-full text-center tracking-[1em] text-3xl font-bold
                           bg-white/5 border border-white/10 rounded-2xl px-4 py-4
                           text-white placeholder-gray-500
                           focus:outline-none focus:ring-2 focus:ring-emerald-500/50
                           focus:bg-white/10 transition-all"
                    required
                >

                @error('otp')
                    <p class="text-red-400 text-xs mt-2 font-medium">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-900/20 hover:scale-[1.02] active:scale-95 transition-all">
                Verify Now
            </button>

            <div class="text-center pt-6 border-t border-white/10 flex flex-col gap-3">
                <a href="{{ route('password-request') }}"
                   class="text-sm text-emerald-400 font-bold hover:underline underline-offset-4">
                   ← Change recovery method
                </a>
                
                <button type="button" class="text-xs text-gray-400 hover:text-white transition-colors">
                    Didn't receive code? <span class="text-emerald-400 font-semibold">Resend</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection