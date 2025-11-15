@extends('layouts.base')

@section('title', 'Dashboard')

@section('content')

<div class="w-full">
{{-- Header --}}
<x-header class="w-full" :user="$user" :menuItems="$menuItems" />

{{-- Main Content --}}
<div>
    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-3xl font-semibold mb-4">Welcome to Your Dashboard, {{ $user->name ?? 'User' }}!</h2>
        <p class="text-gray-700">Here you can manage your finances, track expenses, and view reports.</p>
    </div>
</div>  

{{-- Footer --}}
<x-footer 
    :app-name="'Money Manager'" 
    :links="[
        ['label' => 'About', ],
        ['label' => 'Privacy', ],
        ['label' => 'Contact', ],
    ]"
/>

</div>
@endsection
