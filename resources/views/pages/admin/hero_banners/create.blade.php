@extends('layouts.admin')

@section('admin_title', 'Add New Banner')
@section('admin_page_header', 'Add New Banner')

@section('admin_content')
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.homepage.hero-banners.index') }}" class="inline-flex items-center text-xs font-semibold text-soft-gray hover:text-primary transition-colors mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Banners
                </a>
                <h3 class="text-2xl font-bold text-gray-800">Add New Banner</h3>
            </div>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-red-50 text-red-700 text-sm rounded-2xl border border-red-100 shadow-sm">
                <p class="font-bold mb-2">Please fix the following validation errors:</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.homepage.hero-banners.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Banner Images -->
            <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-sm border border-primary-light/10 space-y-6">
                <h4 class="text-lg font-bold text-gray-800 pb-3 border-b border-primary-light/10 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Banner Images
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Desktop Banner File Input -->
                    <div>
                        <label for="desktop_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Desktop Image <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-soft-gray mb-3">Recommended dimensions: <strong>1920 × 700 px</strong> (WebP optimized)</p>
                        <input type="file" id="desktop_image" name="desktop_image" accept="image/*" required
                               class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary hover:file:text-white cursor-pointer transition-all">
                        
                        <!-- Desktop Preview -->
                        <div class="mt-4 border border-dashed border-primary-light/30 rounded-2xl p-2 bg-background flex items-center justify-center min-h-[140px]">
                            <img id="desktop-preview" src="#" alt="Desktop Preview" class="max-h-40 w-full object-cover rounded-xl hidden">
                            <span id="desktop-placeholder" class="text-xs text-soft-gray">No desktop image selected</span>
                        </div>
                    </div>

                    <!-- Mobile Banner File Input -->
                    <div>
                        <label for="mobile_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Mobile Image (Optional)
                        </label>
                        <p class="text-xs text-soft-gray mb-3">Recommended dimensions: <strong>800 × 1000 px</strong> (WebP optimized)</p>
                        <input type="file" id="mobile_image" name="mobile_image" accept="image/*"
                               class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary hover:file:text-white cursor-pointer transition-all">
                        
                        <!-- Mobile Preview -->
                        <div class="mt-4 border border-dashed border-primary-light/30 rounded-2xl p-2 bg-background flex items-center justify-center min-h-[140px]">
                            <img id="mobile-preview" src="#" alt="Mobile Preview" class="max-h-40 object-contain rounded-xl hidden">
                            <span id="mobile-placeholder" class="text-xs text-soft-gray text-center">No mobile image selected<br>(desktop image will be used)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Destination Link -->
            <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-sm border border-primary-light/10 space-y-6">
                <h4 class="text-lg font-bold text-gray-800 pb-3 border-b border-primary-light/10 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    Destination Link (On Click)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Link Type -->
                    <div>
                        <label for="link_type" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Link Type <span class="text-red-500">*</span>
                        </label>
                        <select id="link_type" name="link_type" class="w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                            @foreach (['Category', 'Collection', 'Occasion', 'Recipient', 'Product', 'Page', 'Custom URL'] as $type)
                                <option value="{{ $type }}" {{ old('link_type', 'Category') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Target Selection Containers -->
                    <div>
                        <!-- Category Select -->
                        <div id="target-Category" class="target-container">
                            <label for="link_id_category" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Category
                            </label>
                            <select id="link_id_category" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Category --</option>
                                @foreach ($destinations['categories'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->slug }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Collection Select -->
                        <div id="target-Collection" class="target-container hidden">
                            <label for="link_id_collection" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Collection
                            </label>
                            <select id="link_id_collection" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Collection --</option>
                                @foreach ($destinations['collections'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->slug }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Occasion Select -->
                        <div id="target-Occasion" class="target-container hidden">
                            <label for="link_id_occasion" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Occasion
                            </label>
                            <select id="link_id_occasion" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Occasion --</option>
                                @foreach ($destinations['occasions'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->slug }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Recipient Select -->
                        <div id="target-Recipient" class="target-container hidden">
                            <label for="link_id_recipient" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Recipient
                            </label>
                            <select id="link_id_recipient" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Recipient --</option>
                                @foreach ($destinations['recipients'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->slug }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Select -->
                        <div id="target-Product" class="target-container hidden">
                            <label for="link_id_product" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Product
                            </label>
                            <select id="link_id_product" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Product --</option>
                                @foreach ($destinations['products'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} ({{ $item->slug }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Page Select -->
                        <div id="target-Page" class="target-container hidden">
                            <label for="link_id_page" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Select Page
                            </label>
                            <select id="link_id_page" class="link-id-input w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                                <option value="">-- Choose Page --</option>
                                @foreach ($destinations['pages'] as $item)
                                    <option value="{{ $item->id }}" {{ old('link_id') == $item->id ? 'selected' : '' }}>
                                        {{ ucfirst($item->page_name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Custom URL Textbox -->
                        <div id="target-CustomURL" class="target-container hidden">
                            <label for="custom_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Custom URL
                            </label>
                            <input type="text" id="custom_url" name="custom_url" value="{{ old('custom_url') }}" 
                                   placeholder="e.g. /products or https://example.com/promo"
                                   class="w-full px-4 py-3 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800">
                        </div>

                        <!-- Hidden Field to submit link_id -->
                        <input type="hidden" id="final_link_id" name="link_id" value="{{ old('link_id') }}">
                    </div>
                </div>
            </div>

            <!-- Section 3: Visibility & Display Order -->
            <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-sm border border-primary-light/10 space-y-6">
                <h4 class="text-lg font-bold text-gray-800 pb-3 border-b border-primary-light/10 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Visibility & Display Order
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <!-- Active Toggle -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Banner Status
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700">Active</span>
                        </label>
                    </div>

                    <!-- Display Order -->
                    <div>
                        <label for="display_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Display Order
                        </label>
                        <input type="number" id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0" 
                               class="w-full px-4 py-2.5 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800">
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.homepage.hero-banners.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 hover:bg-gray-200 font-bold rounded-2xl text-sm transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-2xl shadow-lg hover:bg-accent hover:shadow-xl transition-all text-sm cursor-pointer">
                    Save Banner
                </button>
            </div>
        </form>
    </div>
@endsection

@push('admin_scripts')
    <script nonce="{{ $cspNonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function () {
            // Destination Link Type Switcher logic
            const linkTypeSelect = document.getElementById('link_type');
            const targetContainers = document.querySelectorAll('.target-container');
            const finalLinkId = document.getElementById('final_link_id');

            function updateTargetVisibility() {
                const selectedType = linkTypeSelect.value.replace(/\s+/g, '');
                targetContainers.forEach(container => {
                    if (container.id === 'target-' + selectedType) {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                });
                syncLinkId();
            }

            function syncLinkId() {
                const selectedType = linkTypeSelect.value.replace(/\s+/g, '');
                const currentContainer = document.getElementById('target-' + selectedType);
                if (currentContainer) {
                    const activeSelect = currentContainer.querySelector('.link-id-input');
                    if (activeSelect) {
                        finalLinkId.value = activeSelect.value;
                    } else {
                        finalLinkId.value = '';
                    }
                }
            }

            linkTypeSelect.addEventListener('change', updateTargetVisibility);
            document.querySelectorAll('.link-id-input').forEach(select => {
                select.addEventListener('change', syncLinkId);
            });
            updateTargetVisibility();

            // Image Preview Handlers
            const desktopInput = document.getElementById('desktop_image');
            const desktopPreview = document.getElementById('desktop-preview');
            const desktopPlaceholder = document.getElementById('desktop-placeholder');

            desktopInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        desktopPreview.src = e.target.result;
                        desktopPreview.classList.remove('hidden');
                        desktopPlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            const mobileInput = document.getElementById('mobile_image');
            const mobilePreview = document.getElementById('mobile-preview');
            const mobilePlaceholder = document.getElementById('mobile-placeholder');

            mobileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        mobilePreview.src = e.target.result;
                        mobilePreview.classList.remove('hidden');
                        mobilePlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
