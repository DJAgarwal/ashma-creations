<div>
    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required
           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm @error('name') border-red-500 @enderror">
    @error('name')<span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>@enderror
</div>

@if(!empty($config['fields']['icon']))
    <div>
        <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">Icon (emoji or class)</label>
        <input id="icon" type="text" name="icon" value="{{ old('icon', $item->icon ?? '') }}" placeholder="🎂"
               class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">
    </div>
@endif

@if(!empty($config['fields']['image']))
    <div>
        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
            {{ $config['label_singular'] ?? $config['label'] }} Image
            @if(!$item || empty($item->image_path))
                <span class="text-red-500">*</span>
            @endif
        </label>
        @if(!empty($item?->image_path))
            <div class="mb-3 flex items-center gap-4">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-20 h-24 object-cover rounded-xl border border-primary-light/30 shadow-sm" />
                <span class="text-xs text-soft-gray">Current image</span>
            </div>
        @endif
        <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp"
               {{ (!$item || empty($item->image_path)) ? 'required' : '' }}
               class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm @error('image') border-red-500 @enderror">
        <p class="text-xs text-soft-gray mt-2">Recommended: 1000 × 1200 px (5:6 aspect ratio). Supports JPG, PNG, WebP (auto-converted to WebP).</p>
        @error('image')
            <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
        @enderror
    </div>
@endif

<div>
    <label for="display_order" class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
    <input id="display_order" type="number" name="display_order" min="0" value="{{ old('display_order', $item->display_order ?? 0) }}"
           class="w-full px-5 py-4 bg-background/50 border border-primary-light/20 rounded-2xl text-sm">
</div>

<div class="flex items-center">
    <input id="active" type="checkbox" name="active" value="1" {{ old('active', $item->active ?? true) ? 'checked' : '' }}
           class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
    <label for="active" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">Active</label>
</div>

@if($item)
    <p class="text-xs text-soft-gray">Slug: <code class="bg-background px-2 py-1 rounded">{{ $item->slug }}</code> (auto-generated from name)</p>
@endif
