@if ($paginator)
    @if ($paginator->hasPages())
        {{-- real pagination --}}
    @endif
@else
    {{-- mock pagination for UI preview --}}
    <div class="flex items-center justify-between mt-6">
        <p class="text-sm text-gray-600">
            Showing
            <span class="font-medium">1</span>
            to
            <span class="font-medium">10</span>
            of
            <span class="font-medium">100</span>
            results
        </p>

        <div class="flex items-center gap-2">
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg">Prev</span>
            <a href="#"
               class="px-3 py-1 text-sm bg-white  rounded-lg hover:bg-gray-50">1</a>
            <a href="#"
               class="px-3 py-1 text-sm bg-white  rounded-lg hover:bg-gray-50">2</a>
            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg">Next</span>
        </div>
    </div>
@endif
