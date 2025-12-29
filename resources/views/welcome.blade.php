<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Money Management System</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center text-center px-6">

  <!-- Logo -->
  <div class="mb-8">
    <img src="{{ asset('images/logo.png') }}" alt="Money Management Logo" class="w-32 h-32 mx-auto">
  </div>

  <!-- Banner / Hero -->
  <div class="mb-8">
    <img src="{{ asset('images/banner.png') }}" alt="Money Management Banner" class="w-full max-w-3xl rounded-xl shadow-lg">
  </div>

  <!-- Welcome Text -->
  <h1 class="text-4xl md:text-5xl font-bold text-emerald-600 mb-4">
    Money Management System
  </h1>
  <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto">
    A simple and professional system to manage your finances efficiently. Track your deposits, monitor your transactions, and manage your money with ease.
  </p>

  <!-- Footer -->
  <footer class="mt-12 text-gray-500 text-sm">
    &copy; {{ date('Y') }} Money Management System. All rights reserved.
  </footer>

</body>
</html>
