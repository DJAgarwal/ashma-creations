@extends('layouts.app')

@section('title', 'Featured Collections - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Collections']
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-12 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold">Curated Selection</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">All Collections</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Explore our themed collections curated for special moments, holidays, gifting goals, and aesthetic trends.
                </p>
            </div>
        </div>

        <!-- Collections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($collections as $collection)
                <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-primary-light/20 transition-all duration-300 flex flex-col">
                    <div class="aspect-[16/9] bg-primary-light/20 relative overflow-hidden">
                        @if($collection->banner_image)
                            <img src="{{ filter_var($collection->banner_image, FILTER_VALIDATE_URL) ? $collection->banner_image : asset($collection->banner_image) }}" 
                                 alt="{{ $collection->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-light/30 to-secondary/30 text-primary">
                                <svg class="w-16 h-16 opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm-1-12h2v2h-2zm0 4h2v6h-2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-primary px-3 py-1 rounded-full text-xs font-bold font-body shadow-sm">
                            {{ $collection->products_count ?? 0 }} Items
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-2xl font-heading text-charcoal mb-2 hover:text-primary transition-colors">
                            <a href="{{ route('collections.show', $collection->slug) }}">{{ $collection->name }}</a>
                        </h3>
                        <p class="text-xs font-body text-soft-gray mb-6 line-clamp-2 leading-relaxed flex-grow">
                            {{ $collection->description ?? 'Explore unique handcrafted gifts curated for special moments.' }}
                        </p>
                        <a href="{{ route('collections.show', $collection->slug) }}" 
                           class="inline-flex items-center justify-center w-full py-3 bg-background border border-primary-light/40 text-primary font-body text-xs font-bold rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm">
                            Explore {{ $collection->name }} &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
