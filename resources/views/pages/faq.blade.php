@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <div class="bg-background min-h-screen py-12 md:py-16">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="flex text-sm font-body text-soft-gray mb-8 max-w-4xl mx-auto" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                            <span class="text-primary font-bold">Frequently Asked Questions</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-4xl mx-auto">
                <!-- Header Banner -->
                <div class="bg-white rounded-[3rem] p-8 md:p-14 shadow-xl border border-primary-light/10 mb-10 text-center relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-primary-light/15 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-accent/10 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <span class="text-xs font-body text-accent font-bold tracking-widest uppercase mb-3 block">Got Questions? We Have Answers</span>
                    <h1 class="text-4xl md:text-5xl font-heading text-primary mb-4">Frequently Asked Questions</h1>
                    <p class="text-soft-gray font-body text-base max-w-xl mx-auto mb-6">
                        Everything you need to know about our handcrafted pipe cleaner flowers, custom bouquet orders, care tips, shipping, and return policies.
                    </p>
                    <div class="w-20 h-1 bg-primary-light mx-auto rounded-full"></div>
                </div>

                <!-- Search Input for FAQs -->
                <div class="mb-8">
                    <div class="relative max-w-md mx-auto">
                        <input type="text" 
                               id="faq-search" 
                               placeholder="Search questions (e.g. custom, materials, shipping)..." 
                               class="w-full bg-white border border-primary-light/30 rounded-full pl-12 pr-4 py-3.5 text-sm font-body text-charcoal shadow-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        <svg class="w-5 h-5 text-soft-gray absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- FAQ Accordions -->
                <div class="space-y-4" id="faq-list">
                    <!-- FAQ 1: Materials -->
                    <div class="faq-item bg-white rounded-3xl border border-primary-light/20 shadow-sm hover:shadow-md transition-all overflow-hidden">
                        <button type="button" 
                                class="faq-toggle w-full px-6 py-5 md:px-8 md:py-6 text-left flex items-center justify-between gap-4 focus:outline-none group"
                                aria-expanded="false">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-primary-light/15 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-lg md:text-xl text-charcoal group-hover:text-primary transition-colors">
                                    What materials are used to make Ashma Creations' flowers and gifts?
                                </h3>
                            </div>
                            <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-background flex items-center justify-center shrink-0 text-primary transition-transform duration-300">
                                <svg class="w-4 h-4 faq-chevron transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-content hidden px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-dashed border-primary-light/20 text-soft-gray font-body text-base leading-relaxed">
                            <p class="mt-4">
                                Our flowers and decor pieces are meticulously handcrafted using premium high-density chenille pipe cleaners, soft plush fibers, durable floral wire stems, and high-quality ceramic or woven pots. 
                            </p>
                            <p class="mt-2">
                                Unlike natural flowers that wither in a few days, our pipe cleaner flowers stay soft, flexible, lightweight, and retain their vibrant colors forever without fading or requiring water.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 2: Custom Orders -->
                    <div class="faq-item bg-white rounded-3xl border border-primary-light/20 shadow-sm hover:shadow-md transition-all overflow-hidden">
                        <button type="button" 
                                class="faq-toggle w-full px-6 py-5 md:px-8 md:py-6 text-left flex items-center justify-between gap-4 focus:outline-none group"
                                aria-expanded="false">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-secondary/20 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-lg md:text-xl text-charcoal group-hover:text-primary transition-colors">
                                    Can I request a custom color, bouquet design, or personalized gift?
                                </h3>
                            </div>
                            <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-background flex items-center justify-center shrink-0 text-primary transition-transform duration-300">
                                <svg class="w-4 h-4 faq-chevron transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-content hidden px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-dashed border-primary-light/20 text-soft-gray font-body text-base leading-relaxed">
                            <p class="mt-4">
                                Absolutely! We love creating bespoke pieces tailored to your exact preferences. You can customize flower types (roses, tulips, sunflowers, lilies), custom color palettes, bouquet sizes, stem counts, and personalized gift tags or packaging.
                            </p>
                            <p class="mt-2">
                                Simply reach out to us on <strong>WhatsApp (+91 7728879509)</strong> or <strong>Instagram (@ashma_creations07)</strong> with your idea or photo reference, and we will collaborate with you step-by-step.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 3: Creation & Shipping Time -->
                    <div class="faq-item bg-white rounded-3xl border border-primary-light/20 shadow-sm hover:shadow-md transition-all overflow-hidden">
                        <button type="button" 
                                class="faq-toggle w-full px-6 py-5 md:px-8 md:py-6 text-left flex items-center justify-between gap-4 focus:outline-none group"
                                aria-expanded="false">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-accent/20 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-lg md:text-xl text-charcoal group-hover:text-primary transition-colors">
                                    How long does it take to create and deliver my order?
                                </h3>
                            </div>
                            <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-background flex items-center justify-center shrink-0 text-primary transition-transform duration-300">
                                <svg class="w-4 h-4 faq-chevron transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-content hidden px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-dashed border-primary-light/20 text-soft-gray font-body text-base leading-relaxed">
                            <p class="mt-4">
                                Because each creation is 100% handcrafted with precision and love, crafting typically takes <strong>2 to 4 business days</strong> depending on the bouquet size and complexity.
                            </p>
                            <p class="mt-2">
                                Once ready, we package your item in protective bubble wrap and shipping boxes. Delivery across India usually takes <strong>3 to 7 business days</strong>. We share tracking details as soon as your package is dispatched!
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 4: Care Instructions -->
                    <div class="faq-item bg-white rounded-3xl border border-primary-light/20 shadow-sm hover:shadow-md transition-all overflow-hidden">
                        <button type="button" 
                                class="faq-toggle w-full px-6 py-5 md:px-8 md:py-6 text-left flex items-center justify-between gap-4 focus:outline-none group"
                                aria-expanded="false">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-primary-light/15 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-lg md:text-xl text-charcoal group-hover:text-primary transition-colors">
                                    How do I clean and care for pipe cleaner flowers?
                                </h3>
                            </div>
                            <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-background flex items-center justify-center shrink-0 text-primary transition-transform duration-300">
                                <svg class="w-4 h-4 faq-chevron transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-content hidden px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-dashed border-primary-light/20 text-soft-gray font-body text-base leading-relaxed">
                            <p class="mt-4">
                                Caring for your everlasting flowers is simple and low-maintenance:
                            </p>
                            <ul class="list-disc list-inside mt-2 space-y-1.5">
                                <li><strong>Keep dry:</strong> Store away from direct water or high moisture.</li>
                                <li><strong>Dust removal:</strong> If dust settles over time, use a hairdryer on a <em>cool/low setting</em> to gently blow away dust, or lightly brush with a soft feather duster.</li>
                                <li><strong>Reshaping:</strong> The internal wire core allows petals and stems to be easily adjusted or bent back into shape whenever desired!</li>
                            </ul>
                        </div>
                    </div>

                    <!-- FAQ 5: Returns & Replacements -->
                    <div class="faq-item bg-white rounded-3xl border border-primary-light/20 shadow-sm hover:shadow-md transition-all overflow-hidden">
                        <button type="button" 
                                class="faq-toggle w-full px-6 py-5 md:px-8 md:py-6 text-left flex items-center justify-between gap-4 focus:outline-none group"
                                aria-expanded="false">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-secondary/20 text-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-heading text-lg md:text-xl text-charcoal group-hover:text-primary transition-colors">
                                    What is your return and cancellation policy for handmade items?
                                </h3>
                            </div>
                            <span class="faq-icon-wrapper w-8 h-8 rounded-full bg-background flex items-center justify-center shrink-0 text-primary transition-transform duration-300">
                                <svg class="w-4 h-4 faq-chevron transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-content hidden px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-dashed border-primary-light/20 text-soft-gray font-body text-base leading-relaxed">
                            <p class="mt-4">
                                Because all items are custom handmade upon order, we cannot accept returns for change-of-mind once crafting has started.
                            </p>
                            <p class="mt-2">
                                However, <strong>your satisfaction is our top priority</strong>. If your parcel arrives damaged during shipping, please record an unboxing photo/video and notify us within 24 hours of delivery via WhatsApp (+91 7728879509) or email (ashmacreations07@gmail.com). We will promptly send a replacement or resolve the issue.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Still Have Questions Card -->
                <div class="mt-14 bg-white rounded-[2.5rem] p-8 md:p-12 border border-primary-light/20 shadow-lg text-center relative overflow-hidden">
                    <div class="max-w-xl mx-auto space-y-4">
                        <div class="w-14 h-14 bg-primary-light/15 text-primary rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-heading text-primary">Still Have a Question?</h3>
                        <p class="text-soft-gray font-body text-sm leading-relaxed">
                            Can't find the answer you are looking for? Reach out directly and we'll be delighted to assist you!
                        </p>
                        <div class="pt-4 flex flex-wrap justify-center items-center gap-4">
                            <a href="https://wa.me/917728879509" target="_blank" rel="noopener" class="px-6 py-3 bg-primary text-white font-body font-semibold text-sm rounded-full shadow-md hover:bg-accent transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                                <span>Chat on WhatsApp</span>
                            </a>
                            <a href="{{ url('/contact') }}" class="px-6 py-3 bg-primary-light/15 text-primary font-body font-semibold text-sm rounded-full hover:bg-primary-light/30 transition-all">
                                Contact Us Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accordion & Search Toggle Script -->
    <script nonce="{{ $cspNonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.faq-toggle');
            const searchInput = document.getElementById('faq-search');
            const faqItems = document.querySelectorAll('.faq-item');

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const faqItem = this.closest('.faq-item');
                    const content = faqItem.querySelector('.faq-content');
                    const chevron = this.querySelector('.faq-chevron');
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';

                    // Close all other accordions for clean UX
                    toggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                            const otherItem = otherToggle.closest('.faq-item');
                            const otherContent = otherItem.querySelector('.faq-content');
                            const otherChevron = otherToggle.querySelector('.faq-chevron');
                            otherContent.classList.add('hidden');
                            if (otherChevron) otherChevron.classList.remove('rotate-180');
                        }
                    });

                    // Toggle current
                    if (isExpanded) {
                        this.setAttribute('aria-expanded', 'false');
                        content.classList.add('hidden');
                        if (chevron) chevron.classList.remove('rotate-180');
                    } else {
                        this.setAttribute('aria-expanded', 'true');
                        content.classList.remove('hidden');
                        if (chevron) chevron.classList.add('rotate-180');
                    }
                });
            });

            // Live filter function
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase().trim();
                    faqItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        if (!query || text.includes(query)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection
