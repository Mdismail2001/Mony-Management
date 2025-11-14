@props([
    'appName' => 'Money Manager',
    'year' => date('Y'),
    'links' => [],
])

<footer class="bg-gray-100 text-center text-sm text-gray-600 py-4 border-t mt-auto">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-6 space-y-2 md:space-y-0">
        <p>© {{ $year }} {{ $appName }}. All rights reserved.</p>

        <div class="flex space-x-4">
            @foreach ($links as $link)
                <a 
                    href="{{ $link['url'] ?? '#' }}" 
                    class="hover:text-indigo-600 transition"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</footer>
