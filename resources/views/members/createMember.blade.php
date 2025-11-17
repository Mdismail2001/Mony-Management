@extends('layouts.base')

@section('title', 'Add Member')

@section('content')
<!-- Updated to dark theme with slate-950 background -->
<div class="min-h-screen bg-slate-950 p-6">
    <div class="max-w-xl mx-auto">
        <!-- Glass-morphism card with dark styling -->
        <div class="bg-slate-900/80 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-slate-800/50">
            <!-- Updated heading with emerald gradient -->
            <h2 class="text-3xl font-bold mb-6 bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">Add New Member</h2>

            @if($errors->any())
                <!-- Dark-styled error messages with icon -->
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg backdrop-blur-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('store-member') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Mobile -->
                <!-- Dark-styled form inputs with emerald focus ring -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Mobile Number</label>
                    <input type="text" name="mobile" required
                        class="w-full bg-slate-800/50 border border-slate-700/50 text-slate-200 px-4 py-3 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder-slate-500"
                        placeholder="Enter mobile number">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Role</label>
                    <select name="role" required
                        class="w-full bg-slate-800/50 border border-slate-700/50 text-slate-200 px-4 py-3 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
                        <option value="">Select Role</option>
                        <option value="leader">Leader</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                
                <input type="hidden" name="community_id" value="{{ $community->id }}">

                <!-- Emerald gradient button with hover effects -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-medium py-3 px-4 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30">
                    Add Member
                </button>
            </form>

            <!-- Dark-styled back link with icon -->
            <div class="mt-6 text-center">
                <a href="{{ route('communities', $community->id) }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Community
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
