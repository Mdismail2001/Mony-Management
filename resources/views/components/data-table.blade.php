

<div class="bg-white rounded-xl shadow  overflow-hidden">
    @if(!empty($title))   
    <x-filter-bar
        title="{{ $title }}"
        search-field="search"
        search-placeholder="Name or Community..."
        :filters="[
            'year' => range(date('Y'), date('Y') - 3),
            'month' => [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ]
        ]"
        :actions="[
            [
                'label' => 'Download',
                'route' => route($downloadRoute, array_merge(request()->query(), [
                'excelfile' => true
                ]))

            ]
        ]"
    />
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
