@props(['user' => null, 'menuItems' => []])
<header class="fixed top-0 left-0 right-0 z-50 h-16 bg-white border-b border-slate-200 shadow-lg">
    <div class="flex justify-between items-center px-4 sm:px-6 lg:px-8 h-full">
        <!-- Logo & Brand -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-lg sm:text-2xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent">
                MMS
            </h1>
        </div>

        <!-- User Section -->
        <div class="flex items-center space-x-2 sm:space-x-6">
            @isset($user)
            <!-- User Info (Desktop) -->
            <div class="hidden sm:flex items-center space-x-3 px-3 py-1 rounded-lg bg-white border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100 transition">
                <a href="{{ route('profile')}}" class="flex items-center space-x-3">
                    <!-- User Icon / Initials -->
                    @if($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                            alt="{{ $user->name }}" 
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full object-cover shadow-lg">
                    @else
                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-sm sm:text-base font-semibold shadow-lg">
                            {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                        </div>
                    @endif

                    <span class="text-sm sm:text-base font-semibold text-slate-800">{{ $user->name ?? 'Guest' }}</span>
                </a>
            </div>

            <!-- Mobile initials -->
            <div class="sm:hidden flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-semibold shadow-lg cursor-pointer hover:opacity-80 transition">
                <a href="{{ route('profile')}}">
                    {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                </a>
            </div>
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-1 sm:space-x-2 px-3 sm:px-4 py-1 sm:py-2 rounded-lg bg-white hover:bg-red-50 text-slate-800 hover:text-red-600 border border-slate-200 hover:border-red-300 text-sm sm:text-base font-medium transition-all duration-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            @else
                <span class="px-3 py-1 text-sm rounded-lg bg-white border border-slate-200 shadow-sm text-slate-800">Guest</span>
            @endisset
        </div>
    </div>
</header>
