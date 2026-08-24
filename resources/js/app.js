import './bootstrap';
import './admin-confirm-delete';

// Automatically unregister any legacy service workers and clear cache storage
if (typeof navigator !== 'undefined' && 'serviceWorker' in navigator) {
    navigator.serviceWorker.getRegistrations().then(function (registrations) {
        for (const registration of registrations) {
            registration.unregister();
        }
    }).catch(function () {});
}

if (typeof window !== 'undefined' && 'caches' in window) {
    caches.keys().then(function (names) {
        for (const name of names) {
            caches.delete(name);
        }
    }).catch(function () {});
}


