@extends('layouts.app')

@section('title', $category->seo_title ?? ($category->meta_title ?? ($category->name . ' - Handcrafted Flowers & Gifts')))

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        @php
            $breadcrumbs = [
                ['label' => 'Categories', 'url' => route('categories.index')]
            ];
            if ($category->parent) {
                $breadcrumbs[] = [
                    'label' => $category->parent->name,
                    'url' => route('categories.show', $category->parent->slug)
                ];
            }
            $breadcrumbs[] = ['label' => $category->name];
        @endphp
        <x-breadcrumbs :items="$breadcrumbs" />

        <!-- Category Banner & SEO Landing Section -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8">
                    <!-- <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold">Category Landing Page</span> -->
                    <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">{{ $category->name }}</h1>
                    <p class="text-sm font-body text-soft-gray leading-relaxed mb-6">
                        {{ $category->description ?? 'Explore our curated collection of ' . $category->name . ' at Ashma Creations. Handcrafted everlasting pipe cleaner creations made with love.' }}
                    </p>

                    <!-- Subcategories Chips -->
                    <!-- @if(!empty($subcategories) && $subcategories->count() > 0)
                        <div class="pt-4 border-t border-primary-light/15">
                            <span class="text-xs font-body font-bold text-charcoal uppercase tracking-wider block mb-3">Subcategories in {{ $category->name }}</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($subcategories as $sub)
                                    <a href="{{ route('categories.show', $sub->slug) }}" class="px-4 py-1.5 bg-background border border-primary-light/30 text-charcoal hover:bg-primary hover:text-white rounded-full text-xs font-body font-semibold transition-colors">
                                        {{ $sub->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif -->
                </div>

                <!-- @if($category->image_path)
                    <div class="lg:col-span-4 hidden lg:block">
                        <div class="aspect-square rounded-2xl overflow-hidden border border-primary-light/30 shadow-md">
                            <img src="{{ filter_var($category->image_path, FILTER_VALIDATE_URL) ? $category->image_path : asset($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif -->
            </div>
        </div>

        <!-- Main Product Grid & Filters Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Filter Sidebar -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('categories.show', $category->slug)" />
            </div>

            <!-- Products Column -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> items in <span class="font-bold text-primary">{{ $category->name }}</span>
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
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products In {{ $category->name }}</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">No creations match the selected filter criteria for this category.</p>
                        <a href="{{ route('categories.show', $category->slug) }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Category Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Intro & FAQ Placeholder -->
        <!-- <div class="bg-white rounded-3xl p-8 md:p-12 border border-primary-light/20 shadow-sm space-y-8">
            <div>
                <h3 class="text-2xl font-heading text-primary mb-3">About Our {{ $category->name }}</h3>
                <p class="text-xs md:text-sm font-body text-soft-gray leading-relaxed">
                    At Ashma Creations, every item in our {{ $category->name }} catalog is meticulously crafted by hand using premium materials. Designed to remain pristine and beautiful, our pipe cleaner creations offer an everlasting alternative to traditional decor.
                </p>
            </div>

            <div class="pt-6 border-t border-primary-light/15">
                <h3 class="text-xl font-heading text-primary mb-4">Frequently Asked Questions</h3>
                <div class="space-y-4 font-body text-xs text-charcoal">
                    <div class="p-4 bg-background rounded-2xl">
                        <h4 class="font-bold text-sm text-primary mb-1">How are products in {{ $category->name }} crafted?</h4>
                        <p class="text-soft-gray">All creations are hand-shaped using chenille stem pipe cleaners, wrapped wire, and high-quality floral materials.</p>
                    </div>
                    <div class="p-4 bg-background rounded-2xl">
                        <h4 class="font-bold text-sm text-primary mb-1">Can I request custom modifications for {{ $category->name }}?</h4>
                        <p class="text-soft-gray">Yes! We accept custom color, size, and packaging requests via WhatsApp or our contact page.</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
