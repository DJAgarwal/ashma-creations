<!-- Primary Category -->
<div>
    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Primary Category <span class="text-red-500">*</span></label>
    <select id="category_id" name="category_id" required
            class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm @error('category_id') border-red-500 @enderror">
        <option value="">Select primary category</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->parent ? $cat->parent->name . ' > ' : '' }}{{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
    @enderror
</div>

<x-admin.multi-select name="collection_ids" label="Collections" :options="$collections" :selected="old('collection_ids', isset($product) ? $product->collections->pluck('id')->all() : [])" />
<x-admin.multi-select name="occasion_ids" label="Occasions" :options="$occasions" :selected="old('occasion_ids', isset($product) ? $product->occasions->pluck('id')->all() : [])" />
<x-admin.multi-select name="recipient_ids" label="Recipients" :options="$recipients" :selected="old('recipient_ids', isset($product) ? $product->recipients->pluck('id')->all() : [])" />
<x-admin.multi-select name="style_ids" label="Styles" :options="$styles" :selected="old('style_ids', isset($product) ? $product->styles->pluck('id')->all() : [])" />
<x-admin.multi-select name="material_ids" label="Materials" :options="$materials" :selected="old('material_ids', isset($product) ? $product->materials->pluck('id')->all() : [])" />

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
    <div class="flex items-center">
        <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
               class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
        <label for="is_featured" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Featured Product</label>
    </div>
    <div class="flex items-center">
        <input id="is_best_seller" type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller ?? false) ? 'checked' : '' }}
               class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
        <label for="is_best_seller" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Best Seller</label>
    </div>
    <div class="flex items-center">
        <input id="is_new_arrival" type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival ?? false) ? 'checked' : '' }}
               class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
        <label for="is_new_arrival" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">New Arrival</label>
    </div>
    <div class="flex items-center">
        <input id="is_trending" type="checkbox" name="is_trending" value="1" {{ old('is_trending', $product->is_trending ?? false) ? 'checked' : '' }}
               class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
        <label for="is_trending" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Trending</label>
    </div>
</div>
