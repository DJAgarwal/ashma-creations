@extends('layouts.app')

@section('title', $pageTitle ?? 'All Handcrafted Products - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Shop Catalog']
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2">Complete Handcrafted Catalog</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">{{ $pageTitle ?? 'Shop All Products' }}</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    {{ $metaDescription ?? 'Explore our complete collection of handcrafted pipe cleaner flowers, bouquets, pots, and custom decorative gifts.' }}
                </p>
            </div>
        </div>

        <!-- Main Layout (Sidebar Filters + Product Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('products.index')" />
            </div>

            <!-- Products Listing -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <!-- Active Filter Chips Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> handcrafted products
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-12 text-center border border-primary-light/20 my-8">
                        <div class="w-16 h-16 rounded-full bg-primary-light/20 text-primary flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products Found</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">Try adjusting your selected filters or search query.</p>
                        <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
