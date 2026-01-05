<div class="px-2 lg:px-4 py-4 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">

    {{-- Title --}}
    <h2 class="text-lg font-semibold text-slate-800">{{ $title }}</h2>

    {{-- Search & Filters --}}
    <form method="GET" class="flex flex-wrap items-center gap-3">

        {{-- Search Input --}}
        @if($searchField)
        <input
            type="text"
            name="{{ $searchField }}"
            value="{{ request($searchField) }}"
            placeholder="{{ $searchPlaceholder ?? 'Search...' }}"
            class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
        />
        @endif

        {{-- Dynamic Filters --}}
        @foreach($filters as $name => $options)
        <select name="{{ $name }}"
                class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            <option value="">All {{ ucfirst($name) }}</option>
            @foreach($options as $option)
                <option value="{{ $option }}" {{ request($name)==$option ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
        @endforeach

        {{-- Submit Button --}}
        <button type="submit"
                class="px-4 py-2 text-sm text-white bg-gradient-to-r from-emerald-400 to-teal-400 rounded-lg hover:from-emerald-500 hover:to-teal-500">
            Filter
        </button>

        {{-- Extra Actions (Download, Export) --}}
        @foreach($actions as $action)
        <a href="{{ $action['route'] ?? '#' }}"
        title="{{ $action['label'] ?? 'Download' }}"
        class="p-2 text-white bg-gradient-to-r from-emerald-400 to-teal-400 rounded-lg hover:from-emerald-500 hover:to-teal-500 flex items-center justify-center">
        
            {{-- Download Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
            </svg>
        </a>
        @endforeach

        {{-- Reset Button --}}
        @if(request()->all())
        <a href="{{ url()->current() }}"
           class="px-3 py-2 text-sm bg-slate-200 rounded-lg hover:bg-slate-300">
            Reset
        </a>
        @endif
    </form>
</div>
