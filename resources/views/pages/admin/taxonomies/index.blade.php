@extends('layouts.admin')

@section('admin_title', $config['label'])
@section('admin_page_header', 'Manage ' . $config['label'])

@section('admin_content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h3 class="text-lg font-bold text-gray-800">All {{ $config['label'] }}</h3>
            <p class="text-sm text-soft-gray">Create, edit, and organize {{ strtolower($config['label']) }} for product discovery.</p>
        </div>
        <a href="{{ route('admin.taxonomies.create', $type) }}" class="px-6 py-3 bg-primary text-white font-bold rounded-2xl shadow-md hover:bg-accent hover:shadow-lg transition-all text-sm flex items-center cursor-pointer">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Create {{ $config['label_singular'] ?? Str::singular($config['label']) }}
        </a>
    </div>

    <x-admin.filter-bar :filters="$filters ?? request()->only(['search', 'active'])">
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
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Slug</th>
                        @if(!empty($config['fields']['icon']))
                            <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Icon</th>
                        @endif
                        @if(!empty($config['fields']['image']))
                            <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Image</th>
                        @endif
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-soft-gray uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-light/10">
                    @forelse ($items as $item)
                        <tr class="hover:bg-background/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800">{{ $item->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $item->slug }}</td>
                            @if(!empty($config['fields']['icon']))
                                <td class="px-6 py-4 text-sm">{{ $item->icon ?: '—' }}</td>
                            @endif
                            @if(!empty($config['fields']['image']))
                                <td class="px-6 py-4">
                                    @if(!empty($item->image_path))
                                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-10 h-12 object-cover rounded-lg border border-primary-light/20 shadow-sm" />
                                    @else
                                        <span class="text-xs text-soft-gray">—</span>
                                    @endif
                                </td>
                            @endif
                            <td class="px-6 py-4 text-sm">{{ $item->display_order }}</td>
                            <td class="px-6 py-4">
                                @if ($item->active)
                                    <span class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full border border-green-100">Active</span>
                                @else
                                    <span class="px-2.5 py-1 bg-gray-50 text-gray-500 text-xs font-semibold rounded-full border border-gray-100">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.taxonomies.edit', [$type, $item->slug]) }}" class="p-2 text-primary hover:bg-primary/10 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.taxonomies.destroy', [$type, $item->slug]) }}" class="js-confirm-delete" data-confirm="Delete this {{ strtolower($config['label_singular'] ?? $config['label']) }}?">
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
                            <td colspan="6" class="px-6 py-12 text-center text-soft-gray text-sm">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-admin.pagination :items="$items" />
    </div>
@endsection
