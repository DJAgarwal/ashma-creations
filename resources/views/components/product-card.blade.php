@props(['product', 'showBadges' => true, 'isFirst' => false])

<a href="{{ route('products.show', $product->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-primary-light/20 flex flex-col h-full relative block">
    <!-- Image Area -->
    <div class="relative aspect-square bg-gradient-to-br from-primary-light/10 to-secondary/10 overflow-hidden">
        <div class="w-full h-full">
            @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                <img src="{{ filter_var($product->images[0], FILTER_VALIDATE_URL) ? $product->images[0] : asset($product->images[0]) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                     @if($isFirst) loading="eager" fetchpriority="high" @else loading="lazy" @endif>
            @else
                <div class="w-full h-full flex items-center justify-center text-primary-light/40">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Badges Stack (Top Left) -->
        <!-- @if($showBadges)
            <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
                @if($product->is_featured)
                    <span class="px-2.5 py-1 text-[10px] font-body font-extrabold uppercase tracking-wider rounded-full bg-amber-500 text-white shadow-md">
                        Featured
                    </span>
                @endif
                @if($product->is_best_seller)
                    <span class="px-2.5 py-1 text-[10px] font-body font-extrabold uppercase tracking-wider rounded-full bg-rose-500 text-white shadow-md">
                        Best Seller
                    </span>
                @endif
                @if($product->is_new_arrival)
                    <span class="px-2.5 py-1 text-[10px] font-body font-extrabold uppercase tracking-wider rounded-full bg-emerald-500 text-white shadow-md">
                        New
                    </span>
                @endif
                @if($product->is_trending)
                    <span class="px-2.5 py-1 text-[10px] font-body font-extrabold uppercase tracking-wider rounded-full bg-purple-600 text-white shadow-md">
                        Trending
                    </span>
                @endif
            </div>
        @endif -->

        <!-- Quick Actions (Top Right) -->
        <!-- <div class="absolute top-3 right-3 flex flex-col gap-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button type="button" 
                    title="Add to Wishlist"
                    class="js-wishlist-btn w-9 h-9 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-charcoal hover:text-rose-500 hover:bg-white shadow-md transition-colors">
                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </button>
            <a href="{{ route('products.show', $product->slug) }}" 
               title="Quick View" 
               class="w-9 h-9 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-charcoal hover:text-primary hover:bg-white shadow-md transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </a>
        </div> -->

        <!-- Primary Category Overlay Banner -->
        <!-- @if($product->primaryCategory)
            <div class="absolute bottom-3 left-3 z-10">
                <a href="{{ route('categories.show', $product->primaryCategory->slug) }}" 
                   class="px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-body text-xs font-semibold rounded-full shadow-sm hover:bg-primary hover:text-white transition-colors">
                    {{ $product->primaryCategory->name }}
                </a>
            </div>
        @endif -->
    </div>

    <!-- Content Area -->
    <div class="p-6 flex flex-col flex-grow text-left">
        <!-- Title -->
        <h3 class="text-xl font-heading text-charcoal mb-2 transition-colors line-clamp-1 group-hover:text-primary" title="{{ $product->name }}">
            {{ $product->name }}
        </h3>

        <!-- Description Snippet -->
        <!-- <p class="text-xs font-body text-soft-gray mb-4 line-clamp-2 leading-relaxed flex-grow">
            {{ Str::limit(strip_tags($product->description ?? 'Handcrafted everlasting pipe cleaner creation.'), 90) }}
        </p> -->

        <!-- Taxonomy Tags Snippet -->
        <!-- <div class="flex flex-wrap gap-1 mb-5 min-h-[26px]">
            @if($product->collections && $product->collections->count() > 0)
                @foreach($product->collections->take(2) as $collection)
                    <a href="{{ route('collections.show', $collection->slug) }}" class="text-[11px] font-body px-2.5 py-0.5 rounded-md bg-secondary/15 text-primary hover:bg-primary hover:text-white transition-colors">
                        {{ $collection->name }}
                    </a>
                @endforeach
            @endif

            @if($product->occasions && $product->occasions->count() > 0)
                @foreach($product->occasions->take(1) as $occasion)
                    <a href="{{ route('occasions.show', $occasion->slug) }}" class="text-[11px] font-body px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white transition-colors">
                        {{ $occasion->name }}
                    </a>
                @endforeach
            @endif
        </div> -->

        <!-- Footer / CTA -->
        <!-- <div class="pt-4 border-t border-primary-light/10 flex items-center justify-between mt-auto">
            <div class="flex flex-col">
                <span class="text-[10px] font-body text-soft-gray uppercase tracking-wider">Price</span>
                <span class="text-sm font-body font-bold text-primary">Inquire for Price</span>
            </div>
            <a href="{{ route('products.show', $product->slug) }}" 
               class="px-5 py-2 bg-primary-light/20 text-primary hover:bg-primary hover:text-white font-body text-xs font-bold rounded-full transition-all duration-300">
                View Details
            </a>
        </div> -->
    </div>
</a>