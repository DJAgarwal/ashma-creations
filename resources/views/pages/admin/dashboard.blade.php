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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Categories Card -->
        <a href="{{ route('admin.categories.index') }}" class="group bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-primary-light/10 text-primary rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-xs font-semibold text-soft-gray uppercase tracking-wider">Collections</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-primary transition-colors">Categories</h3>
            <p class="text-4xl font-black text-primary font-body">{{ $categoriesCount }}</p>
        </a>

        <!-- Products Card -->
        <a href="{{ route('admin.products.index') }}" class="group bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-accent/10 text-accent rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-xs font-semibold text-soft-gray uppercase tracking-wider">Items</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-accent transition-colors">Products</h3>
            <p class="text-4xl font-black text-accent font-body">{{ $productsCount }}</p>
        </a>
    </div>
@endsection
