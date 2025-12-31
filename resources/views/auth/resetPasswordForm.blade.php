@extends('layouts.base')
@section('title','Reset Password')

@section('content')
<div class="flex justify-center mt-20">
    <form method="POST" action="{{ route('reset-password') }}"
          class="bg-white p-6 rounded-xl shadow w-full max-w-sm">
        @csrf
        <h2 class="text-xl font-bold mb-4">Reset Password</h2>

        <input type="password" name="password"
               class="w-full border rounded-lg p-2 mb-3"
               placeholder="New Password">

        <input type="password" name="password_confirmation"
               class="w-full border rounded-lg p-2 mb-4"
               placeholder="Confirm Password">

        <button class="w-full bg-emerald-600 text-white py-2 rounded-lg">
            Reset Password
        </button>
    </form>
</div>
@endsection
