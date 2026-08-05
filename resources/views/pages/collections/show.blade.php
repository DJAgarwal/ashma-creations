@extends('layouts.app')

@section('title', ($collection->meta_title ?? $collection->name . ' Collection') . ' - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Collections', 'url' => route('collections.index')],
            ['label' => $collection->name]
        ]" />

        <!-- Collection Banner & Landing Section -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8">
                    <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold">Curated Collection</span>
                    <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">{{ $collection->name }}</h1>
                    <p class="text-sm font-body text-soft-gray leading-relaxed">
                        {{ $collection->description ?? 'Discover our handpicked ' . $collection->name . ' collection at Ashma Creations. Everlasting pipe cleaner bouquets and custom gifts.' }}
                    </p>
                </div>

                @if($collection->banner_image)
                    <div class="lg:col-span-4 hidden lg:block">
                        <div class="aspect-[16/10] rounded-2xl overflow-hidden border border-primary-light/30 shadow-md">
                            <img src="{{ filter_var($collection->banner_image, FILTER_VALIDATE_URL) ? $collection->banner_image : asset($collection->banner_image) }}" alt="{{ $collection->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Product Grid & Filters Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Filter Sidebar -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('collections.show', $collection->slug)" />
            </div>

            <!-- Products Column -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> creations in <span class="font-bold text-primary">{{ $collection->name }}</span>
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
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products Found In {{ $collection->name }}</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">Try clearing active filters to view all products in this collection.</p>
                        <a href="{{ route('collections.show', $collection->slug) }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Intro Content -->
        <div class="bg-white rounded-3xl p-8 md:p-12 border border-primary-light/20 shadow-sm">
            <h3 class="text-2xl font-heading text-primary mb-3">About The {{ $collection->name }} Collection</h3>
            <p class="text-xs md:text-sm font-body text-soft-gray leading-relaxed">
                The {{ $collection->name }} collection brings together handcrafted pipe cleaner bouquets and artisanal crafts specially styled for this theme. Each product keeps its unique canonical URL while benefiting from curated discovery.
            </p>
        </div>
    </div>
</div>
@endsection
