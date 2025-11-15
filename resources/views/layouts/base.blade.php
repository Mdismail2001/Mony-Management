<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Money Manager')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Header --}}
    @if (!empty($showHeader) && $showHeader)
        <header class="col-span-1 lg:col-span-12">
            <x-header :user="$user" :menuItems="$menuItems" />
        </header>
    @endif

    {{-- Layout Wrapper (Sidebar + Page Content) --}}
    <div class="flex">
        @if (!empty($showSidebar) && $showSidebar)
            <aside id="sidebar" class="hidden lg:block w-64 bg-indigo-700 text-white p-5 min-h-screen">
                <h2 class="text-2xl font-bold mb-6">Money Manager</h2>
                <nav class="flex flex-col space-y-2">
                    <a href="#" class="bg-indigo-600 px-3 py-2 rounded-md">Dashboard</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Users</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Transactions</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Categories</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Reports</a>
                    <a href="#" class="hover:bg-indigo-600 px-3 py-2 rounded-md">Settings</a>
                </nav>
                <div class="mt-auto pt-6 border-t border-indigo-500">
                    <button class="w-full bg-red-600 px-3 py-2 rounded-md hover:bg-red-700 text-sm font-medium">Logout</button>
                </div>
            </aside>
        @endif

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
