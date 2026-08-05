@extends('layouts.app')

@section('title', 'Shop By Occasion - Ashma Creations')

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            ['label' => 'Occasions']
        ]" />

        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 md:p-12 mb-12 border border-primary-light/20 shadow-sm relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-2 font-bold font-bold">Celebration Taxonomy</span>
                <h1 class="text-3xl md:text-5xl font-heading text-primary mb-4">Shop By Occasion</h1>
                <p class="text-sm font-body text-soft-gray leading-relaxed">
                    Find the perfect handcrafted floral creation tailored for birthdays, anniversaries, weddings, Mother's Day, and life's special milestones.
                </p>
            </div>
        </div>

        <!-- Occasions Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($occasions as $occ)
                <a href="{{ route('occasions.show', $occ->slug) }}" class="group bg-white rounded-3xl overflow-hidden border border-primary-light/20 shadow-sm hover:shadow-xl hover:border-primary transition-all duration-300 flex flex-col">
                    @if(!empty($occ->image_path))
                        <div class="w-full aspect-[5/6] overflow-hidden bg-amber-50/50 relative">
                            <img src="{{ filter_var($occ->image_path, FILTER_VALIDATE_URL) ? $occ->image_path : asset($occ->image_path) }}" alt="{{ $occ->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        </div>
                    @else
                        <div class="p-8 pb-0">
                            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all shadow-sm">
                                @if($occ->icon)
                                    <span class="text-3xl">{{ $occ->icon }}</span>
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm0 13C10.832 21 2 20 2 12c0-3 2.5-4.5 4.5-4.5.86 0 1.6.25 2.18.72.63.51 1.07 1.25 1.32 2.28.25-1.03.69-1.77 1.32-2.28.58-.47 1.32-.72 2.18-.72 2.5 0 4.5 1.5 4.5 4.5 0 8-8.832 9-10 9z"></path></svg>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-2xl font-heading text-charcoal group-hover:text-primary transition-colors mb-2">
                            {{ $occ->name }}
                        </h3>
                        <p class="text-xs font-body text-soft-gray mb-6 flex-grow leading-relaxed">
                            Handcrafted pipe cleaner bouquets and everlasting gifts perfect for {{ $occ->name }}.
                        </p>
                        <div class="pt-4 border-t border-primary-light/15 flex items-center justify-between text-xs font-body font-bold text-primary">
                            <span>{{ $occ->products_count ?? 0 }} Items</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
