<footer class="bg-white border-t border-primary-light/30 pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-8 lg:gap-10 mb-16">
            <!-- Brand Info (2 cols) -->
            <div class="lg:col-span-2">
                <a href="{{ url('/') }}" class="flex flex-col mb-4">
                    <span class="text-3xl font-heading text-primary">Ashma Creations</span>
                    <span class="text-xs font-body text-soft-gray tracking-widest uppercase">Handmade With Love</span>
                </a>
                <p class="text-soft-gray font-body text-sm leading-relaxed max-w-sm mb-6">
                    Creating handcrafted treasures that turn moments into memories. From elegant pipe cleaner bouquets and flower pots to personalized gifts, every creation is thoughtfully made with love, creativity, and attention to every detail.
                </p>
                <div class="flex flex-wrap items-center gap-2 text-xs font-body">
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Handmade
                    </span>
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Custom Orders
                    </span>
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Worldwide Shipping
                    </span>
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Secure Packaging
                    </span>
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Premium Quality
                    </span>
                    <span class="px-3 py-1 bg-primary-light/15 text-primary rounded-full font-semibold flex items-center gap-1.5">
                        <span class="text-primary font-bold">✔</span> Personalized Gifts
                    </span>
                </div>
            </div>

            <!-- Popular Searches -->
            <div>
                <h4 class="text-lg font-heading text-primary mb-4">Popular Searches</h4>
                <ul class="space-y-2.5 font-body text-xs text-charcoal">
                    <li><a href="{{ route('recipients.show', 'mom') }}" class="hover:text-primary transition-colors">Gift for Mom</a></li>
                    <li><a href="{{ route('recipients.show', 'wife') }}" class="hover:text-primary transition-colors">Gift for Wife</a></li>
                    <li><a href="{{ route('recipients.show', 'brother') }}" class="hover:text-primary transition-colors">Gift for Brother</a></li>
                    <li><a href="{{ route('occasions.show', 'birthday') }}" class="hover:text-primary transition-colors">Birthday Gifts</a></li>
                    <li><a href="{{ route('occasions.show', 'wedding') }}" class="hover:text-primary transition-colors">Wedding Gifts</a></li>
                    <li><a href="{{ route('occasions.show', 'housewarming') }}" class="hover:text-primary transition-colors">Housewarming Gifts</a></li>
                    <li><a href="{{ route('search', ['q' => 'Flower Pot']) }}" class="hover:text-primary transition-colors">Flower Pots</a></li>
                    <!-- <li><a href="{{ route('search', ['q' => 'Bouquets']) }}" class="hover:text-primary transition-colors">Bouquets</a></li> -->
                </ul>
            </div>

            <!-- Shop & Collections -->
            <div>
                <h4 class="text-lg font-heading text-primary mb-4">Shop & Discover</h4>
                <ul class="space-y-2.5 font-body text-xs text-charcoal">
                    <li><a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">All Products</a></li>
                    <li><a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors">Categories</a></li>
                    <li><a href="{{ route('collections.index') }}" class="hover:text-primary transition-colors">Featured Collections</a></li>
                    <li><a href="{{ route('recipients.index') }}" class="hover:text-primary transition-colors">Shop for Loved Ones</a></li>
                    <li><a href="{{ route('occasions.index') }}" class="hover:text-primary transition-colors">Celebrate Every Occasion</a></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-heading text-primary mb-4">Company</h4>
                <ul class="space-y-2.5 font-body text-xs text-charcoal">
                    <!-- <li><a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a></li> -->
                    <li><a href="{{ url('/about') }}" class="hover:text-primary transition-colors">Our Story</a></li>
                    <li><a href="{{ url('/faq') }}" class="hover:text-primary transition-colors">FAQ</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-primary transition-colors">Contact Us</a></li>
                    <li><a href="{{ url('/disclaimer') }}" class="hover:text-primary transition-colors">Disclaimer</a></li>
                    <li><a href="{{ url('/privacy-policy') }}" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                    <li><a href="{{ url('/terms-and-conditions') }}" class="hover:text-primary transition-colors">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Social & Contact -->
            <div>
                <h4 class="text-lg font-heading text-primary mb-4">Stay Connected</h4>
                <div class="flex flex-col space-y-3">
                    <a href="https://www.instagram.com/ashma_creations07" target="_blank" rel="noopener" class="flex items-center space-x-3 text-xs text-charcoal hover:text-primary transition-colors group">
                        <span class="p-2 bg-primary-light/10 rounded-full group-hover:bg-primary/20 transition-colors">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5C18.87 2 21 4.13 21 6.75v10.5c0 2.62-2.13 4.75-4.75 4.75h-8.5C5.13 22 3 19.87 3 17.25V6.75C3 4.13 5.13 2 7.75 2zm0 1.5c-1.8 0-3.25 1.45-3.25 3.25v10.5c0 1.8 1.45 3.25 3.25 3.25h8.5c1.8 0 3.25-1.45 3.25-3.25V6.75c0-1.8-1.45-3.25-3.25-3.25h-8.5zM12 7c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5zm5.25-.75c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75z"/></svg>
                        </span>
                        <span class="font-body">@ashma_creations07</span>
                    </a>
                    <a href="https://wa.me/917728879509" target="_blank" rel="noopener" class="flex items-center space-x-3 text-xs text-charcoal hover:text-primary transition-colors group">
                        <span class="p-2 bg-primary-light/10 rounded-full group-hover:bg-primary/20 transition-colors">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                        </span>
                        <span class="font-body">+91 7728879509</span>
                    </a>
                    <a href="mailto:ashmacreations07@gmail.com" class="flex items-center space-x-3 text-xs text-charcoal hover:text-primary transition-colors group">
                        <span class="p-2 bg-primary-light/10 rounded-full group-hover:bg-primary/20 transition-colors">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <span class="font-body break-all">ashmacreations07@gmail.com</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-primary-light/20 pt-8 flex flex-col md:flex-row items-center justify-between text-soft-gray text-xs font-body">
            <p>&copy; {{ date('Y') }} Ashma Creations. All rights reserved.</p>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <span>Handcrafted with passion in India 🇮🇳</span>
            </div>
        </div>
    </div>
</footer>
