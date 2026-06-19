<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Ashma Creations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .font-logo {
            font-family: 'Pacifico', cursive;
        }
    </style>
</head>
<body class="bg-background min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white border-b border-primary-light/10 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                        <span class="font-logo text-3xl text-primary">Ashma Creations</span>
                        <span class="ml-3 px-3 py-1 bg-primary/10 text-primary text-xs font-bold font-body rounded-full uppercase tracking-wider">Admin</span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-700">Hello, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-background hover:bg-red-50 text-red-600 hover:text-red-700 font-bold font-body rounded-full border border-red-200/50 hover:border-red-200 transition-all text-sm cursor-pointer">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Welcome banner -->
        <div class="bg-gradient-to-r from-primary to-accent rounded-[2.5rem] p-8 md:p-12 text-white shadow-xl shadow-primary/10 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -translate-x-1/3 translate-y-1/3"></div>
            
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 font-body">Welcome back, Admin!</h1>
                <p class="text-white/80 text-lg leading-relaxed">
                    This is your main dashboard. From here, you will soon be able to manage your handcrafted collections, bouquets, and flower pots.
                </p>
            </div>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Categories Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="text-xs font-semibold text-soft-gray uppercase tracking-wider">Collections</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Categories</h3>
                <p class="text-4xl font-black text-primary font-body">{{ $categoriesCount }}</p>
            </div>

            <!-- Products Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 bg-accent/10 text-accent rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-xs font-semibold text-soft-gray uppercase tracking-wider">Items</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Products</h3>
                <p class="text-4xl font-black text-accent font-body">{{ $productsCount }}</p>
            </div>
        </div>

        <!-- Informational Card -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Under Construction</h3>
            <p class="text-soft-gray leading-relaxed mb-4">
                The content management features (CRUD interfaces) for categories and products will be added next. You can click on the client site logo in the top navbar to return to the public storefront at any time.
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-primary-light/10 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-soft-gray">
            &copy; {{ date('Y') }} Ashma Creations. All rights reserved.
        </div>
    </footer>
</body>
</html>
