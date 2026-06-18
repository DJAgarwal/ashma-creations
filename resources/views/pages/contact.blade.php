@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="bg-background min-h-screen py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row">
                <!-- Contact Info Side -->
                <div class="lg:w-2/5 bg-primary p-12 md:p-16 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
                    <div class="relative z-10">
                        <h1 class="text-5xl font-heading mb-8">Get in Touch</h1>
                        <p class="text-white/80 font-body text-lg mb-12 leading-relaxed">
                            Have a question about our products or want to request a custom creation? We'd love to hear from you!
                        </p>

                        <div class="space-y-10">
                            <div class="flex items-start gap-6">
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-heading text-xl mb-1">Email Us</h4>
                                    <p class="font-body text-white/70">hello@ashmacreations.com</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.284l-.533 1.945 1.99-.522c.961.524 2.033.8 3.135.8 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.811-5.766zm3.374 8.203c-.147.412-.752.748-1.033.796-.282.048-.564.072-1.636-.375-1.21-.502-1.966-1.73-2.025-1.812-.06-.082-.486-.644-.486-1.229 0-.584.306-.871.415-.99.11-.119.239-.148.318-.148.079 0 .159 0 .228.004.074.003.174-.028.272.209.1.242.342.833.372.893.03.06.05.128.01.209-.04.082-.06.129-.119.209-.06.079-.125.176-.178.236-.059.066-.122.138-.053.257.069.119.307.507.659.82.454.404.836.53 0.954.59.119.06.189.05.257-.028.069-.079.298-.348.377-.467.079-.119.158-.1.267-.06.11.04 1.144.538 1.144.538.03.01.05.025.07.054.02.03.02.132-.127.54z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-heading text-xl mb-1">WhatsApp</h4>
                                    <p class="font-body text-white/70">+123 456 7890</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-6">
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5C18.87 2 21 4.13 21 6.75v10.5c0 2.62-2.13 4.75-4.75 4.75h-8.5C5.13 22 3 19.87 3 17.25V6.75C3 4.13 5.13 2 7.75 2zm0 1.5c-1.8 0-3.25 1.45-3.25 3.25v10.5c0 1.8 1.45 3.25 3.25 3.25h8.5c1.8 0 3.25-1.45 3.25-3.25V6.75c0-1.8-1.45-3.25-3.25-3.25h-8.5zM12 7c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5zm5.25-.75c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-heading text-xl mb-1">Instagram</h4>
                                    <p class="font-body text-white/70">@ashmacreations</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Side -->
                <div class="lg:w-3/5 p-12 md:p-16 bg-white">
                    <form class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-sm font-body font-bold text-soft-gray uppercase tracking-widest">Your Name</label>
                                <input type="text" class="w-full px-6 py-4 bg-background border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-2xl transition-all font-body text-charcoal outline-none" placeholder="John Doe">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-body font-bold text-soft-gray uppercase tracking-widest">Email Address</label>
                                <input type="email" class="w-full px-6 py-4 bg-background border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-2xl transition-all font-body text-charcoal outline-none" placeholder="john@example.com">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-body font-bold text-soft-gray uppercase tracking-widest">Subject</label>
                            <input type="text" value="{{ request()->query('product') ? 'Inquiry: ' . Str::headline(request()->query('product')) : '' }}" class="w-full px-6 py-4 bg-background border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-2xl transition-all font-body text-charcoal outline-none" placeholder="How can we help?">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-body font-bold text-soft-gray uppercase tracking-widest">Message</label>
                            <textarea rows="5" class="w-full px-6 py-4 bg-background border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-2xl transition-all font-body text-charcoal outline-none resize-none" placeholder="Tell us about your custom request or question..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-5 bg-primary text-white font-body font-bold rounded-2xl hover:bg-accent transition-all shadow-lg transform hover:-translate-y-1">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
