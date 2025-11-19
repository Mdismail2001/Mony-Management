@extends('layouts.base')

@section('title', 'Create Community')

@section('content')
<div class="min-h-screen bg-slate-950 py-8 px-4">
    <div class="max-w-xl mx-auto">
        <!-- Updated card to match dark glass-morphism theme -->
        <div class="bg-slate-900/80 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-slate-800/50">
            <!-- Updated heading with gradient text -->
            <h2 class="text-3xl font-bold mb-8 text-center bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                Create New Community
            </h2>

            {{-- Success Message --}}
            @if(session('success'))
                <!-- Updated success message styling for dark theme -->
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-lg mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <!-- Updated error message styling for dark theme -->
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-lg mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('community-store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Community Name --}}
                <div>
                    <!-- Updated label styling for dark theme -->
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Community Name <span class="text-red-400">*</span>
                    </label>
                    <!-- Updated input styling with dark theme and focus states -->
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required
                           class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="Enter community name">
                </div>

                {{-- Minimum Amount --}}
                <div>
                    <!-- Updated label styling for dark theme -->
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Amount <span class="text-red-400">*</span>
                    </label>
                    <!-- Updated input styling with dark theme and focus states -->
                    <input type="number" 
                           name="min_amount" 
                           value="{{ old('min_amount') }}" 
                           required
                           class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="Enter amount">
                </div>

                <!-- Updated button with emerald gradient matching the theme -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold py-3 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30">
                    Create Community
                </button>
            </form>

            <!-- Updated back link with icon instead of emoji -->
            <div class="mt-6 text-center">
                <a href="{{ route('Dashboard') }}" 
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
