<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Ashma Creations</title>
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
<body class="bg-background min-h-screen flex items-center justify-center relative overflow-hidden px-4">
    <!-- Background Gradients / Shapes -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary-light/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-primary-light/10 p-10 relative z-10 transition-all duration-300">
        <!-- Logo and Title -->
        <div class="text-center mb-10">
            <span class="font-logo text-4xl text-primary block mb-2">Ashma Creations</span>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Admin Dashboard</h2>
            <p class="text-sm text-soft-gray mt-1">Please sign in to manage your website content.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 text-sm rounded-2xl border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com"
                       class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                       class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('password') border-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4.5 h-4.5 rounded border-primary-light/30 text-primary focus:ring-primary/20 transition-all mr-2">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-accent hover:shadow-accent/20 transition-all duration-300 cursor-pointer">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
