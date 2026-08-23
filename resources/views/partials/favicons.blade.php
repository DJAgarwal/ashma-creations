<!-- Favicon and App Icons -->
<link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/ashma-favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/ashma-favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icons/ashma-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/icons/ashma-icon-512x512.png') }}">
<link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
<link rel="apple-touch-icon" href="{{ asset('images/icons/ashma-apple-touch-icon.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/ashma-apple-touch-icon.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Ashma Creations">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="{{ asset('manifest.json') }}" crossorigin="anonymous">
<script nonce="{{ $cspNonce ?? '' }}">
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').catch(function(err) {
                console.debug('SW registration error:', err);
            });
        });
    }
</script>
