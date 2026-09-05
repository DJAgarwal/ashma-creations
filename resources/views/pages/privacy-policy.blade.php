@extends('layouts.app')

@section('title', 'Privacy Policy - Ashma Creations')
@section('meta_description', 'At Ashma Creations, we create handmade art — not data profiles. Learn about our privacy-first promise, zero tracking, and no data harvesting.')

@section('content')
<x-legal-layout title="Privacy Policy">
    <!-- Privacy-First Pledge Banner -->
    <div class="bg-gradient-to-r from-primary-light/15 via-secondary/15 to-primary-light/15 border-2 border-dashed border-primary/30 rounded-3xl p-6 sm:p-8 mb-10 text-charcoal">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center shrink-0 shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <span class="inline-block px-3 py-1 bg-primary text-white text-xs font-bold rounded-full uppercase tracking-wider mb-1">Our Privacy Pledge</span>
                <h2 class="text-xl sm:text-2xl font-heading text-primary m-0">We Handcraft Gifts, Not Data Profiles</h2>
            </div>
        </div>
        <p class="text-soft-gray font-body text-base leading-relaxed m-0">
            At <strong>Ashma Creations</strong>, we take immense pride in running an honest, artisanal craft studio. We do <strong>not</strong> harvest, profile, track, or sell your personal information. You can explore our handcrafted flowers, bouquets, and decor freely without worrying about a digital footprint.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mt-6">
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 text-center border border-primary-light/30 shadow-sm">
                <span class="text-xl block mb-1">🚫</span>
                <span class="text-xs font-semibold text-charcoal">Zero Ad Tracking</span>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 text-center border border-primary-light/30 shadow-sm">
                <span class="text-xl block mb-1">🛡️</span>
                <span class="text-xs font-semibold text-charcoal">No Stored Profiles</span>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 text-center border border-primary-light/30 shadow-sm">
                <span class="text-xl block mb-1">🔒</span>
                <span class="text-xs font-semibold text-charcoal">Zero Card Data Saved</span>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 text-center border border-primary-light/30 shadow-sm">
                <span class="text-xl block mb-1">🤝</span>
                <span class="text-xs font-semibold text-charcoal">Never Sold to Anyone</span>
            </div>
        </div>
    </div>

    <!-- 1. Philosophy -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">1. Our Philosophy: Art Over Algorithms</h2>
        <p class="text-soft-gray leading-relaxed">
            Most websites use complicated privacy policies to justify taking as much user data as possible. We do the exact opposite. 
        </p>
        <p class="text-soft-gray leading-relaxed mt-3">
            <strong>Ashma Creations</strong> is an independent handmade creator based in India, specializing in everlasting pipe cleaner flower bouquets, ceramic flower pots, and bespoke gift keepsakes. We earn our living through our craftsmanship, creativity, and the joy of gifting — <strong>never by collecting, monetizing, or selling your data</strong>.
        </p>
    </div>

    <!-- 2. What We Don't Collect -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">2. What We Proudly Do NOT Collect</h2>
        <p class="text-soft-gray leading-relaxed">
            We believe your online browsing should remain private. Here is what we deliberately steer clear of:
        </p>
        <ul class="list-disc pl-6 mt-3 text-soft-gray space-y-2">
            <li><strong>No Behavioral Profiling:</strong> We do not track what other websites you visit, build demographic dossiers, or analyze your browsing habits.</li>
            <li><strong>No Invasive Ad Trackers:</strong> We do not run third-party advertising pixels, retargeting networks, or surveillance trackers designed to follow you across the internet.</li>
            <li><strong>No Forced Accounts:</strong> You do not need to register an account, set up passwords, or leave a permanent user profile on our servers just to view our creations.</li>
            <li><strong>No Financial or Card Storage:</strong> We never handle, see, or store your credit card, debit card, or banking credentials. Any payment is conducted directly and securely through encrypted UPI or banking channels.</li>
            <li><strong>No Marketing Spams:</strong> We do not compile your email or phone number into mass marketing blast lists. We despise spam just as much as you do.</li>
        </ul>
    </div>

    <!-- 3. The Only Data We Touch -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">3. The Only Information We Ever Touch (And Why)</h2>
        <p class="text-soft-gray leading-relaxed">
            Because our creations are physical items that must be shipped to real destinations, we only ever interact with the absolute minimum details necessary to craft and deliver your order:
        </p>
        <ul class="list-disc pl-6 mt-3 text-soft-gray space-y-2">
            <li><strong>Direct Communication (WhatsApp / Email):</strong> When you reach out to discuss a custom color palette, bouquet size, or special commission, we only receive the message and contact handle you voluntarily share with us to fulfill your request.</li>
            <li><strong>Delivery Label Details:</strong> When you place an order, we request your name, recipient delivery address, and contact number solely to write the shipping label and book courier transit with our delivery partner (e.g., India Post or courier service).</li>
            <li><strong>Essential Server Logs:</strong> Like every standard web server on the internet, our server registers temporary technical connection requests (such as error codes or anonymized page loads) strictly to keep the website running securely and prevent denial-of-service attacks.</li>
        </ul>
    </div>

    <!-- 4. Zero Data Selling -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">4. Zero Data Selling — Now and Forever</h2>
        <p class="text-soft-gray leading-relaxed">
            We have a strict, non-negotiable rule: <strong>We will never sell, rent, lease, exchange, or trade your personal information with any third party, broker, or advertiser.</strong>
        </p>
        <p class="text-soft-gray leading-relaxed mt-3">
            The only external party that ever receives your shipping address is the courier delivery partner responsible for bringing your package to your doorstep. They receive it for the sole purpose of fulfillment.
        </p>
    </div>

    <!-- 5. Cookies & Tracking -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">5. Cookies? Only What Is Strictly Necessary</h2>
        <p class="text-soft-gray leading-relaxed">
            We do not use advertising cookies, marketing cookies, or tracking beacons.
        </p>
        <p class="text-soft-gray leading-relaxed mt-3">
            Our website uses only essential, functional cookies required for core website operations — such as preserving security tokens to protect forms from automated spam bots and ensuring pages load smoothly. You can disable cookies entirely in your browser settings at any time, and you will still be able to browse all our creations.
        </p>
    </div>

    <!-- 6. Human-to-Human Communication -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">6. Direct Human-to-Human Ordering</h2>
        <p class="text-soft-gray leading-relaxed">
            When you contact us on <strong>WhatsApp (+91 7728879509)</strong> or <strong>Instagram (@ashma_creations07)</strong>, you speak directly with us — the artists behind the craft. 
        </p>
        <p class="text-soft-gray leading-relaxed mt-3">
            We treat our conversations with complete confidentiality and respect. Your phone number will never be added to automated marketing broadcast lists, third-party promotional groups, or robocall registries.
        </p>
    </div>

    <!-- 7. Your Right to Be Forgotten -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">7. Your Right to Complete Privacy</h2>
        <p class="text-soft-gray leading-relaxed">
            Because we don't maintain marketing databases, user dossiers, or customer tracking profiles, there is practically nothing about you stored on our systems.
        </p>
        <p class="text-soft-gray leading-relaxed mt-3">
            If you have ordered from us in the past and wish for your delivery details or past chat history to be cleared after delivery completion, simply drop us a message and we will gladly purge any fulfillment records from our communication channels.
        </p>
    </div>

    <!-- 8. Children's Privacy -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-3">8. Safe for Everyone &amp; Children</h2>
        <p class="text-soft-gray leading-relaxed">
            Our handcrafted floral arrangements and whimsical keepsakes are cherished by families and flower lovers of all ages. Because we do not track or harvest personal data from any visitor, our website is inherently safe, private, and secure for everyone.
        </p>
    </div>

    <!-- 9. Contact Us -->
    <div class="border-t border-primary-light/30 pt-10">
        <h2 class="text-2xl font-heading text-primary mb-3">9. Questions or Friendly Chats</h2>
        <p class="text-soft-gray leading-relaxed">
            If you have questions about our privacy commitment, want custom flower creations, or just want to say hi, we are always happy to hear from you:
        </p>
        <div class="mt-4 p-5 bg-background rounded-2xl border border-primary-light/20 text-soft-gray space-y-2">
            <div><strong>Email:</strong> <a href="mailto:ashmacreations07@gmail.com" class="text-primary hover:text-accent font-semibold underline">ashmacreations07@gmail.com</a></div>
            <div><strong>WhatsApp:</strong> <a href="https://wa.me/917728879509" target="_blank" rel="noopener" class="text-primary hover:text-accent font-semibold underline">+91 7728879509</a></div>
            <div><strong>Instagram:</strong> <a href="https://www.instagram.com/ashma_creations07" target="_blank" rel="noopener" class="text-primary hover:text-accent font-semibold underline">@ashma_creations07</a></div>
            <div class="pt-2 text-xs text-soft-gray/70"><strong>Last Updated:</strong> {{ date('F Y') }}</div>
        </div>
    </div>
</x-legal-layout>
@endsection
