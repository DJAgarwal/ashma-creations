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
