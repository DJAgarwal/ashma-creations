<section class="py-12 bg-white min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm font-body text-soft-gray mb-12" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                        <span class="text-primary font-bold">{{ $title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-4xl font-bold text-gray-800 mb-8">{{ $title }}</h1>
        <div class="prose max-w-none text-gray-600 leading-relaxed space-y-8">
            {{ $slot }}
        </div>
    </div>
</section>
