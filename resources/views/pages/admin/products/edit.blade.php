@extends('layouts.admin')

@section('admin_title', 'Edit Product')
@section('admin_page_header', 'Edit Product')

@section('admin_content')
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-primary hover:text-accent transition-colors flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Card -->
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
            <form method="POST" action="{{ route('admin.products.update', $product->slug) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required placeholder="e.g., Spring Tulip Bouquet"
                           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Describe the product..."
                              class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Details / Specifications -->
                <div>
                    <label for="details" class="block text-sm font-semibold text-gray-700 mb-2">Additional Details / Specifications</label>
                    <textarea id="details" name="details" rows="4" placeholder="e.g., Height: approx. 35cm&#10;Materials: premium soft pipe cleaners&#10;Includes decorative wrapping and a ribbon."
                              class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('details') border-red-500 @enderror">{{ old('details', $product->details) }}</textarea>
                    <p class="text-xs text-soft-gray mt-2">Enter each detail or bullet point on a new line.</p>
                    @error('details')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('category_id') border-red-500 @enderror">
                        <option value="">Select a Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->parent ? $cat->parent->name . ' > ' : '' }}{{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Current Images Preview -->
                @if($product->images && count($product->images) > 0)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Images</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach($product->images as $img)
                                <div class="relative w-20 h-20 rounded-xl overflow-hidden bg-background border border-primary-light/10 group/img">
                                    <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload Images -->
                <div>
                    <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">Replace Images (Optional)</label>
                    <input id="images" type="file" name="images[]" multiple accept="image/*"
                           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                    <p class="text-xs text-soft-gray mt-2">Uploading new images will replace existing ones. You can upload multiple files.</p>
                    @error('images')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                    @error('images.*')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Featured Switch -->
                <div class="flex items-center">
                    <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20 focus:outline-none">
                    <label for="is_featured" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Feature this product on homepage</label>
                    @error('is_featured')
                        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-accent hover:shadow-accent/20 transition-all duration-300 cursor-pointer">
                        Update Product
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Sidebar -->
        <div class="space-y-6">
            <!-- Details Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
                <h4 class="text-base font-bold text-gray-800 mb-4">Product Details</h4>
                <div class="space-y-3 text-sm text-gray-600">
                    <p><strong>Created At:</strong> {{ $product->created_at->format('M j, Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $product->updated_at->format('M j, Y H:i') }}</p>
                    <p><strong>URL Slug:</strong> <code class="bg-background px-2 py-1 rounded text-xs select-all">{{ $product->slug }}</code></p>
                </div>
            </div>

            <!-- SEO Card -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
                <h4 class="text-base font-bold text-gray-800 mb-4">SEO Metadata Information</h4>
                <div class="space-y-3 text-xs text-soft-gray leading-relaxed">
                    <p><strong>Meta Title:</strong> <span class="text-gray-700">{{ $product->meta_title }}</span></p>
                    <p><strong>Meta Description:</strong> <span class="text-gray-700">{{ $product->meta_description }}</span></p>
                    <p class="text-xxs italic mt-2 border-t border-primary-light/10 pt-2">Changing the product name automatically regenerates the URL slug, page meta titles, and descriptions dynamically during update.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
