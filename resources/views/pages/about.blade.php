@extends('layouts.app')

@section('title', 'Our Story')

@section('content')
    <div class="bg-background min-h-screen">
        <section class="relative py-12 bg-white overflow-hidden">
            <div class="absolute top-0 right-0 w-1/4 h-full bg-primary-light/5 -skew-x-12 transform origin-top-right"></div>
            <div class="container mx-auto px-4 relative z-10">
                <!-- Breadcrumbs -->
                <nav class="flex text-sm font-body text-soft-gray mb-8 justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-primary-light mx-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                <span class="text-primary font-bold">Our Story</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="text-center">
                    <h4 class="text-accent font-body font-bold uppercase tracking-widest mb-4">Handmade With Love</h4>
                    <h1 class="text-5xl md:text-7xl font-heading text-primary mb-8">The Heart Behind <br>Ashma Creations</h1>
                    <div class="w-24 h-1 bg-primary-light mx-auto rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Story Content -->
        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="flex flex-col md:flex-row items-center gap-16 mb-24">
                        <div class="md:w-1/2">
                            <h2 class="text-4xl font-heading text-primary mb-6">A Passion for Craft</h2>
                            <p class="text-lg text-soft-gray font-body leading-relaxed mb-6">
                                Ashma Creations is a labor of love, founded on the belief that beauty can be found in the simplest of materials. It all began in a small home studio, where a single pipe cleaner and a spark of imagination turned into a delicate rose that would never wilt.
                            </p>
                            <p class="text-lg text-soft-gray font-body leading-relaxed">
                                Our founder (my wife) has always had a keen eye for detail and a heart for handmade art. Every bouquet and flower pot in our collection is a testament to her patience, skill, and the joy she finds in creating something special for others.
                            </p>
                        </div>
                        <div class="md:w-1/2">
                            <div class="bg-white p-4 rounded-[3rem] shadow-xl rotate-3">
                                <div class="aspect-square bg-primary-light/20 rounded-[2.5rem] flex items-center justify-center">
                                    <svg class="w-32 h-32 text-primary/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-16 h-16 bg-primary-light/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            </div>
                            <h3 class="text-2xl font-heading text-primary mb-4">Uniquely Yours</h3>
                            <p class="text-soft-gray font-body text-sm leading-relaxed">No two pieces are exactly alike. Each creation carries its own subtle charm and character.</p>
                        </div>
                        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-heading text-primary mb-4">Eternal Beauty</h3>
                            <p class="text-soft-gray font-body text-sm leading-relaxed">Handmade pipe cleaner flowers stay vibrant and beautiful forever, just like the memories they celebrate.</p>
                        </div>
                        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-16 h-16 bg-accent/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-heading text-primary mb-4">Custom Orders</h3>
                            <p class="text-soft-gray font-body text-sm leading-relaxed">We love bringing your specific visions to life. Tell us your favorite colors or ideas, and we'll craft it for you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
