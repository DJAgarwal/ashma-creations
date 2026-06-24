@extends('layouts.admin')

@section('admin_title', 'Create Category')
@section('admin_page_header', 'Create Category')

@section('admin_content')
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold text-primary hover:text-accent transition-colors flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Card -->
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g., Seasonal Wreaths"
                           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Describe this collection..."
                              class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-2">Parent Category</label>
                    <select id="parent_id" name="parent_id" 
                            class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('parent_id') border-red-500 @enderror">
                        <option value="">None (Top-level Category)</option>
                        @foreach ($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Collection Image</label>
                    <input id="image" type="file" name="image" accept="image/*"
                           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('image') border-red-500 @enderror">
                    <p class="text-xs text-soft-gray mt-2">Recommended: Square format, less than 5MB.</p>
                    @error('image')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-accent hover:shadow-accent/20 transition-all duration-300 cursor-pointer">
                        Save Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
                <h4 class="text-base font-bold text-gray-800 mb-4">SEO & Metadata Automation</h4>
                
                <div class="space-y-4 text-sm text-soft-gray leading-relaxed">
                    <div class="flex items-start">
                        <span class="w-2 h-2 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                        <p><strong>Meta Title:</strong> Generated automatically using the category name (e.g., <code>[Name] - Ashma Creations</code>).</p>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="w-2 h-2 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                        <p><strong>Meta Description:</strong> Extracted and truncated from the description input to maintain correct character lengths.</p>
                    </div>

                    <div class="flex items-start">
                        <span class="w-2 h-2 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                        <p><strong>URL Slug:</strong> Formatted dynamically from the name (e.g., <code>seasonal-wreaths</code>) and checked for uniqueness.</p>
                    </div>

                    <div class="flex items-start">
                        <span class="w-2 h-2 rounded-full bg-primary mt-2 mr-3 flex-shrink-0"></span>
                        <p><strong>JSON-LD Breadcrumbs:</strong> Injected dynamically at runtime, adjusting to parent-child category relationships instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
