@extends('layouts.app')

@section('title', 'Shop for Loved Ones - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Recipients']
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-12 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <!-- <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2">Recipient Taxonomy</span> -->
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">Shop for Loved Ones</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Discover personalized handcrafted floral gifts tailored for Wife, Mom, Girlfriend, Friends, Teachers, and loved ones.
                </p>
            </div>
        </div>

        <!-- Recipients Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($recipients as $rec)
                <a href="{{ route('recipients.show', $rec->slug) }}" class="group bg-white rounded-3xl overflow-hidden border border-primary-light/20 shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 flex flex-col">
                    @if(!empty($rec->image_path))
                        <div class="w-full aspect-[5/6] overflow-hidden bg-rose-50/50 relative">
                            <img src="{{ asset($rec->image_path) }}" alt="Handmade Gifts for {{ $rec->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        </div>
                    @else
                        <div class="p-8 pb-0">
                            <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                    @endif
                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-2xl font-heading text-charcoal group-hover:text-primary transition-colors mb-2">
                            Gifts for {{ $rec->name }}
                        </h3>
                        <p class="text-xs font-body text-soft-gray mb-6 flex-grow leading-relaxed">
                            Everlasting handcrafted pipe cleaner bouquets, flower pots, and decorative gifts tailored for {{ $rec->name }}.
                        </p>
                        <div class="pt-4 border-t border-primary-light/15 flex items-center justify-between text-xs font-body font-bold text-primary">
                            <span>{{ $rec->products_count ?? 0 }} Items</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
