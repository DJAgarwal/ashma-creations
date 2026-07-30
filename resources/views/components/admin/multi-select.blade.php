@props([
    'name',
    'label',
    'options' => [],
    'selected' => [],
    'required' => false,
])

@php
    $selected = old($name, $selected);
    if (!is_array($selected)) {
        $selected = $selected ? [$selected] : [];
    }
@endphp

<div class="admin-multi-select" data-multi-select>
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>

    <input type="search"
           placeholder="Search {{ strtolower($label) }}..."
           class="w-full mb-2 px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
           data-multi-select-search>

    <div class="max-h-48 overflow-y-auto border border-primary-light/20 rounded-2xl bg-background/30 p-3 space-y-2" data-multi-select-list>
        @forelse($options as $option)
            @php
                $optionId = is_object($option) ? $option->id : ($option['id'] ?? null);
                $optionLabel = is_object($option) ? $option->name : ($option['label'] ?? '');
                $optionGroup = is_object($option) && $option->parent ? $option->parent->name . ' > ' : '';
            @endphp
            <label class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white cursor-pointer text-sm text-gray-700" data-multi-select-item="{{ strtolower($optionGroup . $optionLabel) }}">
                <input type="checkbox"
                       name="{{ $name }}[]"
                       value="{{ $optionId }}"
                       {{ in_array($optionId, $selected) ? 'checked' : '' }}
                       class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
                <span>{{ $optionGroup }}{{ $optionLabel }}</span>
            </label>
        @empty
            <p class="text-xs text-soft-gray px-3 py-2">No options available yet.</p>
        @endforelse
    </div>

    @error($name)
        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
    @enderror
    @error($name . '.*')
        <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
    @enderror
</div>

@once
    @push('admin_scripts')
        <script nonce="{{ $cspNonce ?? '' }}">
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-multi-select]').forEach(function (wrapper) {
                    const search = wrapper.querySelector('[data-multi-select-search]');
                    const items = wrapper.querySelectorAll('[data-multi-select-item]');

                    if (!search) return;

                    search.addEventListener('input', function () {
                        const query = this.value.trim().toLowerCase();
                        items.forEach(function (item) {
                            const label = item.getAttribute('data-multi-select-item') || '';
                            item.classList.toggle('hidden', query !== '' && !label.includes(query));
                        });
                    });
                });
            });
        </script>
    @endpush
@endonce
