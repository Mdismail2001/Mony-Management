@props(['user' => null, 'menuItems' => []])
<header class="bg-slate-900/80 backdrop-blur-lg border-b border-slate-700/50 text-white shadow-lg sticky top-0 z-50">
    <div class="flex justify-between items-center px-6 py-4">
        <!-- Logo & Brand -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                MMS
            </h1>
        </div>

        <div class="flex items-center space-x-6">
            <!-- Removed navigation menu to fix route errors -->
            
            <!-- User Profile Section -->
            @isset($user)
                <div class="flex items-center space-x-4">
                    <!-- User Info -->
                    <div class="hidden sm:flex items-center space-x-3 px-4 py-2 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-sm font-semibold shadow-lg">
                            {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-white">{{ $user->name ?? 'Guest' }}</span>
                            {{-- @if(!empty($user->role))
                                <span class="text-xs text-emerald-400">{{ $user->role }}</span>
                            @endif --}}
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-slate-800/50 hover:bg-red-500/20 text-slate-300 hover:text-red-400 border border-slate-700/50 hover:border-red-500/50 text-sm font-medium transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @else
                <span class="text-sm text-slate-400 px-4 py-2 rounded-lg bg-slate-800/30">Welcome, Guest</span>
            @endisset
        </div>
    </div>
</header>
