@props(['user' => null, 'menuItems' => []])

<header class="bg-indigo-600 text-white shadow">
    <div class=" flex justify-between items-center px-6 py-4">
        <h1 class="text-2xl font-bold">Money Manager</h1>

        <div class="flex items-center space-x-4 gap-4">
            <!-- Safe User Greeting -->
            @isset($user)
                <span class="text-sm">
                    <strong>{{ $user->name ?? 'Guest' }}</strong>
                    @if(!empty($user->role)) ({{ $user->role }}) @endif
                </span>
            @else
                <span class="text-sm">Welcome, Guest</span>
            @endisset

            <!-- Safe Menu Items -->
            @if(!empty($menuItems))
                @foreach($menuItems as $item)
                    {{-- <a href="{{ route($item['route']) }}" class="text-white hover:text-gray-200 text-sm font-medium"> --}}
                        {{ $item['name'] }}
                    </a>
                @endforeach
            @else
                <span class="text-sm text-gray-200 italic">No menu available</span>
            @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white text-indigo-600 px-3 py-1.5 rounded-md hover:bg-indigo-100 text-sm font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
