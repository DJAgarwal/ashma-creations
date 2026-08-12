@extends('layouts.app')

@section('title', $recipient->seo_title ?? ($recipient->meta_title ?? ('Handcrafted Gifts ' . $recipient->name)))

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Recipients', 'url' => route('recipients.index')],
            ['label' => $recipient->name]
        ]" />

        <!-- Recipient Hero Banner -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-10 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2">Recipient Landing Page</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">Gifts {{ $recipient->name }}</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Surprise {{ $recipient->name }} with unique, everlasting handcrafted pipe cleaner bouquets, flower pots, and customized decorative pieces made with love.
                </p>
            </div>
        </div>

        <!-- Main Content (Filters + Products) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-3">
                <x-catalog-filters :filterData="$filterData" :currentFilters="$currentFilters" :actionUrl="route('recipients.show', $recipient->slug)" />
            </div>

            <!-- Products Column -->
            <div class="lg:col-span-9">
                @if($products->count() > 0)
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-primary-light/20 text-xs font-body text-charcoal">
                        <div>
                            Showing <span class="font-bold text-primary">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> of <span class="font-bold text-primary">{{ $products->total() }}</span> gifts {{ $recipient->name }}
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
                        <h3 class="text-2xl font-heading text-primary mb-2">No Products Tagged {{ $recipient->name }}</h3>
                        <p class="text-xs font-body text-soft-gray mb-6">Try resetting active filters to browse all products for this recipient.</p>
                        <a href="{{ route('recipients.show', $recipient->slug) }}" class="px-6 py-2.5 bg-primary text-white font-body text-xs font-bold rounded-full hover:bg-accent transition-colors">
                            Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Intro Content -->
        <div class="bg-white rounded-3xl p-8 md:p-12 border border-primary-light/20 shadow-sm">
            <h3 class="text-2xl font-heading text-primary mb-3">Meaningful Everlasting Gifts {{ $recipient->name }}</h3>
            <p class="text-xs md:text-sm font-body text-soft-gray leading-relaxed">
                When shopping {{ $recipient->name }}, you want a gift that stays beautiful and heartwarming for years to come. Every piece in our {{ $recipient->name }} selection is hand-crafted with intricate attention to detail.
            </p>
        </div>
    </div>
</div>
@endsection
