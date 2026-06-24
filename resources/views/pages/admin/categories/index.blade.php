@extends('layouts.admin')

@section('admin_title', 'Categories')
@section('admin_page_header', 'Manage Categories')

@section('admin_content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h3 class="text-lg font-bold text-gray-800">All Collections</h3>
            <p class="text-sm text-soft-gray">Add, edit, or delete categories for your shop.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-md hover:bg-accent hover:shadow-lg transition-all text-sm flex items-center cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-primary-light/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-primary-light/10 text-left">
                <thead class="bg-background/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Image</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-light/10">
                    @forelse ($categories as $cat)
                        <tr class="hover:bg-background/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-background border border-primary-light/10 flex items-center justify-center text-primary-light">
                                    @if ($cat->image_path)
                                        <img src="{{ asset($cat->image_path) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                                        </svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800">{{ $cat->name }}</div>
                                @if ($cat->description)
                                    <div class="text-xs text-soft-gray truncate max-w-xs" title="{{ $cat->description }}">{{ Str::limit($cat->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                {{ $cat->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($cat->parent)
                                    <span class="px-2.5 py-1 bg-background text-primary-light text-xs font-semibold rounded-full">
                                        {{ $cat->parent->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">None (Top-level)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $cat->slug) }}" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat->slug) }}" class="js-confirm-delete" data-confirm="Are you sure you want to delete this category? Subcategories and products inside it will be permanently deleted.">
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
                            <td colspan="5" class="px-6 py-12 text-center text-soft-gray text-sm">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18"></path>
                                </svg>
                                No categories found. Click "Create Category" to add one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
