<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-primary-light/30 shadow-sm">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo Area -->
        <a href="{{ url('/') }}" class="flex flex-col group">
            <span class="text-3xl font-heading text-primary group-hover:text-accent transition-colors">
                Ashma Creations
            </span>
            <span class="text-xs font-body text-soft-gray tracking-widest uppercase">
                Handmade With Love
            </span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="font-body font-medium text-charcoal hover:text-primary transition-colors {{ request()->is('/') ? 'text-primary border-b-2 border-primary' : '' }}">Home</a>
            <div class="relative group">
                <a href="{{ route('categories.index') }}" class="font-body font-medium text-charcoal hover:text-primary transition-colors flex items-center space-x-1 {{ request()->is('categories*') ? 'text-primary border-b-2 border-primary' : '' }}">
                    <span>Categories</span>
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
                <!-- Dropdown (Simplified for now) -->
                <div class="absolute left-0 mt-2 w-48 bg-white border border-primary-light/20 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                    <div class="py-2">
                        @foreach(App\Models\Category::whereNull('parent_id')->get() as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="block px-4 py-2 text-sm text-charcoal hover:bg-primary-light/10 hover:text-primary">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="{{ url('/about') }}" class="font-body font-medium text-charcoal hover:text-primary transition-colors {{ request()->is('about') ? 'text-primary border-b-2 border-primary' : '' }}">About</a>
            <a href="{{ url('/contact') }}" class="font-body font-medium text-charcoal hover:text-primary transition-colors {{ request()->is('contact') ? 'text-primary border-b-2 border-primary' : '' }}">Contact</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" type="button" aria-controls="mobile-menu" aria-expanded="false" class="md:hidden text-primary hover:text-accent focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>
</header>

{{-- Mobile menu lives outside the header so fixed positioning is not clipped by backdrop-blur --}}
<div id="mobile-menu" class="fixed inset-0 z-[60] invisible pointer-events-none md:hidden" aria-hidden="true">
    <div id="mobile-menu-backdrop" class="absolute inset-0 bg-charcoal/50 backdrop-blur-sm"></div>
    <aside id="mobile-menu-panel" class="absolute right-0 top-0 flex h-full w-72 max-w-[85vw] translate-x-full flex-col bg-white p-6 shadow-2xl transition-transform duration-300">
        <div class="flex justify-end">
            <button id="close-menu-btn" type="button" class="text-primary hover:text-accent focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="mt-6 flex flex-col gap-2">
            <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'mobile-nav-link-active' : '' }}">Home</a>
            <a href="{{ route('categories.index') }}" class="mobile-nav-link {{ request()->is('categories*') ? 'mobile-nav-link-active' : '' }}">Categories</a>
            <a href="{{ url('/about') }}" class="mobile-nav-link {{ request()->is('about') ? 'mobile-nav-link-active' : '' }}">About</a>
            <a href="{{ url('/contact') }}" class="mobile-nav-link {{ request()->is('contact') ? 'mobile-nav-link-active' : '' }}">Contact</a>
        </nav>
        <div class="mt-auto pt-12">
            <p class="text-sm font-body text-soft-gray uppercase tracking-widest mb-4 text-center">Follow Us</p>
            <div class="flex justify-center gap-3">
                <a href="https://www.instagram.com/ashma_creations07" target="_blank" rel="noopener noreferrer" class="mobile-social-link">Instagram</a>
                <a href="https://wa.me/917728879509" target="_blank" rel="noopener noreferrer" class="mobile-social-link">WhatsApp</a>
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
