@extends('layouts.base')
@section('title','Reset Password')

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
         x-data="{ showPass: false, showConfirm: false }">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">New Password</h1>
            <p class="text-emerald-300/80 text-sm mt-2">Secure your account with a new password</p>
        </div>

        <form method="POST" action="{{ route('reset-password') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-2 px-1">New Password</label>
                <div class="relative">
                    <input
                        :type="showPass ? 'text' : 'password'"
                        name="password"
                        placeholder="••••••••"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all"
                        required
                    >
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-emerald-400">
                        <svg x-show="!showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-400 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-emerald-300 uppercase tracking-wider mb-2 px-1">Confirm Password</label>
                <div class="relative">
                    <input
                        :type="showConfirm ? 'text' : 'password'"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all"
                        required
                    >
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-emerald-400">
                        <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-900/20 hover:scale-[1.02] active:scale-95 transition-all"
            >
                Reset Password
            </button>

            <div class="text-center pt-6 border-t border-white/10">
                <a href="{{ route('login') }}"
                   class="text-sm text-emerald-400 font-bold hover:underline underline-offset-4 inline-block">
                    ← Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection