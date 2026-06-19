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
        <button id="mobile-menu-btn" class="md:hidden text-primary hover:text-accent focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>

    <!-- Mobile Slide-out Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] bg-charcoal/50 backdrop-blur-sm transform translate-x-full transition-transform duration-300 md:hidden">
        <div class="absolute right-0 top-0 h-full w-64 bg-background shadow-2xl p-6">
            <div class="flex justify-end">
                <button id="close-menu-btn" class="text-primary hover:text-accent">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="mt-8 flex flex-col space-y-6">
                <a href="{{ url('/') }}" class="text-xl font-heading text-charcoal hover:text-primary">Home</a>
                <a href="{{ route('categories.index') }}" class="text-xl font-heading text-charcoal hover:text-primary">Categories</a>
                <a href="{{ url('/about') }}" class="text-xl font-heading text-charcoal hover:text-primary">About</a>
                <a href="{{ url('/contact') }}" class="text-xl font-heading text-charcoal hover:text-primary">Contact</a>
            </nav>
            <div class="mt-auto pt-12">
                <p class="text-sm font-body text-soft-gray uppercase tracking-widest mb-4 text-center">Follow Us</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-primary hover:text-accent transition-colors">Instagram</a>
                    <a href="#" class="text-primary hover:text-accent transition-colors">WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</header>

<script nonce="{{ $cspNonce ?? '' }}">
    const btn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('close-menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.remove('translate-x-full');
    });

    closeBtn.addEventListener('click', () => {
        menu.classList.add('translate-x-full');
    });

    // Close menu when clicking outside
    menu.addEventListener('click', (e) => {
        if (e.target === menu) {
            menu.classList.add('translate-x-full');
        }
    });
</script>
