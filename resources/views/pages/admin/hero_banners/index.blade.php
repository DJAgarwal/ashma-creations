@extends('layouts.admin')

@section('admin_title', 'Banners')
@section('admin_page_header', 'Manage Banners')

@section('admin_content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-bold text-gray-800">All Banners</h3>
            <p class="text-sm text-soft-gray">Manage homepage promotional banners and slide images independently.</p>
        </div>
        <a href="{{ route('admin.homepage.hero-banners.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-md hover:bg-accent hover:shadow-lg transition-all text-sm flex items-center cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Banner
        </a>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white p-4 md:p-6 rounded-[2rem] shadow-sm border border-primary-light/10 mb-6">
        <form method="GET" action="{{ route('admin.homepage.hero-banners.index') }}" class="flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto flex-grow">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search banners..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Status Select Filter -->
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-48 px-4 py-2.5 bg-background border border-primary-light/20 rounded-xl text-sm focus:outline-none focus:border-primary text-gray-800 cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>Trashed (Soft Deleted)</option>
                </select>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.homepage.hero-banners.index') }}" class="px-4 py-2.5 text-xs font-semibold text-gray-600 hover:text-primary transition-colors">
                        Reset Filters
                    </a>
                @endif
                <button type="submit" class="px-5 py-2.5 bg-primary/10 text-primary hover:bg-primary hover:text-white font-bold rounded-xl transition-all text-xs cursor-pointer">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Banners Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-primary-light/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-primary-light/10 text-left">
                <thead class="bg-background/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Image Preview</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Destination Link</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-center">Display Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Created Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-light/10">
                    @forelse ($banners as $banner)
                        <tr class="hover:bg-background/20 transition-colors {{ $banner->trashed() ? 'bg-red-50/40' : '' }}">
                            <!-- Thumbnail Image Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative w-24 h-12 rounded-xl overflow-hidden bg-background border border-primary-light/10 shadow-sm" title="Desktop Banner">
                                        @if ($banner->desktop_image)
                                            <img src="{{ asset($banner->desktop_image) }}" alt="Desktop Banner for Handmade Gifts" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                                        @endif
                                    </div>
                                    @if ($banner->mobile_image)
                                        <div class="relative w-8 h-12 rounded-lg overflow-hidden bg-background border border-primary-light/10 shadow-sm hidden sm:block" title="Mobile Banner Uploaded">
                                            <img src="{{ asset($banner->mobile_image) }}" alt="Mobile Banner for Handmade Gifts" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Link Type & Destination Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="px-3 py-1 bg-primary-light/15 text-primary text-xs font-semibold rounded-full">
                                        {{ $banner->link_type }}
                                    </span>
                                    <span class="text-xs text-gray-600 font-medium truncate max-w-xs" title="{{ $banner->destination_label }}">
                                        {{ $banner->destination_label }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if ($banner->trashed())
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            Trashed
                                        </span>
                                    @elseif ($banner->active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Display Order Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-700">
                                <span class="w-8 h-8 rounded-full bg-background inline-flex items-center justify-center border border-primary-light/20">
                                    {{ $banner->display_order }}
                                </span>
                            </td>

                            <!-- Created Date Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $banner->created_at ? $banner->created_at->format('M j, Y') : 'N/A' }}
                            </td>

                            <!-- Actions Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($banner->trashed())
                                        <form method="POST" action="{{ route('admin.homepage.hero-banners.restore', $banner->id) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-100 rounded-xl text-xs font-bold transition-all cursor-pointer">
                                                Restore
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.homepage.hero-banners.destroy', $banner->id) }}" class="js-confirm-delete" data-confirm="Permanently delete this banner and remove its image files?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer" title="Permanently Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.homepage.hero-banners.edit', $banner->id) }}" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all" title="Edit Banner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.homepage.hero-banners.destroy', $banner->id) }}" class="js-confirm-delete" data-confirm="Are you sure you want to soft delete this banner?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer" title="Soft Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-soft-gray text-sm">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                                </svg>
                                No banners found. Click "Add New Banner" to add one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($banners->hasPages())
            <div class="px-6 py-4 border-t border-primary-light/10">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
@endsection
