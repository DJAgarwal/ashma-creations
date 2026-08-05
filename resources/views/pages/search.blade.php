@extends('layouts.app')

@section('title', (!empty($searchTerm) ? 'Search results for "' . $searchTerm . '"' : 'Search Catalog') . ' - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Search']
        ]" />

        <!-- Search Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold font-bold font-bold">Taxonomy Search</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">
                    @if(!empty($searchTerm))
                        Results for "{{ $searchTerm }}"
                    @else
                        Search Products & Taxonomies
                    @endif
                </h1>

                <!-- Search Input Bar -->
                <form action="{{ route('search') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <input type="text" 
                               name="q" 
                               value="{{ $searchTerm ?? '' }}" 
                               placeholder="Search by name, category, collection, occasion, recipient, style, or material..." 
                               class="w-full bg-background border border-primary-light/40 rounded-full pl-12 pr-4 py-3 text-sm font-body focus:outline-none focus:border-primary shadow-inner">
                        <svg class="w-5 h-5 text-soft-gray absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button type="submit" class="px-8 py-3 bg-primary text-white font-body font-bold text-sm rounded-full hover:bg-accent transition-colors shadow-md">
                        Search Catalog
                    </button>
                </form>
            </div>
        </div>

        <!-- Layout (Sidebar + Results Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('search')" />
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Found <span class="font-bold text-primary">{{ $products->total() }}</span> handcrafted creations matching your search
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-12 text-center border border-primary-light/20 my-8">
                        <div class="w-16 h-16 rounded-full bg-primary-light/20 text-primary flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-heading text-primary mb-2">No Matching Products Found</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">We couldn't find any products or taxonomy tags matching "{{ $searchTerm }}". Try searching for different terms like "Lavender", "Birthday", "Pot", or "Bouquet".</p>
                        <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            View All Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
