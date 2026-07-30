@props(['filters' => []])

<form method="GET" class="mb-6 bg-white rounded-[2rem] p-6 shadow-sm border border-primary-light/10">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-bold text-soft-gray uppercase tracking-wider mb-2">Search</label>
            <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name or slug..."
                   class="w-full px-4 py-3 bg-background/50 border border-primary-light/20 rounded-xl text-sm">
        </div>

        {{ $slot }}

        <div class="flex items-end gap-2 md:col-span-2 xl:col-span-1">
            <button type="submit" class="flex-1 py-3 bg-primary text-white font-bold rounded-xl text-sm hover:bg-accent transition-colors cursor-pointer">Filter</button>
            <a href="{{ url()->current() }}" class="px-4 py-3 border border-primary-light/20 rounded-xl text-sm font-semibold text-gray-600 hover:text-primary transition-colors">Reset</a>
        </div>
    </div>
</form>
