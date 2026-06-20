<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('admin_title', 'Admin Panel') - Ashma Creations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link nonce="{{ $cspNonce ?? '' }}" href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style nonce="{{ $cspNonce ?? '' }}">
        body {
            font-family: 'Poppins', sans-serif;
        }
        .font-logo {
            font-family: 'Pacifico', cursive;
        }
    </style>
    @stack('admin_styles')
</head>
<body class="bg-background min-h-screen flex flex-col md:flex-row">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-20 bg-gray-900/50 hidden transition-opacity duration-300"></div>

    <!-- Sidebar / Side Panel -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-30 w-64 md:relative md:translate-x-0 transform -translate-x-full bg-white border-r border-primary-light/10 flex-shrink-0 flex flex-col transition-all duration-300 ease-in-out">
        <div class="h-20 flex items-center justify-between px-6 border-b border-primary-light/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center truncate">
                <span class="font-logo text-2xl text-primary logo-text transition-all duration-300">Ashma Creations</span>
                <span class="font-logo text-2xl text-primary logo-icon hidden transition-all duration-300">AD</span>
            </a>
            <!-- Mobile Close Button -->
            <button id="mobile-close" class="md:hidden p-2 text-gray-600 hover:text-primary focus:outline-none cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-2xl text-sm font-semibold transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-background hover:text-primary' }} justify-start sidebar-link">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="nav-text ml-3 transition-opacity duration-300">Dashboard</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl text-sm font-semibold transition-all group {{ request()->routeIs('admin.categories.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-background hover:text-primary' }} justify-start sidebar-link">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span class="nav-text ml-3 transition-opacity duration-300">Categories</span>
            </a>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center px-4 py-3 rounded-2xl text-sm font-semibold transition-all group {{ request()->routeIs('admin.products.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-background hover:text-primary' }} justify-start sidebar-link">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('admin.products.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="nav-text ml-3 transition-opacity duration-300">Products</span>
            </a>

            <a href="{{ url('/') }}" target="_blank"
               class="flex items-center px-4 py-3 rounded-2xl text-sm font-semibold text-gray-600 hover:bg-background hover:text-primary transition-all group justify-start sidebar-link">
                <svg class="w-5 h-5 flex-shrink-0 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span class="nav-text ml-3 transition-opacity duration-300">View Live Store</span>
            </a>
        </nav>

        <!-- User profile / Logout -->
        <div class="p-6 border-t border-primary-light/10 mt-auto">
            <div class="profile-details mb-4 transition-all duration-300">
                <p class="text-xs font-semibold text-soft-gray uppercase tracking-wider">Logged In As</p>
                <p class="text-sm font-bold text-gray-800 truncate" title="{{ Auth::user()->email }}">{{ Auth::user()->name }}</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 font-bold rounded-2xl border border-red-200/50 hover:border-red-200 transition-all text-sm flex items-center justify-center cursor-pointer sign-out-btn">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="sign-out-text ml-2">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top bar (Header) -->
        <header class="h-20 bg-white border-b border-primary-light/10 flex items-center justify-between px-6 md:px-8 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Toggle Button -->
                <button id="mobile-toggle" class="p-2 text-gray-600 hover:text-primary focus:outline-none md:hidden cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Desktop Sidebar Collapse Toggle Button -->
                <button id="desktop-toggle" class="hidden md:block p-2 text-gray-600 hover:text-primary focus:outline-none cursor-pointer">
                    <!-- Collapse left/right icon -->
                    <svg id="toggle-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <h2 class="text-xl font-bold text-gray-800">@yield('admin_page_header', 'Dashboard')</h2>
            </div>
            <div class="text-sm font-semibold text-soft-gray hidden sm:block">
                {{ date('l, F j, Y') }}
            </div>
        </header>

        <!-- Page body -->
        <div class="p-6 md:p-8 flex-grow">
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-50 text-green-700 text-sm rounded-2xl border border-green-100 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-8 p-4 bg-red-50 text-red-700 text-sm rounded-2xl border border-red-100 shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('admin_content')
        </div>
    </div>

    @stack('admin_scripts')
    
    <!-- Sidebar Collapse and Mobile Drawer Script -->
    <script nonce="{{ $cspNonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileClose = document.getElementById('mobile-close');
            const desktopToggle = document.getElementById('desktop-toggle');
            const toggleIcon = document.getElementById('toggle-icon');
            
            // Elements inside sidebar to hide/change
            const navTexts = document.querySelectorAll('.nav-text');
            const logoText = document.querySelector('.logo-text');
            const logoBadge = document.querySelector('.logo-badge');
            const logoIcon = document.querySelector('.logo-icon');
            const profileDetails = document.querySelector('.profile-details');
            const signOutText = document.querySelector('.sign-out-text');
            const signOutBtn = document.querySelector('.sign-out-btn');
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            
            function setSidebarState(isCollapsed) {
                if (isCollapsed) {
                    sidebar.classList.remove('md:w-64');
                    sidebar.classList.add('md:w-22');
                    
                    navTexts.forEach(el => el.classList.add('md:hidden'));
                    if (logoText) logoText.classList.add('md:hidden');
                    if (logoBadge) logoBadge.classList.add('md:hidden');
                    if (profileDetails) profileDetails.classList.add('md:hidden');
                    if (signOutText) signOutText.classList.add('md:hidden');
                    
                    if (logoIcon) logoIcon.classList.remove('hidden');
                    
                    sidebarLinks.forEach(el => {
                        el.classList.remove('justify-start', 'px-4');
                        el.classList.add('justify-center', 'px-0');
                    });
                    
                    if (signOutBtn) {
                        signOutBtn.classList.remove('w-full');
                        signOutBtn.classList.add('w-10', 'h-10', 'p-0', 'mx-auto', 'justify-center');
                    }
                    
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(180deg)';
                    }
                } else {
                    sidebar.classList.remove('md:w-22');
                    sidebar.classList.add('md:w-64');
                    
                    navTexts.forEach(el => el.classList.remove('md:hidden'));
                    if (logoText) logoText.classList.remove('md:hidden');
                    if (logoBadge) logoBadge.classList.remove('md:hidden');
                    if (profileDetails) profileDetails.classList.remove('md:hidden');
                    if (signOutText) signOutText.classList.remove('md:hidden');
                    
                    if (logoIcon) logoIcon.classList.add('hidden');
                    
                    sidebarLinks.forEach(el => {
                        el.classList.remove('justify-center', 'px-0');
                        el.classList.add('justify-start', 'px-4');
                    });
                    
                    if (signOutBtn) {
                        signOutBtn.classList.remove('w-10', 'h-10', 'p-0', 'mx-auto', 'justify-center');
                        signOutBtn.classList.add('w-full');
                    }
                    
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                }
            }
            
            // Load state from localStorage
            let isCollapsed = localStorage.getItem('admin_sidebar_collapsed') === 'true';
            
            // Only apply on desktop viewports
            if (window.innerWidth >= 768) {
                setSidebarState(isCollapsed);
            }
            
            // Desktop toggle click
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function () {
                    isCollapsed = !isCollapsed;
                    localStorage.setItem('admin_sidebar_collapsed', isCollapsed);
                    setSidebarState(isCollapsed);
                });
            }
            
            // Mobile Menu Open
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function () {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            }
            
            // Mobile Menu Close helper
            function closeMobileMenu() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
            if (backdrop) backdrop.addEventListener('click', closeMobileMenu);
            
            // Handle window resizing
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    closeMobileMenu();
                    isCollapsed = localStorage.getItem('admin_sidebar_collapsed') === 'true';
                    setSidebarState(isCollapsed);
                } else {
                    closeMobileMenu();
                    setSidebarState(false); // Reset internal elements to expanded state for mobile
                }
            });
        });
    </script>
</body>
</html>
