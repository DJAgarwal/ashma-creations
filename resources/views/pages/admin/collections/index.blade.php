@extends('layouts.admin')

@section('admin_title', 'Collections')
@section('admin_page_header', 'Manage Collections')

@section('admin_content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h3 class="text-lg font-bold text-gray-800">All Collections</h3>
            <p class="text-sm text-soft-gray">Marketing and discovery groups — products can belong to many collections.</p>
        </div>
        <a href="{{ route('admin.collections.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-md hover:bg-accent transition-all text-sm flex items-center cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Collection
        </a>
    </div>

    <x-admin.filter-bar :filters="request()->only(['search', 'active'])">
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Status</label>
            <select name="active" class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
                <option value="">All</option>
                <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </x-admin.filter-bar>

    <div class="bg-white rounded-[2rem] shadow-sm border border-primary-light/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-primary-light/10 text-left">
                <thead class="bg-background/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Banner</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Products</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-light/10">
                    @forelse ($collections as $collection)
                        <tr class="hover:bg-background/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-background border border-primary-light/10">
                                    @if ($collection->banner_image)
                                        <img src="{{ asset($collection->banner_image) }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800">{{ $collection->name }}</div>
                                <div class="text-xs text-gray-600 font-mono">{{ $collection->slug }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $collection->products_count }}</td>
                            <td class="px-6 py-4 text-sm">{{ $collection->display_order }}</td>
                            <td class="px-6 py-4">
                                @if ($collection->active)
                                    <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-100">Active</span>
                                @else
                                    <span class="px-2.5 py-1 bg-gray-50 text-gray-500 text-xs font-semibold rounded-full border border-gray-100">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.collections.edit', $collection->slug) }}" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.collections.destroy', $collection->slug) }}" class="js-confirm-delete" data-confirm="Delete this collection?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all cursor-pointer">
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
                            <td colspan="6" class="px-6 py-12 text-center text-soft-gray text-sm">No collections found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin.pagination :items="$collections" />
    </div>
@endsection
