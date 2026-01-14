<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Money Manager | Welcome</title>
</head>
<body class="margin-0 padding-0">

    <div class="relative h-screen w-full flex items-center justify-center bg-gray-900">
        
        <div class="absolute inset-0 z-0">
            <img src="https://static.vecteezy.com/system/resources/thumbnails/014/403/884/small/us-dollar-bills-and-candlestick-chart-showing-changes-in-price-of-money-photo.jpg" 
                 class="w-full h-full object-cover opacity-40" 
                 alt="Background">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/60 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-lg p-8 mx-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl text-center">
            
            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                Smart <span class="text-emerald-400">Wealth</span> Manager
            </h1>
            <p class="text-gray-200 text-lg mb-8">
                Track your community transactions, manage member deposits, and grow your savings in one place.
            </p>

            <div class="flex flex-col gap-4">
                <a href="/login" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-xl transition duration-300 transform hover:scale-105 shadow-xl">
                    Get Started Now
                </a>
                <a href="/about" class="text-white/80 hover:text-white text-sm font-medium underline underline-offset-4">
                    Learn how it works
                </a>
            </div>

            <div class="mt-10 grid grid-cols-3 gap-4 border-t border-white/10 pt-6">
                <div>
                    <p class="text-emerald-400 font-bold text-xl">10k+</p>
                    <p class="text-gray-400 text-xs uppercase">Users</p>
                </div>
                <div>
                    <p class="text-emerald-400 font-bold text-xl">$2M+</p>
                    <p class="text-gray-400 text-xs uppercase">Tracked</p>
                </div>
                <div>
                    <p class="text-emerald-400 font-bold text-xl">99%</p>
                    <p class="text-gray-400 text-xs uppercase">Secure</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>