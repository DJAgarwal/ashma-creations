@props([
    'filterData' => [],
    'currentFilters' => [],
    'actionUrl' => route('products.index')
])

<form id="catalog-filter-form" action="{{ $actionUrl }}" method="GET" class="bg-white rounded-3xl p-6 border border-primary-light/20 shadow-sm space-y-8">
    <!-- Header / Clear -->
    <div class="flex items-center justify-between pb-4 border-b border-primary-light/15">
        <h3 class="text-xl font-heading text-primary flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Refine Catalog
        </h3>
        @if(array_filter($currentFilters))
            <a href="{{ $actionUrl }}" class="text-xs font-body text-rose-500 hover:underline">Clear All</a>
        @endif
    </div>

    <!-- Sorting Selection -->
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-2">Sort By</label>
        <select name="sort" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
            <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured First</option>
            <option value="best_seller" {{ request('sort') === 'best_seller' ? 'selected' : '' }}>Best Sellers</option>
            <option value="trending" {{ request('sort') === 'trending' ? 'selected' : '' }}>Trending Items</option>
            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name (A to Z)</option>
            <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name (Z to A)</option>
        </select>
    </div>

    <!-- Search Query -->
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-2">Search Keyword</label>
        <div class="relative">
            <input type="text" name="q" value="{{ request('q', request('search')) }}" placeholder="e.g. Lavender, Rose pot..." class="w-full bg-background border border-primary-light/30 rounded-xl pl-9 pr-3 py-2 text-sm font-body focus:outline-none focus:border-primary">
            <svg class="w-4 h-4 text-soft-gray absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Primary Categories Filter -->
    @if(!empty($filterData['categories']) && $filterData['categories']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Categories</label>
        <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
            <label class="flex items-center space-x-2 text-sm font-body text-charcoal cursor-pointer hover:text-primary">
                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="js-auto-submit text-primary focus:ring-primary">
                <span>All Categories</span>
            </label>
            @foreach($filterData['categories'] as $cat)
                <label class="flex items-center space-x-2 text-sm font-body text-charcoal cursor-pointer hover:text-primary">
                    <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} class="js-auto-submit text-primary focus:ring-primary">
                    <span>{{ $cat->name }}</span>
                </label>
                @if($cat->children && $cat->children->count() > 0)
                    <div class="pl-4 space-y-1.5 border-l-2 border-primary-light/20 my-1">
                        @foreach($cat->children as $child)
                            <label class="flex items-center space-x-2 text-xs font-body text-soft-gray cursor-pointer hover:text-primary">
                                <input type="radio" name="category" value="{{ $child->slug }}" {{ request('category') === $child->slug ? 'checked' : '' }} class="js-auto-submit text-primary focus:ring-primary">
                                <span>{{ $child->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Collections Filter -->
    @if(!empty($filterData['collections']) && $filterData['collections']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Collections</label>
        <select name="collection" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="">All Collections</option>
            @foreach($filterData['collections'] as $col)
                <option value="{{ $col->slug }}" {{ request('collection') === $col->slug ? 'selected' : '' }}>
                    {{ $col->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Occasions Filter -->
    @if(!empty($filterData['occasions']) && $filterData['occasions']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Occasion</label>
        <select name="occasion" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="">All Occasions</option>
            @foreach($filterData['occasions'] as $occ)
                <option value="{{ $occ->slug }}" {{ request('occasion') === $occ->slug ? 'selected' : '' }}>
                    {{ $occ->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Recipients Filter -->
    @if(!empty($filterData['recipients']) && $filterData['recipients']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Recipient</label>
        <select name="recipient" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="">All Recipients</option>
            @foreach($filterData['recipients'] as $rec)
                <option value="{{ $rec->slug }}" {{ request('recipient') === $rec->slug ? 'selected' : '' }}>
                    {{ $rec->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Styles Filter -->
    @if(!empty($filterData['styles']) && $filterData['styles']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Style</label>
        <select name="style" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="">All Styles</option>
            @foreach($filterData['styles'] as $sty)
                <option value="{{ $sty->slug }}" {{ request('style') === $sty->slug ? 'selected' : '' }}>
                    {{ $sty->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Materials Filter (Used as Filter, not in main nav) -->
    @if(!empty($filterData['materials']) && $filterData['materials']->count() > 0)
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Material</label>
        <select name="material" class="js-auto-submit w-full bg-background border border-primary-light/30 rounded-xl px-3 py-2 text-sm font-body text-charcoal focus:outline-none focus:border-primary">
            <option value="">All Materials</option>
            @foreach($filterData['materials'] as $mat)
                <option value="{{ $mat->slug }}" {{ request('material') === $mat->slug ? 'selected' : '' }}>
                    {{ $mat->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Badges Toggles -->
    <div>
        <label class="block text-xs font-body font-bold text-charcoal uppercase tracking-wider mb-3">Badges & Attributes</label>
        <div class="space-y-2">
            <label class="flex items-center space-x-2 text-xs font-body text-charcoal cursor-pointer hover:text-primary">
                <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }} class="js-auto-submit rounded text-primary focus:ring-primary">
                <span>Featured Items</span>
            </label>
            <label class="flex items-center space-x-2 text-xs font-body text-charcoal cursor-pointer hover:text-primary">
                <input type="checkbox" name="best_seller" value="1" {{ request('best_seller') ? 'checked' : '' }} class="js-auto-submit rounded text-primary focus:ring-primary">
                <span>Best Sellers</span>
            </label>
            <label class="flex items-center space-x-2 text-xs font-body text-charcoal cursor-pointer hover:text-primary">
                <input type="checkbox" name="new_arrival" value="1" {{ request('new_arrival') ? 'checked' : '' }} class="js-auto-submit rounded text-primary focus:ring-primary">
                <span>New Arrivals</span>
            </label>
            <label class="flex items-center space-x-2 text-xs font-body text-charcoal cursor-pointer hover:text-primary">
                <input type="checkbox" name="trending" value="1" {{ request('trending') ? 'checked' : '' }} class="js-auto-submit rounded text-primary focus:ring-primary">
                <span>Trending</span>
            </label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button type="submit" class="w-full py-3 bg-primary text-white font-body font-bold text-sm rounded-xl shadow-md hover:bg-accent transition-colors">
            Apply Filters
        </button>
    </div>
</form>

<script nonce="{{ $cspNonce ?? '' }}">
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('catalog-filter-form');
    if (filterForm) {
        filterForm.querySelectorAll('.js-auto-submit').forEach(function(el) {
            el.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    }
});
</script>
