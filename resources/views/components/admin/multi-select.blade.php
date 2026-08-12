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
    <div class="flex items-center justify-between mb-2">
        <label for="{{ $name }}" class="text-sm font-semibold text-gray-700">
            {{ $label }}
            @if($required)<span class="text-red-500">*</span>@endif
        </label>
        @if(count($options) > 0)
            <button type="button" 
                    class="text-xs font-semibold text-primary hover:text-accent transition-colors flex items-center gap-1 px-2.5 py-1 bg-primary-light/15 hover:bg-primary-light/30 rounded-lg cursor-pointer select-none"
                    data-multi-select-toggle>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span data-multi-select-toggle-text>Select All</span>
            </button>
        @endif
    </div>

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
                    const toggleBtn = wrapper.querySelector('[data-multi-select-toggle]');
                    const toggleText = wrapper.querySelector('[data-multi-select-toggle-text]');

                    function getVisibleCheckboxes() {
                        const visibleItems = Array.from(items).filter(item => !item.classList.contains('hidden'));
                        return visibleItems.map(item => item.querySelector('input[type="checkbox"]')).filter(Boolean);
                    }

                    function updateToggleText() {
                        if (!toggleText) return;
                        const checkboxes = getVisibleCheckboxes();
                        if (checkboxes.length === 0) {
                            toggleText.textContent = 'Select All';
                            return;
                        }
                        const allChecked = checkboxes.every(cb => cb.checked);
                        toggleText.textContent = allChecked ? 'Deselect All' : 'Select All';
                    }

                    if (toggleBtn) {
                        toggleBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            const checkboxes = getVisibleCheckboxes();
                            if (checkboxes.length === 0) return;

                            const allChecked = checkboxes.every(cb => cb.checked);
                            const targetState = !allChecked;

                            checkboxes.forEach(cb => {
                                cb.checked = targetState;
                                cb.dispatchEvent(new Event('change', { bubbles: true }));
                            });

                            updateToggleText();
                        });
                    }

                    wrapper.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                        cb.addEventListener('change', updateToggleText);
                    });

                    if (search) {
                        search.addEventListener('input', function () {
                            const query = this.value.trim().toLowerCase();
                            items.forEach(function (item) {
                                const label = item.getAttribute('data-multi-select-item') || '';
                                item.classList.toggle('hidden', query !== '' && !label.includes(query));
                            });
                            updateToggleText();
                        });
                    }

                    updateToggleText();
                });
            });
        </script>
    @endpush
@endonce

