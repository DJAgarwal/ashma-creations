@extends('layouts.app')

@section('title', 'Product Categories - Ashma Creations')

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
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold">Category Taxonomy</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">All Categories</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Browse our structured primary category classifications, subcategories, and handcrafted offerings.
                </p>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-3xl p-8 border border-primary-light/20 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-heading text-primary">
                            <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-accent transition-colors">
                                {{ $category->name }}
                            </a>
                        </h2>
                        <span class="text-xs font-body font-bold px-3 py-1 bg-primary-light/15 text-primary rounded-full">
                            {{ $category->products_count ?? 0 }} Items
                        </span>
                    </div>

                    <p class="text-xs font-body text-soft-gray mb-6 line-clamp-2 leading-relaxed">
                        {{ $category->description ?? 'Explore handcrafted items under ' . $category->name }}
                    </p>

                    @if($category->children && $category->children->count() > 0)
                        <div class="mb-6 pt-4 border-t border-primary-light/15">
                            <span class="text-[10px] font-body text-soft-gray uppercase tracking-wider block mb-2 font-bold">Subcategories</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($category->children as $child)
                                    <a href="{{ route('categories.show', $child->slug) }}" class="text-xs font-body px-3 py-1 bg-background hover:bg-primary-light/20 text-charcoal hover:text-primary rounded-lg transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-auto pt-4 border-t border-primary-light/15">
                        <a href="{{ route('categories.show', $category->slug) }}" class="text-xs font-body font-bold text-primary hover:text-accent flex items-center justify-between">
                            <span>Browse Landing Page</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
