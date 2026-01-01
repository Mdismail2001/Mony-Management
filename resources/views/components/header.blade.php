
@props(['user' => null])

<header
    x-data="{ open: false }"
    class="fixed top-0 left-0 right-0 z-50 h-16 bg-white border-b border-slate-200 shadow"
>
    <div class="flex items-center justify-between h-full px-2 sm:px-4 lg:pr-6 ">

        <!-- LEFT: Logo & Brand -->
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shadow"
            >
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                             3 .895 3 2-1.343 2-3 2m0-8c1.11 0
                             2.08.402 2.599 1M12 8V7m0 1v8m0
                             0v1m0-1c-1.11 0-2.08-.402-2.599-1
                             M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <span
                class="text-xl font-bold bg-gradient-to-r from-emerald-500 to-teal-500 bg-clip-text text-transparent">
                MMS
            </span>
        </div>

        <!-- RIGHT: User + Mobile Menu -->
        <div class="flex items-center gap-3">

            @if($user)
                <!-- Desktop User Info -->
                <a href="{{ route('profile') }}"
                   class="hidden sm:flex items-center gap-3 px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500
                     rounded-lg hover:bg-slate-100  transition">
                    @if($user->photo)
                        <img src="{{ asset('storage/'.$user->photo) }}"
                             class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="font-medium text-slate-800 text-white">
                        {{ $user->name }}
                    </span>
                </a>

                <!-- Mobile Avatar -->
                <a href="{{ route('profile') }}" class="sm:hidden">
                    @if($user->photo)
                        <img src="{{ asset('storage/'.$user->photo) }}"
                             class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </a>

                <!-- Mobile Menu Button -->
                <button
                    @click="open = !open"
                    class="sm:hidden p-2 rounded-lg
                        bg-gradient-to-r from-emerald-500 to-teal-500
                        text-white shadow-md hover:opacity-90 transition"
                    >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- MOBILE DROPDOWN MENU -->
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="sm:hidden absolute right-4 top-16 w-56 bg-white rounded-xl shadow-lg  overflow-hidden "
        >
        <a href="{{ route('Dashboard') }}"
           class="block px-4 py-3 hover:bg-slate-100">
            📊 Dashboard Overview
        </a>

        <a href="{{ route('all-members') }}"
           class="block px-4 py-3 hover:bg-slate-100">
            👥 All Members
        </a>

        <a href="{{ route('all-transactions') }}"
           class="block px-4 py-3 hover:bg-slate-100">
            💳 All Transactions
        </a>

        <div class=""></div>

        <a href="{{ route('profile') }}"
           class="block px-4 py-3 hover:bg-slate-100">
            👤 Profile
        </a>
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 flex items-center gap-2"
            >
                🚪 Logout
            </button>
        </form>
    </div>
</header>
