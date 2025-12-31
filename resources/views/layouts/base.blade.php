<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Money Manager')</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    {{-- Layout Wrapper (Sidebar + Page Content) --}}
    <div class="flex">
        {{-- PAGE CONTENT --}}
        <main class="flex-1 ">
            @yield('content')
        </main>
    </div>

</body>
</html>
