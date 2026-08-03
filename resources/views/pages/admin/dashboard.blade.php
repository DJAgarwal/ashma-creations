@extends('layouts.admin')

@section('admin_title', 'Dashboard')
@section('admin_page_header', 'Dashboard')

@section('admin_content')
    <!-- Welcome banner -->
    <div class="bg-gradient-to-r from-primary to-accent rounded-[2.5rem] p-8 md:p-12 text-white shadow-xl shadow-primary/10 mb-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -translate-x-1/3 translate-y-1/3"></div>
        
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 font-body text-white/80">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-white/80 text-lg leading-relaxed">
                This is your main dashboard. From here, you will soon be able to manage your handcrafted collections, bouquets, and flower pots.
            </p>
        </div>
    </div>

    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
        <!-- Products Card -->
        <a href="{{ route('admin.products.index') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Products</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $productsCount }}</p>
        </a>

        <!-- Categories Card -->
        <a href="{{ route('admin.categories.index') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Categories</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $categoriesCount }}</p>
        </a>

        <!-- Collections Card -->
        <a href="{{ route('admin.collections.index') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Collections</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $collectionsCount }}</p>
        </a>

        <!-- Occasions Card -->
        <a href="{{ route('admin.taxonomies.index', 'occasions') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Occasions</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $occasionsCount }}</p>
        </a>

        <!-- Recipients Card -->
        <a href="{{ route('admin.taxonomies.index', 'recipients') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Recipients</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $recipientsCount }}</p>
        </a>

        <!-- Styles Card -->
        <a href="{{ route('admin.taxonomies.index', 'styles') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Styles</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $stylesCount }}</p>
        </a>

        <!-- Materials Card -->
        <a href="{{ route('admin.taxonomies.index', 'materials') }}" class="group bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Materials</h3>
            <p class="text-3xl font-black text-primary font-body">{{ $materialsCount }}</p>
        </a>
    </div>
@endsection
