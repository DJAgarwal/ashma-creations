@extends('layouts.app')

@section('title', ($occasion->meta_title ?? $occasion->name . ' Gifts & Handcrafted Bouquets') . ' - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Occasions', 'url' => route('occasions.index')],
            ['label' => $occasion->name]
        ]" />

        <!-- Occasion Hero / Banner -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-3">
                    <!-- <span class="p-2.5 bg-amber-50 text-amber-600 rounded-2xl text-xl">
                        {{ $occasion->icon ?? '🎁' }}
                    </span> -->
                    <!-- <span class="text-xs font-body font-bold text-accent uppercase tracking-widest">Occasion Landing Page</span> -->
                </div>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">Gifts For {{ $occasion->name }}</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Make {{ $occasion->name }} unforgettable with our everlasting handmade pipe cleaner flowers, custom bouquets, and decorative crafts.
                </p>
            </div>
        </div>

        <!-- Main Content (Filters + Products) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('occasions.show', $occasion->slug)" />
            </div>

            <!-- Products Column -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> gifts for <span class="font-bold text-primary">{{ $occasion->name }}</span>
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
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products Tagged For {{ $occasion->name }}</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">Try clearing active filters to view all products for this occasion.</p>
                        <a href="{{ route('occasions.show', $occasion->slug) }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Intro & FAQ Placeholder -->
        <!-- <div class="bg-white rounded-3xl p-8 md:p-12 border border-primary-light/20 shadow-sm space-y-8">
            <div>
                <h3 class="text-2xl font-heading text-primary mb-3">Why Choose Handcrafted Gifts For {{ $occasion->name }}?</h3>
                <p class="text-xs md:text-sm font-body text-soft-gray leading-relaxed">
                    Fresh flowers wither in a few days, but handcrafted pipe cleaner bouquets from Ashma Creations last forever. Giving a gift for {{ $occasion->name }} created by hand shows deep thought, care, and artistic appreciation.
                </p>
            </div>

            <div class="pt-6 border-t border-primary-light/15">
                <h3 class="text-xl font-heading text-primary mb-4">Frequently Asked Questions for {{ $occasion->name }}</h3>
                <div class="space-y-4 font-body text-xs text-charcoal">
                    <div class="p-4 bg-background rounded-2xl">
                        <h4 class="font-bold text-sm text-primary mb-1">Can I customize a bouquet specifically for {{ $occasion->name }}?</h4>
                        <p class="text-soft-gray">Absolutely! We can customize flower colors, stem arrangements, and greeting tags to suit {{ $occasion->name }}.</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
