@extends('layouts.base')

@section('title', 'Edit Community')

@section('content')
<div class="min-h-screen bg-slate-950 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('communities', $community->id) }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Community Details</span>
            </a>
        </div>

        {{-- Card with form --}}
        <div class="bg-slate-900/80 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-slate-800/50">
            {{-- Heading --}}
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                    Edit Community
                </h2>
                <div class="text-sm text-slate-400">
                    ID: <span class="font-mono text-slate-300">{{ $community->id }}</span>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-lg mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
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

            <form action="{{ route('edit', $community->id )}}" method="POST" class="space-y-6">
                @csrf

                {{-- Read-only Fields Section --}}
                <div class="bg-slate-800/30 border border-slate-700/50 rounded-xl p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wide mb-4">System Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Created At --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-2">Created At</label>
                            <div class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-400 px-4 py-3 rounded-lg font-mono text-sm">
                                {{ $community->created_at ? $community->created_at->format('M d, Y H:i:s') : 'N/A' }}
                            </div>
                        </div>

                        {{-- Updated At --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-2">Last Updated</label>
                            <div class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-400 px-4 py-3 rounded-lg font-mono text-sm">
                                {{ $community->updated_at ? $community->updated_at->format('M d, Y H:i:s') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Editable Fields Section --}}
                <div class="space-y-6">
                    {{-- Community Name --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Community Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $community->name) }}" 
                               required
                               class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500"
                               placeholder="Enter community name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Minimum Amount --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">
                            Minimum Amount <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                            <input type="number" 
                                   name="min_amount" 
                                   value="{{ old('min_amount', $community->min_amount) }}" 
                                   step="0.01"
                                   required
                                   class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 pl-8 pr-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500"
                                   placeholder="0.00">
                        </div>
                        @error('min_amount')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Total Amount (Read-only, calculated field) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">
                            Total Amount 
                            <span class="text-xs text-slate-500">(Auto-calculated)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                            <div class="w-full bg-slate-900/50 border border-slate-700/50 text-emerald-400 pl-8 pr-4 py-3 rounded-lg font-semibold">
                                {{ number_format($community->total_amount ?? 0, 2) }}
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">This value is automatically calculated based on member contributions</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-6 border-t border-slate-800">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold py-3 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30">
                        Update Community
                    </button>
                    <a href="{{ route('communities', $community->id) }}"
                       class="px-6 py-3 bg-slate-800/50 text-slate-300 font-medium rounded-lg hover:bg-slate-800 transition-all border border-slate-700">
                        Cancel
                    </a>
                </div>
            </form>

            {{-- Additional Info --}}
            <div class="mt-6 pt-6 border-t border-slate-800">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-400">Need help?</span>
                    <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors">View Documentation</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
