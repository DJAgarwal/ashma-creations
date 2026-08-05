<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-primary-light/30 shadow-sm">
    <div class="container mx-auto px-4 py-3.5 flex items-center justify-between">
        <!-- Logo Area -->
        <a href="{{ url('/') }}" class="flex flex-col group">
            <span class="text-2xl md:text-3xl font-heading text-primary group-hover:text-accent transition-colors">
                Ashma Creations
            </span>
            <span class="text-[10px] font-body text-soft-gray tracking-widest uppercase">
                Handmade With Love
            </span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-7">
            <!-- Home -->
            <a href="{{ url('/') }}" 
               class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors py-1 {{ request()->is('/') ? 'text-primary border-b-2 border-primary' : '' }}">
                Home
            </a>

            <!-- Shop (All Products Catalog) -->
            <a href="{{ route('products.index') }}" 
               class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors py-1 {{ request()->is('products*') || request()->is('shop') ? 'text-primary border-b-2 border-primary' : '' }}">
                Shop
            </a>

            <!-- Collections Dropdown -->
            <div class="relative group py-1">
                <a href="{{ route('collections.index') }}" 
                   class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors flex items-center gap-1 {{ request()->is('collection*') ? 'text-primary border-b-2 border-primary' : '' }}">
                    <span>Collections</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 text-soft-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <div class="absolute left-0 mt-2 w-56 bg-white border border-primary-light/20 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 p-2 z-50">
                    <a href="{{ route('collections.index') }}" class="block px-3 py-2 text-xs font-bold font-body text-primary uppercase tracking-wider border-b border-primary-light/10 hover:bg-primary-light/10 rounded-xl mb-1">
                        All Collections &rarr;
                    </a>
                    @foreach(App\Models\Collection::active()->ordered()->take(6)->get() as $navCol)
                        <a href="{{ route('collections.show', $navCol->slug) }}" class="block px-3 py-2 text-xs font-body text-charcoal hover:bg-primary-light/10 hover:text-primary rounded-xl transition-colors">
                            {{ $navCol->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Occasions Dropdown -->
            <div class="relative group py-1">
                <a href="{{ route('occasions.index') }}" 
                   class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors flex items-center gap-1 {{ request()->is('occasion*') ? 'text-primary border-b-2 border-primary' : '' }}">
                    <span>Occasions</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 text-soft-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <div class="absolute left-0 mt-2 w-56 bg-white border border-primary-light/20 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 p-2 z-50">
                    <a href="{{ route('occasions.index') }}" class="block px-3 py-2 text-xs font-bold font-body text-primary uppercase tracking-wider border-b border-primary-light/10 hover:bg-primary-light/10 rounded-xl mb-1">
                        All Occasions &rarr;
                    </a>
                    @foreach(App\Models\Occasion::active()->ordered()->take(6)->get() as $navOcc)
                        <a href="{{ route('occasions.show', $navOcc->slug) }}" class="block px-3 py-2 text-xs font-body text-charcoal hover:bg-primary-light/10 hover:text-primary rounded-xl transition-colors">
                            {{ $navOcc->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Categories Dropdown (Supplemental) -->
            <div class="relative group py-1">
                <a href="{{ route('categories.index') }}" 
                   class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors flex items-center gap-1 {{ request()->is('categor*') ? 'text-primary border-b-2 border-primary' : '' }}">
                    <span>Categories</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 text-soft-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <div class="absolute left-0 mt-2 w-56 bg-white border border-primary-light/20 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 p-2 z-50">
                    <a href="{{ route('categories.index') }}" class="block px-3 py-2 text-xs font-bold font-body text-primary uppercase tracking-wider border-b border-primary-light/10 hover:bg-primary-light/10 rounded-xl mb-1">
                        All Categories &rarr;
                    </a>
                    @foreach(App\Models\Category::whereNull('parent_id')->active()->ordered()->take(6)->get() as $navCat)
                        <a href="{{ route('categories.show', $navCat->slug) }}" class="block px-3 py-2 text-xs font-body text-charcoal hover:bg-primary-light/10 hover:text-primary rounded-xl transition-colors">
                            {{ $navCat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- About -->
            <a href="{{ url('/about') }}" 
               class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors py-1 {{ request()->is('about') ? 'text-primary border-b-2 border-primary' : '' }}">
                About
            </a>

            <!-- Contact -->
            <a href="{{ url('/contact') }}" 
               class="font-body text-sm font-semibold text-charcoal hover:text-primary transition-colors py-1 {{ request()->is('contact') ? 'text-primary border-b-2 border-primary' : '' }}">
                Contact
            </a>
        </nav>

        <!-- Right Action Icons (Search Bar trigger & Mobile Toggle) -->
        <div class="flex items-center gap-3">
            <!-- Search Form Inline / Button -->
            <form action="{{ route('search') }}" method="GET" class="hidden lg:flex items-center relative">
                <input type="text" 
                       name="q" 
                       placeholder="Search products..." 
                       value="{{ request('q') }}"
                       class="w-48 bg-background border border-primary-light/30 rounded-full pl-8 pr-3 py-1.5 text-xs font-body focus:w-60 focus:border-primary transition-all focus:outline-none">
                <svg class="w-4 h-4 text-soft-gray absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>

            <a href="{{ route('search') }}" class="lg:hidden p-2 text-primary hover:text-accent focus:outline-none" title="Search">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </a>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" type="button" aria-controls="mobile-menu" aria-expanded="false" class="md:hidden text-primary hover:text-accent focus:outline-none p-1">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>
</header>

{{-- Mobile menu drawer --}}
<div id="mobile-menu" class="fixed inset-0 z-[60] invisible pointer-events-none md:hidden" aria-hidden="true">
    <div id="mobile-menu-backdrop" class="absolute inset-0 bg-charcoal/50 backdrop-blur-sm"></div>
    <aside id="mobile-menu-panel" class="absolute right-0 top-0 flex h-full w-80 max-w-[85vw] translate-x-full flex-col bg-white p-6 shadow-2xl transition-transform duration-300 overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-primary-light/20">
            <span class="text-xl font-heading text-primary">Navigation</span>
            <button id="close-menu-btn" type="button" class="text-primary hover:text-accent focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="mt-4">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="Search creations..." class="w-full bg-background border border-primary-light/30 rounded-xl pl-9 pr-3 py-2 text-xs font-body focus:outline-none focus:border-primary">
                <svg class="w-4 h-4 text-soft-gray absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>

        <nav class="mt-6 flex flex-col gap-2 font-body text-sm">
            <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'mobile-nav-link-active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="mobile-nav-link {{ request()->is('products*') || request()->is('shop') ? 'mobile-nav-link-active' : '' }}">Shop Catalog</a>
            <a href="{{ route('collections.index') }}" class="mobile-nav-link {{ request()->is('collection*') ? 'mobile-nav-link-active' : '' }}">Collections</a>
            <a href="{{ route('occasions.index') }}" class="mobile-nav-link {{ request()->is('occasion*') ? 'mobile-nav-link-active' : '' }}">Occasions</a>
            <a href="{{ route('recipients.index') }}" class="mobile-nav-link {{ request()->is('recipient*') ? 'mobile-nav-link-active' : '' }}">Shop for Loved Ones</a>
            <a href="{{ route('categories.index') }}" class="mobile-nav-link {{ request()->is('categor*') ? 'mobile-nav-link-active' : '' }}">Categories</a>
            <a href="{{ url('/about') }}" class="mobile-nav-link {{ request()->is('about') ? 'mobile-nav-link-active' : '' }}">About Us</a>
            <a href="{{ url('/contact') }}" class="mobile-nav-link {{ request()->is('contact') ? 'mobile-nav-link-active' : '' }}">Contact</a>
        </nav>

        <div class="mt-auto pt-8 border-t border-primary-light/20">
            <p class="text-xs font-body text-soft-gray uppercase tracking-widest mb-3 text-center">Get in Touch</p>
            <div class="flex justify-center gap-4 text-xs font-body">
                <a href="https://www.instagram.com/ashma_creations07" target="_blank" rel="noopener" class="text-primary hover:underline">Instagram</a>
                <span>&bull;</span>
                <a href="https://wa.me/917728879509" target="_blank" rel="noopener" class="text-primary hover:underline">WhatsApp</a>
            </div>
        </div>
    </aside>
</div>

<script nonce="{{ $cspNonce ?? '' }}">
    const btn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('close-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const panel = document.getElementById('mobile-menu-panel');
    const backdrop = document.getElementById('mobile-menu-backdrop');

    function openMobileMenu() {
        menu.classList.remove('invisible', 'pointer-events-none');
        menu.setAttribute('aria-hidden', 'false');
        btn.setAttribute('aria-expanded', 'true');
        document.body.classList.add('overflow-hidden');
        panel.classList.remove('translate-x-full');
    }

    function closeMobileMenu() {
        panel.classList.add('translate-x-full');
        menu.classList.add('invisible', 'pointer-events-none');
        menu.setAttribute('aria-hidden', 'true');
        btn.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('overflow-hidden');
    }

    btn.addEventListener('click', openMobileMenu);
    closeBtn.addEventListener('click', closeMobileMenu);
    backdrop.addEventListener('click', closeMobileMenu);
</script>
