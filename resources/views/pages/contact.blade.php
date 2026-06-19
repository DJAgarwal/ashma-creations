@extends('layouts.app')

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
                            <span class="text-primary font-bold">Contact Us</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-4xl mx-auto bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-primary-light/10">
                <!-- Banner Header -->
                <div class="bg-primary p-12 md:p-16 text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -translate-x-1/3 translate-y-1/3"></div>
                    <div class="relative z-10">
                        <span class="text-xs font-body text-white/80 tracking-widest uppercase mb-3 block">Get in Touch</span>
                        <h1 class="text-4xl md:text-5xl font-heading mb-6">Let's Create Something Beautiful</h1>
                        <p class="text-white/95 font-body text-lg leading-relaxed max-w-xl mx-auto">
                            If there's a custom bouquet, a specific color scheme, or a personalized flower arrangement you'd like us to craft, we're all ears! Simply let us know what you have in mind, and we'll pour our passion into bringing it to life for you.
                        </p>
                    </div>
                </div>

                <!-- Contact Details Grid -->
                <div class="p-12 md:p-16 bg-white space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- WhatsApp Card -->
                        <a href="https://wa.me/917728879509" target="_blank" class="flex flex-col items-center text-center p-6 bg-primary-light/5 hover:bg-primary-light/10 border border-primary-light/10 hover:border-primary/20 rounded-[2rem] transition-all duration-300 transform hover:-translate-y-1 group">
                            <div class="w-14 h-14 bg-[#25D366]/10 text-[#25D366] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                            </div>
                            <h4 class="font-heading text-lg text-primary mb-1">WhatsApp</h4>
                            <p class="font-body text-sm text-soft-gray mb-2">Fastest Response</p>
                            <span class="font-body text-charcoal font-semibold group-hover:text-primary transition-colors text-sm">+91 7728879509</span>
                        </a>

                        <!-- Instagram Card -->
                        <a href="https://www.instagram.com/ashma_creations07" target="_blank" class="flex flex-col items-center text-center p-6 bg-primary-light/5 hover:bg-primary-light/10 border border-primary-light/10 hover:border-primary/20 rounded-[2rem] transition-all duration-300 transform hover:-translate-y-1 group">
                            <div class="w-14 h-14 bg-[#E1306C]/10 text-[#E1306C] rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5C18.87 2 21 4.13 21 6.75v10.5c0 2.62-2.13 4.75-4.75 4.75h-8.5C5.13 22 3 19.87 3 17.25V6.75C3 4.13 5.13 2 7.75 2zm0 1.5c-1.8 0-3.25 1.45-3.25 3.25v10.5c0 1.8 1.45 3.25 3.25 3.25h8.5c1.8 0 3.25-1.45 3.25-3.25V6.75c0-1.8-1.45-3.25-3.25-3.25h-8.5zM12 7c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5zm5.25-.75c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75z"/></svg>
                            </div>
                            <h4 class="font-heading text-lg text-primary mb-1">Instagram</h4>
                            <p class="font-body text-sm text-soft-gray mb-2">Best for Design Photos</p>
                            <span class="font-body text-charcoal font-semibold group-hover:text-primary transition-colors text-sm">@ashma_creations07</span>
                        </a>

                        <!-- Email Card -->
                        <a href="mailto:ashmacreations07@gmail.com" class="flex flex-col items-center text-center p-6 bg-primary-light/5 hover:bg-primary-light/10 border border-primary-light/10 hover:border-primary/20 rounded-[2rem] transition-all duration-300 transform hover:-translate-y-1 group">
                            <div class="w-14 h-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="font-heading text-lg text-primary mb-1">Email Us</h4>
                            <p class="font-body text-sm text-soft-gray mb-2">Direct Queries</p>
                            <span class="font-body text-charcoal font-semibold group-hover:text-primary transition-colors text-xs break-all">ashmacreations07@gmail.com</span>
                        </a>
                    </div>

                    <!-- Personal Note / Request Context -->
                    <div class="border-t border-primary-light/20 pt-10 text-center max-w-2xl mx-auto space-y-6">
                        <p class="text-charcoal font-body leading-relaxed text-base">
                            While crafting premium handmade creations takes time and patience, we make sure to review every single request and get back to you as quickly as we can. We'll collaborate with you directly to select color palettes, approve shapes, and show previews before your order is packaged.
                        </p>
                        <p class="text-charcoal font-body leading-relaxed text-base">
                            Your support and ideas are incredibly important to us. We are constantly looking to create new, whimsical flower designs, custom flower pots, and bespoke gift boxes to make your space feel alive and colorful. 😊
                        </p>
                        <p class="font-heading text-primary text-xl tracking-wide">
                            Thank you for your support, and we can't wait to make something beautiful together! 🌸✨
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
