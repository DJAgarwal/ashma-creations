@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-background min-h-screen py-12 md:py-20">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="flex text-sm font-body text-soft-gray mb-12" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                    </li>
                    @if($product->category)
                        @if($product->category->parent)
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                    <a href="{{ route('categories.show', $product->category->parent->slug) }}" class="hover:text-primary transition-colors">{{ $product->category->parent->name }}</a>
                                </div>
                            </li>
                        @endif
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a>
                            </div>
                        </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                            <span class="text-primary font-bold">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Product Image Gallery -->
                <div class="lg:w-1/2">
                    <div class="bg-white rounded-[3rem] p-4 shadow-xl relative overflow-hidden group">
                        <div class="aspect-square bg-background rounded-[2.5rem] overflow-hidden">
                            @if($product->images && count($product->images) > 0)
                                <img id="main-image" src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-primary-light/30">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                </div>
                            @endif
                        </div>
                        
                        @if($product->images && count($product->images) > 1)
                            <div class="flex gap-4 mt-6">
                                @foreach($product->images as $image)
                                    <button onclick="document.getElementById('main-image').src = '{{ asset($image) }}'" class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-transparent hover:border-primary transition-all">
                                        <img src="{{ asset($image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <div class="absolute top-8 right-8 bg-primary text-white px-4 py-1.5 rounded-full text-xs font-bold font-body shadow-lg">
                            Handcrafted with Love
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="lg:w-1/2">
                    <div class="mb-4">
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-accent font-body font-bold uppercase tracking-widest text-sm hover:text-primary transition-colors">
                            {{ $product->category->name }}
                        </a>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-heading text-primary mb-8 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="prose prose-pink max-w-none mb-12">
                        <p class="text-xl text-soft-gray font-body leading-relaxed mb-8">
                            {{ $product->description }}
                        </p>
                        
                        @if($product->details)
                            <div class="bg-white/50 backdrop-blur-sm rounded-3xl p-8 border border-primary-light/10">
                                <h3 class="text-2xl font-heading text-primary mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Product Details
                                </h3>
                                <div class="font-body text-charcoal whitespace-pre-line leading-relaxed">
                                    {{ $product->details }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Contact/Inquiry Section -->
                    <div class="bg-primary/5 rounded-[2.5rem] p-10 border border-primary-light/20">
                        <h3 class="text-2xl font-heading text-primary mb-2">Interested in this piece?</h3>
                        <p class="text-soft-gray font-body mb-8">Every item is handmade and can be customized to your preference. Contact us to order or ask questions!</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://wa.me/917728879509?text=Hi, I am interested in {{ $product->name }}" target="_blank" class="flex-1 flex items-center justify-center gap-3 px-8 py-4 bg-[#25D366] text-white font-body font-bold rounded-full hover:bg-[#128C7E] transition-all transform hover:-translate-y-1 shadow-lg">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                                Contact on WhatsApp
                            </a>
                            <a href="{{ route('contact') }}?product={{ $product->slug }}" class="flex-1 flex items-center justify-center px-8 py-4 bg-primary text-white font-body font-bold rounded-full hover:bg-accent transition-all transform hover:-translate-y-1 shadow-lg">
                                Send Inquiry
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-32">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-heading text-primary mb-4">You May Also Like</h2>
                        <div class="w-20 h-1 bg-primary-light mx-auto rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                        @foreach($relatedProducts as $related)
                        <div class="group">
                            <div class="relative aspect-square bg-white rounded-3xl overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-300">
                                <a href="{{ route('products.show', $related->slug) }}">
                                    @if($related->images && count($related->images) > 0)
                                        <img src="{{ asset($related->images[0]) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-primary-light/30">
                                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-heading text-charcoal mb-4 hover:text-primary transition-colors">
                                    <a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                                </h3>
                                <a href="{{ route('products.show', $related->slug) }}" class="inline-block px-6 py-2 bg-primary-light/20 text-primary hover:bg-primary hover:text-white font-body font-semibold rounded-full transition-all text-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
