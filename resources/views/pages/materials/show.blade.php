@extends('layouts.app')

@section('title', ($material->meta_title ?? 'Creations Crafted With ' . $material->name) . ' - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Shop Catalog', 'url' => route('products.index')],
            ['label' => 'Material: ' . $material->name]
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2">Material Filter Landing Page</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">Crafted With {{ $material->name }}</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Explore all handcrafted floral creations made using premium {{ $material->name }} at Ashma Creations.
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Sidebar -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('materials.show', $material->slug)" />
            </div>

            <!-- Products Column -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> items made with <span class="font-bold text-primary">{{ $material->name }}</span>
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
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products Crafted With {{ $material->name }}</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">Try clearing active filters to view all products with this material.</p>
                        <a href="{{ route('materials.show', $material->slug) }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
