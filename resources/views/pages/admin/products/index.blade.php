@extends('layouts.admin')

@section('admin_title', 'Products')
@section('admin_page_header', 'Manage Products')

@section('admin_content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h3 class="text-lg font-bold text-gray-800">All Products</h3>
            <p class="text-sm text-soft-gray">Add, edit, or delete handcrafted products for your shop.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-md hover:bg-accent hover:shadow-lg transition-all text-sm flex items-center cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Product
        </a>
    </div>

    <!-- Filter Bar -->
    <x-admin.filter-bar :filters="$filters">
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Category</label>
            <select name="category_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Collection</label>
            <select name="collection_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Collections</option>
                @foreach ($collections as $col)
                    <option value="{{ $col->id }}" {{ ($filters['collection_id'] ?? '') == $col->id ? 'selected' : '' }}>
                        {{ $col->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Occasion</label>
            <select name="occasion_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Occasions</option>
                @foreach ($occasions as $occ)
                    <option value="{{ $occ->id }}" {{ ($filters['occasion_id'] ?? '') == $occ->id ? 'selected' : '' }}>
                        {{ $occ->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Recipient</label>
            <select name="recipient_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Recipients</option>
                @foreach ($recipients as $rec)
                    <option value="{{ $rec->id }}" {{ ($filters['recipient_id'] ?? '') == $rec->id ? 'selected' : '' }}>
                        {{ $rec->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Style</label>
            <select name="style_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Styles</option>
                @foreach ($styles as $st)
                    <option value="{{ $st->id }}" {{ ($filters['style_id'] ?? '') == $st->id ? 'selected' : '' }}>
                        {{ $st->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Material</label>
            <select name="material_id" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All Materials</option>
                @foreach ($materials as $mat)
                    <option value="{{ $mat->id }}" {{ ($filters['material_id'] ?? '') == $mat->id ? 'selected' : '' }}>
                        {{ $mat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2 xl:col-span-4 grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                <input type="checkbox" name="is_featured" value="1" {{ ($filters['is_featured'] ?? '') ? 'checked' : '' }}
                       class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
                <span>Featured</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                <input type="checkbox" name="is_best_seller" value="1" {{ ($filters['is_best_seller'] ?? '') ? 'checked' : '' }}
                       class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
                <span>Best Seller</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                <input type="checkbox" name="is_new_arrival" value="1" {{ ($filters['is_new_arrival'] ?? '') ? 'checked' : '' }}
                       class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
                <span>New Arrival</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                <input type="checkbox" name="is_trending" value="1" {{ ($filters['is_trending'] ?? '') ? 'checked' : '' }}
                       class="w-4 h-4 text-primary bg-background border-primary-light/20 rounded focus:ring-primary/20">
                <span>Trending</span>
            </label>
        </div>
    </x-admin.filter-bar>

    <!-- Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-primary-light/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-primary-light/10 text-left">
                <thead class="bg-background/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Image</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Primary Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Collections Count</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider min-w-[220px]">Occasions</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider min-w-[220px]">Recipients</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Best Seller</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-light/10">
                    @forelse ($products as $prod)
                        <tr class="hover:bg-background/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-background border border-primary-light/10 flex items-center justify-center text-primary-light">
                                    @if ($prod->images && count($prod->images) > 0)
                                        <img src="{{ asset($prod->images[0]) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800">{{ $prod->name }}</div>
                                <div class="text-xs text-gray-600 font-mono select-all mb-1">{{ $prod->slug }}</div>
                                @if ($prod->description)
                                    <div class="text-xs text-soft-gray line-clamp-1 max-w-sm" title="{{ $prod->description }}">{{ Str::limit($prod->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($prod->primaryCategory)
                                    <span class="px-2.5 py-1 bg-background text-primary text-xs font-semibold rounded-full border border-primary-light/10">
                                        {{ $prod->primaryCategory->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                {{ $prod->collections_count }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 min-w-[220px]">
                                {{ $prod->occasions->isNotEmpty() ? $prod->occasions->pluck('name')->implode(', ') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 min-w-[220px]">
                                {{ $prod->recipients->isNotEmpty() ? $prod->recipients->pluck('name')->implode(', ') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-100 shadow-sm flex items-center w-max">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($prod->is_featured)
                                    <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-100 shadow-sm flex items-center w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($prod->is_best_seller)
                                    <span class="px-2.5 py-1 bg-yellow-50 text-yellow-700 text-xs font-semibold rounded-full border border-yellow-100 shadow-sm flex items-center w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span>
                                        Best Seller
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $prod->slug) }}" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.products.destroy', $prod->slug) }}" class="js-confirm-delete" data-confirm="Are you sure you want to delete this product?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-soft-gray text-sm">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                No products found. Click "Create Product" to add one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
