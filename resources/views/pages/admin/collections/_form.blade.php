<div>
    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required
           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm @error('name') border-red-500 @enderror">
    @error('name')<span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>@enderror
</div>

<div>
    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
    <textarea id="description" name="description" rows="4"
              class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">{{ old('description', $item->description ?? '') }}</textarea>
</div>

<div>
    <label for="banner_image" class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
    @if(!empty($item?->banner_image))
        <div class="mb-3 w-32 h-20 rounded-xl overflow-hidden border border-primary-light/10">
            <img src="{{ asset($item->banner_image) }}" alt="" class="w-full h-full object-cover">
        </div>
    @endif
    <input id="banner_image" type="file" name="banner_image" accept="image/*"
           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
        <input id="display_order" type="number" name="display_order" min="0" value="{{ old('display_order', $item->display_order ?? 0) }}"
               class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">
    </div>
    <div class="flex items-center pt-8">
        <input id="active" type="checkbox" name="active" value="1" {{ old('active', $item->active ?? true) ? 'checked' : '' }}
               class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
        <label for="active" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Active</label>
    </div>
</div>

<div>
    <label for="seo_title" class="block text-sm font-semibold text-gray-700 mb-2">SEO Title</label>
    <input id="seo_title" type="text" name="seo_title" value="{{ old('seo_title', $item->seo_title ?? '') }}"
           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">
</div>

<div>
    <label for="seo_description" class="block text-sm font-semibold text-gray-700 mb-2">SEO Description</label>
    <textarea id="seo_description" name="seo_description" rows="3"
              class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">{{ old('seo_description', $item->seo_description ?? '') }}</textarea>
</div>
