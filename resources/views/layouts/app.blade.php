<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Preconnect and DNS-Prefetch for Performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://static.cloudflareinsights.com">
    <link rel="dns-prefetch" href="https://www.google-analytics.com">

    {{-- Dynamic JSON-LD Schema Injection --}}
    @if (!empty($page) && !empty($page->json_ld))
        @php
            $jsonldString = is_array($page->json_ld) 
                ? json_encode($page->json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) 
                : $page->json_ld;
        @endphp
        @if (!empty($jsonldString))
            <script nonce="{{ $cspNonce ?? '' }}" type="application/ld+json">{!! $jsonldString !!}</script>
        @endif
    @elseif (!empty($jsonld))
        <script nonce="{{ $cspNonce ?? '' }}" type="application/ld+json">{!! $jsonld !!}</script>
    @endif

    {{-- Custom Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link nonce="{{ $cspNonce ?? '' }}" rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ filemtime(public_path('css/custom.css')) }}">
    {{-- Essential Meta Tags --}}
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#EC407A">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    {{-- SEO Meta --}}
    @php
        $metaTitle = 'Ashma Creations - Handmade With Love';
        if (!empty($page) && !empty($page->meta_title)) {
            $metaTitle = $page->meta_title;
        } elseif (View::hasSection('title')) {
            $metaTitle = View::yieldContent('title') . ' - Ashma Creations';
        }

        $metaDescription = 'Ashma Creations crafts beautiful, everlasting handmade pipe cleaner flowers, custom bouquets, and flower pots.';
        if (!empty($page)) {
            if (!empty($page->meta_description)) {
                $metaDescription = $page->meta_description;
            } elseif (!empty($page->description)) {
                $metaDescription = \Illuminate\Support\Str::limit(strip_tags($page->description), 155);
            }
        }

        $metaImage = url('/images/logo.webp');
        if (isset($product) && !empty($product->images)) {
            $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
            if (!empty($images) && isset($images[0])) {
                $metaImage = filter_var($images[0], FILTER_VALIDATE_URL) ? $images[0] : asset($images[0]);
            }
        } elseif (isset($category) && !empty($category->image_path)) {
            $metaImage = filter_var($category->image_path, FILTER_VALIDATE_URL) ? $category->image_path : asset($category->image_path);
        }
    @endphp

    <!-- SEO Meta Tags -->
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $page->meta_keywords ?? 'handmade, crafts, pipe cleaner, bouquets, flower pots, custom gifts, Ashma Creations' }}">
    <meta name="author" content="Ashma Creations">
    <meta http-equiv="content-language" content="en">
    <meta name="geo.region" content="IN">
    <meta name="geo.placename" content="India">
    <meta name="distribution" content="global">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ request()->url() }}" />

    {{-- Open Graph / Social Sharing --}}
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="Ashma Creations">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta name="twitter:creator" content="{{ $twitter['creator'] ?? '@ashma_creations07' }}">
    <meta name="twitter:site" content="{{ $twitter['site'] ?? '@ashma_creations07' }}">

    <!-- Favicon and App Icons -->
    <link rel="icon"  sizes="32x32" href="{{ url('/favicon-32x32.png') }}" type="image/png">
    <link rel="icon"  sizes="16x16" href="{{ url('/favicon-16x16.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/images/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="{{ asset('manifest.json') }}" crossorigin="anonymous">

   
    @stack('styles')
    <link nonce="{{ $cspNonce ?? '' }}" href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body class="antialiased selection:bg-primary-light selection:text-primary">
    <div id="app" class="min-h-screen flex flex-col">
        @include('partials.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <!-- Tasteful Floating Elements (Optional/Placeholder) -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden -z-10 opacity-20">
        <div class="absolute top-10 left-10 text-primary-light animate-bounce animate-duration-10s">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        <div class="absolute bottom-20 right-10 text-secondary animate-pulse animate-duration-8s">
            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
        </div>
    </div>
</body>
</html>
