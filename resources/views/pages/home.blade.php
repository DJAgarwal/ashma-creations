@extends('layouts.app')

@section('title', 'Handmade Pipe Cleaner Flowers & Crafts')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-24 md:py-32 overflow-hidden bg-white">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-primary-light/10 -skew-x-12 transform origin-top-right"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-heading text-primary mb-6 leading-tight">
                    Crafting Happiness <br>
                    <span class="text-accent">One Flower At A Time</span>
                </h1>
                <p class="text-xl font-body text-soft-gray mb-10 leading-relaxed max-w-xl">
                    Beautiful, premium handmade pipe cleaner bouquets, flowers, and decorative crafts. Handcrafted with love to brighten your home and your heart.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('categories.index') }}" class="px-8 py-4 bg-primary text-white font-body font-bold rounded-full shadow-lg hover:bg-accent transition-all transform hover:-translate-y-1">
                        Explore Collection
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 border-2 border-primary text-primary font-body font-bold rounded-full hover:bg-primary/5 transition-all">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

        <!-- Hero Image Placeholder / Illustration -->
        <div class="hidden lg:block absolute top-1/2 right-4 -translate-y-1/2 w-1/3">
            <div class="relative">
                <div class="w-full aspect-square bg-primary-light/30 rounded-full flex items-center justify-center p-12">
                    <div class="w-full h-full bg-white rounded-full shadow-2xl flex items-center justify-center border-8 border-primary-light/50">
                         <!-- Replace with actual flower illustration or image later -->
                         <svg class="w-32 h-32 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zM12 7c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 2c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                         </svg>
                    </div>
                </div>
                <!-- Floating Small Flowers -->
                <div class="absolute top-0 right-0 text-accent animate-bounce" style="animation-duration: 4s;">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div class="absolute bottom-10 -left-10 text-secondary animate-pulse" style="animation-duration: 3s;">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-24 bg-background">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading text-primary mb-4">Explore Our World</h2>
                <div class="w-24 h-1 bg-primary-light mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredCategories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="aspect-[4/5] bg-primary-light/20 flex items-center justify-center relative overflow-hidden">
                        @if($category->image_path)
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="text-primary-light/50 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm-1-12h2v2h-2zm0 4h2v6h-2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <span class="text-white font-body font-bold">View Collection &rarr;</span>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-2xl font-heading text-primary mb-2">{{ $category->name }}</h3>
                        <p class="text-sm font-body text-soft-gray line-clamp-2">{{ $category->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between mb-16">
                <div>
                    <h2 class="text-4xl md:text-5xl font-heading text-primary mb-2 text-center md:text-left">Featured Creations</h2>
                    <p class="text-soft-gray font-body text-center md:text-left">Handpicked favorites from our latest collection.</p>
                </div>
                <a href="{{ route('categories.index') }}" class="mt-6 md:mt-0 font-body font-bold text-primary hover:text-accent transition-colors flex items-center gap-2">
                    See All Products 
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach($featuredProducts as $product)
                <div class="group">
                    <div class="relative aspect-square bg-background rounded-3xl overflow-hidden mb-6 shadow-sm group-hover:shadow-xl transition-all duration-300">
                        <a href="{{ route('products.show', $product->slug) }}">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-primary-light/30">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                </div>
                            @endif
                        </a>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-primary px-3 py-1 rounded-full text-xs font-bold font-body shadow-sm">
                            Handmade
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-body text-accent uppercase tracking-widest mb-1">{{ $product->category->name }}</p>
                        <h3 class="text-xl font-heading text-charcoal mb-4 hover:text-primary transition-colors">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <a href="{{ route('products.show', $product->slug) }}" class="inline-block px-6 py-2 bg-primary-light/20 text-primary hover:bg-primary hover:text-white font-body font-semibold rounded-full transition-all text-sm">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-24 bg-background overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 relative">
                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl rotate-3 transform hover:rotate-0 transition-transform duration-500">
                        <div class="aspect-[4/3] bg-primary-light/40 flex items-center justify-center">
                             <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    </div>
                    <div class="absolute -top-8 -right-8 w-64 h-64 bg-accent/20 rounded-full blur-3xl -z-10"></div>
                    <div class="absolute -bottom-8 -left-8 w-48 h-48 bg-gold/20 rounded-full blur-2xl -z-10"></div>
                </div>
                <div class="lg:w-1/2">
                    <h4 class="text-lg font-body text-accent font-bold uppercase tracking-widest mb-4">Our Story</h4>
                    <h2 class="text-4xl md:text-5xl font-heading text-primary mb-8 leading-tight">Every Creation Tells <br>A Unique Story</h2>
                    <div class="space-y-6 text-soft-gray font-body leading-relaxed">
                        <p>
                            Ashma Creations started as a passion project, born from a love for delicate craftsmanship and the artistic potential of simple materials. What began as a hobby has grown into a boutique catalog of eternal floral art.
                        </p>
                        <p>
                            Each pipe cleaner flower is meticulously hand-twisted, shaped, and assembled. Unlike real flowers, these creations never fade, serving as a lasting reminder of special moments and thoughtful gifts.
                        </p>
                    </div>
                    <div class="mt-10">
                        <a href="{{ url('/about') }}" class="font-body font-bold text-primary border-b-2 border-primary-light hover:border-primary transition-all pb-1">
                            Read Our Full Story &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="bg-gradient-to-br from-primary to-accent rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
                <!-- Decorative Shapes -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>

                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-4xl md:text-6xl font-heading text-white mb-8">Ready to bring home <br>some happiness?</h2>
                    <p class="text-white/80 font-body text-xl mb-12 leading-relaxed">
                        Interested in a specific creation or want to request a custom order? We're just a message away!
                    </p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="https://wa.me/917728879509" target="_blank" class="px-10 py-4 bg-white text-primary font-body font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            Chat on WhatsApp
                        </a>
                        <a href="{{ route('contact') }}" class="px-10 py-4 border-2 border-white/50 text-white font-body font-bold rounded-full hover:bg-white/10 transition-all">
                            Send an Inquiry
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
