@extends('layouts.app')

@section('title', 'All Collections')

@section('content')
    <div class="bg-background py-16">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-5xl font-heading text-primary mb-4">Our Collections</h1>
                <p class="text-soft-gray font-body text-lg max-w-2xl mx-auto">
                    Explore our diverse range of handcrafted pipe cleaner creations. Each category is a world of its own, filled with unique pieces made with love.
                </p>
                <div class="w-24 h-1 bg-primary-light mx-auto mt-8 rounded-full"></div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($categories as $category)
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="aspect-[4/3] bg-primary-light/10 relative overflow-hidden">
                        @if($category->image_path)
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-primary-light/40 group-hover:scale-110 transition-transform duration-700">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm-1-12h2v2h-2zm0 4h2v6h-2z"/></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <a href="{{ route('categories.show', $category->slug) }}" class="px-8 py-3 bg-white text-primary font-body font-bold rounded-full transform scale-90 group-hover:scale-100 transition-transform">
                                Explore
                            </a>
                        </div>
                    </div>
                    <div class="p-10 text-center">
                        <h3 class="text-3xl font-heading text-primary mb-4">{{ $category->name }}</h3>
                        <p class="text-soft-gray font-body leading-relaxed mb-8">{{ $category->description }}</p>
                        
                        @if($category->children->count() > 0)
                            <div class="flex flex-wrap justify-center gap-2 mb-8">
                                @foreach($category->children as $child)
                                    <a href="{{ route('categories.show', $child->slug) }}" class="px-4 py-1.5 bg-background text-primary-light hover:bg-primary-light/20 text-xs font-bold font-body rounded-full transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('categories.show', $category->slug) }}" class="font-body font-bold text-primary group-hover:text-accent flex items-center justify-center gap-2">
                            View All Items
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
