@extends('layouts.admin')

@section('admin_title', 'Edit Collection')
@section('admin_page_header', 'Edit Collection')

@section('admin_content')
    <div class="mb-8">
        <a href="{{ route('admin.collections.index') }}" class="text-sm font-semibold text-primary hover:text-accent transition-colors flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Collections
        </a>
    </div>

    <div class="max-w-2xl bg-white rounded-[2rem] p-8 shadow-sm border border-primary-light/10">
        <form method="POST" action="{{ route('admin.collections.update', $collection->slug) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('pages.admin.collections._form', ['item' => $collection])
            <p class="text-xs text-soft-gray">Slug: <code class="bg-background px-2 py-1 rounded">{{ $collection->slug }}</code></p>
            <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-accent transition-all cursor-pointer">Update Collection</button>
        </form>
    </div>
@endsection
