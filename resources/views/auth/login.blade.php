@extends('layouts.base')

@section('content')
<div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
    <!-- Logo or Title -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-emerald-700">Login</h1>
        <p class="text-gray-500 text-sm mt-1">Manage your finances smartly</p>
    </div>

    <!-- Login Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="you@example.com"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center">
                <input type="checkbox" class="text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" />
                <span class="ml-2 text-gray-600">Remember me</span>
            </label>
            <a href="#" class="text-emerald-600 hover:underline">Forgot password?</a>
        </div>

        <button
            type="submit"
            class="w-full bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium"
        >
            Sign In
        </button>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-grow h-px bg-gray-200"></div>
        <span class="px-3 text-gray-400 text-sm">OR</span>
        <div class="flex-grow h-px bg-gray-200"></div>
    </div>

    <!-- Social Login -->
    <div class="flex gap-3">
        <button class="flex-1 border border-gray-300 rounded-lg py-2 text-sm hover:bg-gray-50">Google</button>
        <button class="flex-1 border border-gray-300 rounded-lg py-2 text-sm hover:bg-gray-50">Facebook</button>
    </div>

    <!-- Signup Link -->
    <p class="text-center text-sm text-gray-600 mt-6">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-emerald-600 font-medium hover:underline">Sign up</a>
    </p>
</div>
@endsection
