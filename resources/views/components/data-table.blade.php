

<div class="bg-white rounded-xl shadow  overflow-hidden">
    @if(!empty($title))
        <div class=" px-2 lg:px-4 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">{{ $title }}</h2>

            @if(!empty($searchField))
            <form method="GET" class="flex items-center gap-3">
                <input
                    type="text"
                    name="{{ $searchField }}"
                    value="{{ request($searchField) }}"
                    placeholder="{{ $searchPlaceholder ?? 'Search...' }}"
                    class="w-64 px-3 py-2 text-sm border border-slate-300 rounded-lg
                           focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                />

                <button
                    type="submit"
                    class="px-4 py-2 text-sm text-white
                           bg-gradient-to-r from-emerald-400 to-teal-400
                           rounded-lg
                           hover:from-emerald-500 hover:to-teal-500">
                    Search
                </button>

                @if(request($searchField))
                    <a href="{{ url()->current() }}"
                       class="px-3 py-2 text-sm bg-slate-200 rounded-lg hover:bg-slate-300">
                        Reset
                    </a>
                @endif
            </form>
            @endif
        </div>
    @endif

    <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                @foreach($columns as $col)
                    <th class="px-2 lg:px-4 py-3 text-left font-medium">{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            @forelse($rows as $index => $row)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-2 lg:px-4 py-4 text-slate-600">{{ $index + 1 }}</td>
                    @foreach($row as $cell)
                        <td class="px-6 py-4">{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns)+1 }}" class="px-6 py-10 text-center text-slate-500">
                        No records found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
