@extends('layouts.app')

@section('title', 'Handmade Gifts, Crafts & Personalized Creations | Ashma Creations')
@section('meta_description', 'Discover unique handmade gifts, personalized creations, home decor and thoughtful keepsakes at Ashma Creations. Beautifully handcrafted with creativity and care for every special moment.')

@section('content')
<!-- 2. SHOP FOR LOVED ONES -->
    @if(!empty($recipients) && $recipients->count() > 0)
    <section class="py-10 md:py-20 bg-gradient-to-b from-white to-background">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading text-primary">Shop For Loved Ones</h2>
                </div>
                <!-- Sideways Scroll Controls -->
                <div class="flex items-center gap-2">
                    <button type="button" id="recipients-scroll-left" aria-label="Scroll left" class="w-10 h-10 rounded-full bg-white border border-primary-light/30 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" id="recipients-scroll-right" aria-label="Scroll right" class="w-10 h-10 rounded-full bg-white border border-primary-light/30 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Minimal Horizontal Icon/Image Carousel -->
            <div id="recipients-scroll-container" class="flex overflow-x-auto items-start gap-4 sm:gap-6 md:gap-8 pb-4 pt-1 no-scrollbar scroll-smooth snap-x snap-mandatory focus:outline-none" tabindex="0">
                @foreach($recipients as $rec)
                    @php
                        $recImg = !empty($rec->image_path) 
                            ? (filter_var($rec->image_path, FILTER_VALIDATE_URL) ? $rec->image_path : asset($rec->image_path)) 
                            : null;
                    @endphp
                    <a href="{{ route('recipients.show', $rec->slug) }}" class="group flex flex-col items-center flex-shrink-0 snap-start home-carousel-item text-center transition-all cursor-pointer">
                        <div class="relative home-carousel-img rounded-half overflow-hidden bg-transparent flex items-center justify-center mb-3">
                            @if($recImg)
                                <img src="{{ $recImg }}" 
                                     alt="{{ $rec->name }}" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center rounded-full bg-gradient-to-br from-amber-50 to-rose-50 text-amber-600">
                                    @if(!empty($rec->icon))
                                        <span class="text-3xl sm:text-4xl">{{ $rec->icon }}</span>
                                    @else
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <span class="text-xs sm:text-sm font-heading font-semibold text-charcoal group-hover:text-primary transition-colors text-center line-clamp-2 leading-tight px-1">
                            {{ $rec->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- 1. DYNAMIC BANNERS SLIDER (TOP HERO SECTION) -->
    @if(!empty($heroBanners) && $heroBanners->count() > 0)
    <section class="py-10 relative pt-4 pb-2 sm:pt-6 sm:pb-3 bg-background">
        <div class="container mx-auto px-0 sm:px-4 lg:px-6">
            <div class="hero-slider-shell">
                <div id="hero-slider-container" class="hero-slider-box">
                    <div id="hero-slides-wrapper" class="flex transition-transform duration-500 ease-in-out">
                    @foreach($heroBanners as $index => $banner)
                        @php
                            $desktopImg = asset($banner->desktop_image);
                            $mobileImg = $banner->mobile_image ? asset($banner->mobile_image) : null;
                        @endphp
                        <a href="{{ $banner->link_url }}" data-slide-index="{{ $index }}" class="hero-banner-slide group cursor-pointer relative block flex-shrink-0">
                            <div class="hero-banner-card w-full h-full rounded-2xl sm:rounded-3xl overflow-hidden relative shadow-md">
                                @if($mobileImg)
                                    <!-- Desktop Banner Image -->
                                    <img src="{{ $desktopImg }}" alt="{{ $banner->alt_text }}" class="hero-banner-img hidden sm:block">
                                    <!-- Mobile Banner Image -->
                                    <img src="{{ $mobileImg }}" alt="{{ $banner->alt_text }}" class="hero-banner-img block sm:hidden">
                                @else
                                    <!-- Single Image (Desktop & Mobile fallback) -->
                                    <img src="{{ $desktopImg }}" alt="{{ $banner->alt_text }}" class="hero-banner-img">
                                @endif
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Slider Navigation sits over the preview edges, not on the banner artwork. -->
                @if($heroBanners->count() > 1)
                    <button type="button" id="hero-slide-prev" aria-label="Previous Slide">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" id="hero-slide-next" aria-label="Next Slide">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <div class="hero-slider-dots">
                        @foreach($heroBanners as $index => $banner)
                            <button type="button" class="hero-dot w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-white/70 hover:bg-primary transition-all cursor-pointer {{ $index === 0 ? '!bg-primary !w-6 sm:!w-8' : '' }}" data-slide="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 3. SHOP BY CATEGORY -->
    @if(!empty($featuredCategories) && $featuredCategories->count() > 0)
    <section class="py-10 bg-background">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading text-primary">Explore All Categories</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredCategories as $cat)
                    @php
                        $catImg = !empty($cat->image_path) 
                            ? (filter_var($cat->image_path, FILTER_VALIDATE_URL) ? $cat->image_path : asset($cat->image_path)) 
                            : null;
                    @endphp
                    <a href="{{ route('categories.show', $cat->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-primary-light/20 flex flex-col h-full relative block">
                        <!-- Image Area -->
                        <div class="relative aspect-square bg-gradient-to-br from-primary-light/10 to-secondary/10 overflow-hidden">
                            @if($catImg)
                                <img src="{{ $catImg }}" 
                                     alt="{{ $cat->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-primary-light/40">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                    </svg>
                                </div>
                            @endif

                            @if(isset($cat->products_count))
                                <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-body text-xs font-bold rounded-full shadow-sm">
                                    {{ $cat->products_count }} Items
                                </span>
                            @endif
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 md:p-7 flex flex-col flex-grow text-left">
                            <h3 class="text-2xl font-heading text-charcoal mb-2 transition-colors line-clamp-1 group-hover:text-primary" title="{{ $cat->name }}">
                                {{ $cat->name }}
                            </h3>
                            <p class="text-xs font-body text-soft-gray line-clamp-2 leading-relaxed flex-grow">
                                {{ $cat->description ?? 'Explore handcrafted items under ' . $cat->name }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 4. FEATURED PRODUCTS GRID -->
    @if(!empty($featuredProducts) && $featuredProducts->count() > 0)
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading text-primary">Featured Products</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 5. SHOP BY OCCASION -->
    @if(!empty($occasions) && $occasions->count() > 0)
    <section class="py-10 md:py-20 bg-background">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading text-primary">Celebrate Every Occasion</h2>
                </div>
                <!-- Sideways Scroll Controls -->
                <div class="flex items-center gap-2">
                    <button type="button" id="occasions-scroll-left" aria-label="Scroll left" class="w-10 h-10 rounded-full bg-white border border-primary-light/30 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" id="occasions-scroll-right" aria-label="Scroll right" class="w-10 h-10 rounded-full bg-white border border-primary-light/30 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-95 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Minimal Horizontal Icon/Image Carousel -->
            <div id="occasions-scroll-container" class="flex overflow-x-auto items-start gap-4 sm:gap-6 md:gap-8 pb-4 pt-1 no-scrollbar scroll-smooth snap-x snap-mandatory focus:outline-none" tabindex="0">
                @foreach($occasions as $occ)
                    @php
                        $occImg = !empty($occ->image_path) 
                            ? (filter_var($occ->image_path, FILTER_VALIDATE_URL) ? $occ->image_path : asset($occ->image_path)) 
                            : null;
                    @endphp
                    <a href="{{ route('occasions.show', $occ->slug) }}" class="group flex flex-col items-center flex-shrink-0 snap-start home-carousel-item text-center transition-all cursor-pointer">
                        <div class="relative home-carousel-img rounded-half overflow-hidden bg-transparent flex items-center justify-center mb-3">
                            @if($occImg)
                                <img src="{{ $occImg }}" 
                                     alt="Handmade Gifts for {{ $occ->name }}" 
                                     loading="lazy" 
                                     class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center rounded-full bg-gradient-to-br from-amber-50 to-rose-50 text-amber-600">
                                    @if($occ->icon)
                                        <span class="text-3xl sm:text-4xl">{{ $occ->icon }}</span>
                                    @else
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm0 13C10.832 21 2 20 2 12c0-3 2.5-4.5 4.5-4.5.86 0 1.6.25 2.18.72.63.51 1.07 1.25 1.32 2.28.25-1.03.69-1.77 1.32-2.28.58-.47 1.32-.72 2.18-.72 2.5 0 4.5 1.5 4.5 4.5 0 8-8.832 9-10 9z"></path></svg>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <span class="text-xs sm:text-sm font-heading font-semibold text-charcoal group-hover:text-primary transition-colors text-center line-clamp-2 leading-tight px-1">
                            {{ $occ->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 6. CUSTOM ORDER CTA -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="bg-gradient-to-r from-primary to-accent rounded-[3rem] p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-heading mb-6 text-white">Have A Custom Request In Mind?</h2>
                    <p class="font-body text-base md:text-lg text-white/90 mb-8 leading-relaxed">
                        Have an idea? We'll bring it to life with handcrafted creations made just for you. Whether it's a unique bouquet, personalized gift, or custom décor, we'll craft it with love and attention to every detail.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="https://wa.me/917728879509" target="_blank" rel="noopener" class="px-8 py-3.5 bg-white text-primary font-body font-bold text-sm rounded-full shadow-lg hover:shadow-2xl hover:scale-105 transition-all">
                            Message Us On WhatsApp
                        </a>
                        <a href="{{ url('/contact') }}" class="px-8 py-3.5 border-2 border-white/60 text-white font-body font-bold text-sm rounded-full hover:bg-white/10 transition-all">
                            Send An Inquiry
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script nonce="{{ $cspNonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function () {
            // Infinite Loop Hero Banner Slider with Fixed Centering & Rock-Solid Prev/Next
            const heroContainer = document.getElementById('hero-slider-container');
            const heroWrapper = document.getElementById('hero-slides-wrapper');
            const heroPrev = document.getElementById('hero-slide-prev');
            const heroNext = document.getElementById('hero-slide-next');
            const heroDots = document.querySelectorAll('.hero-dot');
            const rawSlides = heroWrapper ? Array.from(heroWrapper.querySelectorAll('.hero-banner-slide')) : [];
            const N = rawSlides.length;

            if (heroWrapper && N > 0) {
                // Clone first and last slides for seamless infinite loop if N > 1
                if (N > 1) {
                    const firstClone = rawSlides[0].cloneNode(true);
                    firstClone.classList.add('is-clone');
                    const lastClone = rawSlides[N - 1].cloneNode(true);
                    lastClone.classList.add('is-clone');

                    heroWrapper.insertBefore(lastClone, rawSlides[0]);
                    heroWrapper.appendChild(firstClone);
                }

                const allDomSlides = Array.from(heroWrapper.querySelectorAll('.hero-banner-slide'));
                let currentDomIndex = N > 1 ? 1 : 0; // start at first real slide
                let isTransitioning = false;
                let transitionTimeout = null;
                let autoSlideTimer = null;

                function getRealIndex(domIdx) {
                    if (N <= 1) return 0;
                    if (domIdx === 0) return N - 1;
                    if (domIdx === N + 1) return 0;
                    return domIdx - 1;
                }

                function handleBoundarySnap() {
                    if (currentDomIndex === 0) {
                        currentDomIndex = N;
                        updateSliderPosition(false);
                    } else if (currentDomIndex === N + 1) {
                        currentDomIndex = 1;
                        updateSliderPosition(false);
                    }
                    isTransitioning = false;
                }

                function updateSliderPosition(animated = true) {
                    if (transitionTimeout) {
                        clearTimeout(transitionTimeout);
                        transitionTimeout = null;
                    }

                    const containerWidth = heroContainer.clientWidth;
                    if (!containerWidth || allDomSlides.length === 0) return;

                    if (N <= 1) {
                        heroWrapper.style.transform = 'translateX(0px)';
                        allDomSlides[0].classList.add('single-slide');
                        isTransitioning = false;
                        return;
                    }

                    // Outer slide container has NO scale transform, so offsetWidth is 100% constant & unscaled!
                    const slideWidth = allDomSlides[0].offsetWidth;
                    const style = window.getComputedStyle(heroWrapper);
                    const gap = parseFloat(style.gap || 16) || 16;

                    // Perfect center offset calculation
                    const centerOffset = (containerWidth - slideWidth) / 2;
                    const targetOffset = (currentDomIndex * (slideWidth + gap)) - centerOffset;

                    if (!animated) {
                        heroWrapper.style.transition = 'none';
                    } else {
                        heroWrapper.style.transition = 'transform 0.45s cubic-bezier(0.25, 1, 0.5, 1)';
                    }

                    heroWrapper.style.transform = `translateX(-${targetOffset}px)`;

                    const activeRealIndex = getRealIndex(currentDomIndex);

                    allDomSlides.forEach((slide, idx) => {
                        if (idx === currentDomIndex) {
                            slide.classList.add('hero-slide-active');
                            slide.classList.remove('hero-slide-inactive');
                        } else {
                            slide.classList.remove('hero-slide-active');
                            slide.classList.add('hero-slide-inactive');
                        }
                    });

                    heroDots.forEach((dot, i) => {
                        if (i === activeRealIndex) {
                            dot.classList.add('!bg-primary', '!w-6', 'sm:!w-8');
                        } else {
                            dot.classList.remove('!bg-primary', '!w-6', 'sm:!w-8');
                        }
                    });

                    if (animated) {
                        transitionTimeout = setTimeout(() => {
                            handleBoundarySnap();
                        }, 480);
                    } else {
                        isTransitioning = false;
                    }
                }

                function goToDomIndex(targetIndex) {
                    if (N <= 1 || isTransitioning) return;
                    isTransitioning = true;
                    currentDomIndex = targetIndex;
                    updateSliderPosition(true);
                }

                function nextSlide() {
                    if (N <= 1 || isTransitioning) return;
                    isTransitioning = true;
                    currentDomIndex++;
                    updateSliderPosition(true);
                }

                function prevSlide() {
                    if (N <= 1 || isTransitioning) return;
                    isTransitioning = true;
                    currentDomIndex--;
                    updateSliderPosition(true);
                }

                // Seamless boundary snap on CSS transitionend
                heroWrapper.addEventListener('transitionend', (e) => {
                    if (e.target !== heroWrapper) return;
                    handleBoundarySnap();
                });

                function resetAutoSlide() {
                    if (autoSlideTimer) {
                        clearInterval(autoSlideTimer);
                        startAutoSlide();
                    }
                }

                function startAutoSlide() {
                    if (N > 1) {
                        autoSlideTimer = setInterval(() => {
                            nextSlide();
                        }, 5000);
                    }
                }

                // Prevent button touch/pointer events from bubbling into slider
                [heroPrev, heroNext].forEach(btn => {
                    if (!btn) return;
                    ['touchstart', 'touchend', 'pointerdown', 'mousedown'].forEach(evt => {
                        btn.addEventListener(evt, (e) => e.stopPropagation());
                    });
                });

                // Click handlers for slides
                allDomSlides.forEach((slide, domIdx) => {
                    slide.addEventListener('click', function (e) {
                        if (domIdx !== currentDomIndex) {
                            e.preventDefault();
                            e.stopPropagation();
                            goToDomIndex(domIdx);
                            resetAutoSlide();
                        }
                    });
                });

                if (heroPrev) {
                    heroPrev.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        prevSlide();
                        resetAutoSlide();
                    });
                }

                if (heroNext) {
                    heroNext.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        nextSlide();
                        resetAutoSlide();
                    });
                }

                heroDots.forEach(dot => {
                    dot.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const realIdx = parseInt(this.getAttribute('data-slide'), 10);
                        goToDomIndex(realIdx + 1);
                        resetAutoSlide();
                    });
                });

                // Touch Swipe Support
                let startX = 0;
                let currentX = 0;
                let isDragging = false;

                heroWrapper.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    currentX = startX;
                    isDragging = true;
                }, { passive: true });

                heroWrapper.addEventListener('touchmove', (e) => {
                    if (!isDragging) return;
                    currentX = e.touches[0].clientX;
                }, { passive: true });

                heroWrapper.addEventListener('touchend', () => {
                    if (!isDragging) return;
                    isDragging = false;
                    const diffX = startX - currentX;
                    if (Math.abs(diffX) > 40) {
                        if (diffX > 0) {
                            nextSlide();
                        } else {
                            prevSlide();
                        }
                        resetAutoSlide();
                    }
                    startX = 0;
                    currentX = 0;
                });

                // Initial position & auto-play setup
                updateSliderPosition(false);
                startAutoSlide();

                // Recalculate layout on window resize & image load
                window.addEventListener('resize', () => updateSliderPosition(false));
                window.addEventListener('load', () => updateSliderPosition(false));
            }

            // Recipients scroll
            const recContainer = document.getElementById('recipients-scroll-container');
            const recLeftBtn = document.getElementById('recipients-scroll-left');
            const recRightBtn = document.getElementById('recipients-scroll-right');

            if (recContainer && recLeftBtn && recRightBtn) {
                recLeftBtn.addEventListener('click', function () {
                    recContainer.scrollBy({ left: -320, behavior: 'smooth' });
                });
                recRightBtn.addEventListener('click', function () {
                    recContainer.scrollBy({ left: 320, behavior: 'smooth' });
                });
            }

            // Occasions scroll
            const occContainer = document.getElementById('occasions-scroll-container');
            const occLeftBtn = document.getElementById('occasions-scroll-left');
            const occRightBtn = document.getElementById('occasions-scroll-right');

            if (occContainer && occLeftBtn && occRightBtn) {
                occLeftBtn.addEventListener('click', function () {
                    occContainer.scrollBy({ left: -320, behavior: 'smooth' });
                });
                occRightBtn.addEventListener('click', function () {
                    occContainer.scrollBy({ left: 320, behavior: 'smooth' });
                });
            }
        });
    </script>
@endsection
