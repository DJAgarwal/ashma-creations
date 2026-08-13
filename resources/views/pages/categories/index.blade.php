@extends('layouts.app')

@section('title', 'Product Categories - Ashma Creations')
@section('meta_description', 'Discover handcrafted gift categories from Ashma Creations, including flower pots, photo frames, festive creations, and personalized wall hangings.')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Categories']
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-12 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <!-- <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold">Category Taxonomy</span> -->
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">All Categories</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Browse our category classifications, subcategories, and handcrafted offerings.
                </p>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                @php
                    $categoryImage = !empty($category->image_path)
                        ? (filter_var($category->image_path, FILTER_VALIDATE_URL) ? $category->image_path : asset($category->image_path))
                        : null;
                @endphp
                <div class="group bg-white rounded-3xl overflow-hidden border border-primary-light/20 shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 flex flex-col h-full relative cursor-pointer">
                    <!-- Whole Card Clickable Link -->
                    <a href="{{ route('categories.show', $category->slug) }}" class="absolute inset-0 z-10" aria-label="Browse {{ $category->name }}"></a>

                    <!-- Image Container -->
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-background">
                        @if($categoryImage)
                            <img src="{{ $categoryImage }}" 
                                 alt="{{ $category->name }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-primary-light/10 text-primary-light">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                            </div>
                        @endif

                        <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-body text-xs font-bold rounded-full shadow-sm z-20">
                            {{ $category->products_count ?? 0 }} Items
                        </span>
                    </div>

                    <!-- Details Container -->
                    <div class="p-6 md:p-8 flex flex-col flex-grow">
                        <h2 class="text-2xl font-heading text-primary group-hover:text-accent transition-colors mb-2">
                            <span>
                                {{ $category->name }}
                            </span>
                        </h2>

                        <p class="text-xs font-body text-soft-gray mb-6 line-clamp-2 leading-relaxed flex-grow">
                            {{ $category->description ?? 'Explore handcrafted items under ' . $category->name }}
                        </p>

                        @if($category->children && $category->children->count() > 0)
                            <div class="mb-6 pt-4 border-t border-primary-light/15 relative z-20">
                                <span class="text-[10px] font-body text-soft-gray uppercase tracking-wider block mb-2 font-bold">Subcategories</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('categories.show', $child->slug) }}" class="text-xs font-body px-3 py-1 bg-background hover:bg-primary-light/20 text-charcoal hover:text-primary rounded-lg transition-colors relative z-20">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-auto pt-4 border-t border-primary-light/15 flex items-center justify-between text-xs font-body font-bold text-primary group-hover:text-accent">
                            <span>Browse Category</span>
                            <span class="group-hover:translate-x-1 transition-transform duration-300">&rarr;</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
