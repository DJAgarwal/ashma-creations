@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="bg-background min-h-screen">
        <!-- Header & Breadcrumbs -->
        <div class="bg-white border-b border-primary-light/20 py-12">
            <div class="container mx-auto px-4">
                <nav class="flex text-sm font-body text-soft-gray mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                <a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors">Categories</a>
                            </div>
                        </li>
                        @if($category->parent)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                <a href="{{ route('categories.show', $category->parent->slug) }}" class="hover:text-primary transition-colors">{{ $category->parent->name }}</a>
                            </div>
                        </li>
                        @endif
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                <span class="text-primary font-bold">{{ $category->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="max-w-4xl">
                    <h1 class="text-5xl md:text-6xl font-heading text-primary mb-6">{{ $category->name }}</h1>
                    <p class="text-lg font-body text-soft-gray leading-relaxed">
                        {{ $category->description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="container mx-auto px-4 py-16">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                    @foreach($products as $product)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="aspect-square bg-background relative overflow-hidden">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary-light/30">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        </a>
                        <div class="p-6 text-center">
                            <p class="text-xs font-body text-accent uppercase tracking-widest mb-1">{{ $product->category->name }}</p>
                            <h3 class="text-xl font-heading text-charcoal mb-4 hover:text-primary transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="flex justify-center">
                                <a href="{{ route('products.show', $product->slug) }}" class="px-8 py-2 bg-primary-light/10 text-primary hover:bg-primary hover:text-white font-body font-bold rounded-full transition-all text-sm">
                                    View Product
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-16 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="w-32 h-32 bg-primary-light/10 rounded-full flex items-center justify-center mx-auto mb-8 text-primary-light">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </div>
                    <h3 class="text-3xl font-heading text-primary mb-4">No products found</h3>
                    <p class="text-soft-gray font-body mb-8">We haven't added any items to this category yet. Check back soon!</p>
                    <a href="{{ route('categories.index') }}" class="px-8 py-3 bg-primary text-white font-body font-bold rounded-full hover:bg-accent transition-all">
                        Back to All Collections
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
