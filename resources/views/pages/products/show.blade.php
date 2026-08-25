@extends('layouts.app')

@section('title', !empty($product->meta_title) ? $product->meta_title : $product->name)
@section('meta_description', !empty($product->meta_description) ? $product->meta_description : (!empty($product->description) ? strip_tags($product->description) : ''))

@section('content')
<div class="bg-background py-10">
    <div class="container mx-auto px-4">
        <!-- Dynamic Breadcrumbs -->
        @php
            $breadcrumbItems = [];
            if ($product->primaryCategory) {
                if ($product->primaryCategory->parent) {
                    $breadcrumbItems[] = [
                        'label' => $product->primaryCategory->parent->name,
                        'url' => route('categories.show', $product->primaryCategory->parent->slug)
                    ];
                }
                $breadcrumbItems[] = [
                    'label' => $product->primaryCategory->name,
                    'url' => route('categories.show', $product->primaryCategory->slug)
                ];
            }
            $breadcrumbItems[] = ['label' => $product->name];
        @endphp
        <x-breadcrumbs :items="$breadcrumbItems" />

        <!-- Main Product Section -->
        <div class="bg-white rounded-3xl p-6 md:p-10 border border-primary-light/20 shadow-sm mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Gallery Column -->
                <div class="lg:col-span-6">
                    <div class="sticky top-28 space-y-4">
                        <!-- Main Display Image -->
                        <div class="aspect-square bg-gradient-to-br from-primary-light/10 to-secondary/10 rounded-3xl overflow-hidden border border-primary-light/20 shadow-inner flex items-center justify-center relative">
                            @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                <img id="main-product-image" 
                                     src="{{ filter_var($product->images[0], FILTER_VALIDATE_URL) ? $product->images[0] : asset($product->images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-primary-light/40 flex flex-col items-center">
                                    <svg class="w-24 h-24 mb-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                    <span class="text-xs font-body text-soft-gray">Handcrafted Art</span>
                                </div>
                            @endif

                            <!-- Badges Overlay -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <!-- @if($product->is_featured)
                                    <span class="px-3 py-1 text-xs font-body font-extrabold uppercase rounded-full bg-amber-500 text-white shadow-md">Featured</span>
                                @endif
                                @if($product->is_best_seller)
                                    <span class="px-3 py-1 text-xs font-body font-extrabold uppercase rounded-full bg-rose-500 text-white shadow-md">Best Seller</span>
                                @endif -->
                                <!-- @if($product->is_new_arrival)
                                    <span class="px-3 py-1 text-xs font-body font-extrabold uppercase rounded-full bg-emerald-500 text-white shadow-md">New Arrival</span>
                                @endif
                                @if($product->is_trending)
                                    <span class="px-3 py-1 text-xs font-body font-extrabold uppercase rounded-full bg-purple-600 text-white shadow-md">Trending</span>
                                @endif -->
                            </div>
                        </div>

                        <!-- Thumbnails Grid -->
                        @if(!empty($product->images) && is_array($product->images) && count($product->images) > 1)
                            <div class="flex gap-3 overflow-x-auto pb-2">
                                @foreach($product->images as $idx => $img)
                                    <button type="button" 
                                            data-gallery-src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img) }}" 
                                            class="js-gallery-thumb w-20 h-20 rounded-2xl overflow-hidden border-2 border-transparent hover:border-primary focus:border-primary transition-all flex-shrink-0">
                                        <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img) }}" alt="{{ $product->name }} view {{ $idx+1 }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Information Column -->
                <div class="lg:col-span-6 flex flex-col">
                    <!-- Primary Category Tag -->
                    @if($product->primaryCategory)
                        <div class="mb-3">
                            <a href="{{ route('categories.show', $product->primaryCategory->slug) }}" class="inline-block px-3 py-1 bg-primary-light/20 text-primary font-body text-xs font-bold rounded-full hover:bg-primary hover:text-white transition-colors">
                                {{ $product->primaryCategory->name }}
                            </a>
                        </div>
                    @endif

                    <h1 class="text-3xl sm:text-4xl font-heading text-charcoal mb-4">{{ $product->name }}</h1>

                    <!-- Price & Availability -->
                    <div class="mb-6 p-4 rounded-2xl bg-background border border-primary-light/20 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-body text-soft-gray uppercase tracking-wider block">Price & Availability</span>
                            <span class="text-xl font-heading text-primary">
                                @if(!is_null($product->price) && $product->price !== '')
                                    {{ (float)$product->price }} Rs (In Stock / Customization Available)
                                @else
                                    In Stock / Customization Available
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-sm font-body font-bold text-charcoal uppercase tracking-wider mb-2">Description</h3>
                        <p class="text-sm font-body text-soft-gray leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Handcrafted everlasting pipe cleaner flower creation made with precision and artistic care.' }}
                        </p>
                    </div>

                    @if(!empty($product->details))
                        <div class="mb-8 p-4 rounded-2xl bg-background border border-primary-light/20">
                            <h3 class="text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-2">Crafting & Product Details</h3>
                            <p class="text-xs font-body text-soft-gray leading-relaxed whitespace-pre-line">
                                {{ $product->details }}
                            </p>
                        </div>
                    @endif

                    <!-- COMPLETE TAXONOMY INFORMATION BADGES SECTION -->
                    <div class="mb-8 p-6 rounded-3xl bg-background border border-primary-light/20 space-y-4">
                        <h3 class="text-xs font-body font-bold text-primary uppercase tracking-widest border-b border-primary-light/20 pb-2">
                            Perfect For
                        </h3>

                        <!-- Category -->
                        <!-- @if($product->primaryCategory)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">Category:</span>
                                <a href="{{ route('categories.show', $product->primaryCategory->slug) }}" class="px-3 py-1 rounded-full bg-white border border-primary-light/30 text-primary text-xs font-body font-semibold hover:bg-primary hover:text-white transition-colors">
                                    {{ $product->primaryCategory->name }}
                                </a>
                            </div>
                        @endif -->

                        <!-- Collections -->
                        <!-- @if($product->collections && $product->collections->count() > 0)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">Collections:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->collections as $col)
                                        <a href="{{ route('collections.show', $col->slug) }}" class="px-3 py-1 rounded-full bg-secondary/15 text-primary text-xs font-body font-semibold hover:bg-primary hover:text-white transition-colors">
                                            {{ $col->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif -->

                        <!-- Occasions -->
                        @if($product->occasions && $product->occasions->count() > 0)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">Occasion:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->occasions as $occ)
                                        <a href="{{ route('occasions.show', $occ->slug) }}" class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-body font-semibold hover:bg-amber-600 hover:text-white transition-colors">
                                            {{ $occ->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Recipients -->
                        @if($product->recipients && $product->recipients->count() > 0)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">For:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->recipients as $rec)
                                        <a href="{{ route('recipients.show', $rec->slug) }}" class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-xs font-body font-semibold hover:bg-rose-500 hover:text-white transition-colors">
                                            {{ $rec->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Styles -->
                        <!-- @if($product->styles && $product->styles->count() > 0)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">Styles:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->styles as $sty)
                                        <a href="{{ route('styles.show', $sty->slug) }}" class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-body font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                            {{ $sty->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif -->

                        <!-- Materials -->
                        <!-- @if($product->materials && $product->materials->count() > 0)
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-body font-bold text-charcoal w-24">Materials:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->materials as $mat)
                                        <a href="{{ route('materials.show', $mat->slug) }}" class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-body font-semibold hover:bg-emerald-600 hover:text-white transition-colors">
                                            {{ $mat->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif -->
                    </div>

                    <!-- Call to Actions -->
                    <div class="mt-auto space-y-3 pt-4 border-t border-primary-light/20">
                        <a href="https://wa.me/917728879509?text={{ urlencode('Hi Ashma Creations, I am interested in: ' . $product->name . ' (' . route('products.show', $product->slug) . ')') }}" 
                           target="_blank" 
                           rel="noopener" 
                           class="w-full py-4 bg-emerald-600 text-white font-body font-bold text-sm rounded-2xl shadow-lg hover:bg-emerald-700 flex items-center justify-center gap-2 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                            Order / Inquire via WhatsApp
                        </a>
                        <!-- <a href="{{ url('/contact') }}" 
                           class="w-full py-3.5 bg-white border border-primary-light/40 text-primary font-body font-bold text-sm rounded-2xl hover:bg-primary-light/10 text-center block transition-colors">
                            Send General Inquiry
                        </a> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- SCORED RELATED PRODUCTS -->
        @if(!empty($relatedProducts) && $relatedProducts->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-8">
                <div>
                    <!-- <span class="text-xs font-body font-bold text-accent uppercase tracking-widest block mb-1">Taxonomy Match</span> -->
                    <h2 class="text-2xl md:text-3xl font-heading text-primary">Related Handcrafted Items</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs font-body font-bold text-primary hover:underline">
                    View Catalog &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
