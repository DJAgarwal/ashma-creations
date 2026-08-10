<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\StaticPage;
use App\Models\Style;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display the main Shop / All Products catalog page with combined multi-taxonomy filters.
     */
    public function productIndex(Request $request)
    {
        $query = Product::query()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);

        $products = $query->paginate(12)->withQueryString();
        $filterData = $this->getFilterData();

        $pageTitle = 'Browse All Gifts';
        $metaDescription = 'Shop handmade pipe cleaner flowers, bouquets, flower pots and personalized gifts from Ashma Creations. Discover unique handcrafted gifts for every occasion.';

        $jsonldPayload = \App\Services\SchemaGenerator::forCatalog($products, $pageTitle, $metaDescription);

        return view('pages.products.index', [
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
            'pageTitle' => $pageTitle,
            'metaDescription' => $metaDescription,
            'jsonld' => $jsonldPayload,
        ]);
    }

    /**
     * Show all top-level categories.
     */
    public function categoryIndex()
    {
        $page = StaticPage::where('page_name', 'categories')->first();
        $categories = Category::whereNull('parent_id')
            ->active()
            ->ordered()
            ->with(['children' => fn ($q) => $q->active()->ordered()->withCount(['products' => fn ($p) => $p->whereNull('deleted_at')])])
            ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
            ->get();

        return view('pages.categories.index', compact('page', 'categories'));
    }

    /**
     * Show landing page for a specific category.
     */
    public function categoryShow(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();
        
        $categoryIds = $category->children()->active()->pluck('id')->push($category->id);

        $query = Product::whereIn('category_id', $categoryIds)->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();
        $subcategories = $category->children()->active()->ordered()->get();

        return view('pages.categories.show', [
            'category' => $category,
            'subcategories' => $subcategories,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show all collections landing page.
     */
    public function collectionIndex()
    {
        $collections = Collection::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
            ->get();

        return view('pages.collections.index', compact('collections'));
    }

    /**
     * Show landing page for a specific collection.
     */
    public function collectionShow(Request $request, string $slug)
    {
        $collection = Collection::where('slug', $slug)->active()->firstOrFail();

        $query = $collection->products()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();

        return view('pages.collections.show', [
            'collection' => $collection,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show all occasions landing page.
     */
    public function occasionIndex()
    {
        $occasions = Occasion::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
            ->get();

        return view('pages.occasions.index', compact('occasions'));
    }

    /**
     * Show landing page for a specific occasion.
     */
    public function occasionShow(Request $request, string $slug)
    {
        $occasion = Occasion::where('slug', $slug)->active()->firstOrFail();

        $query = $occasion->products()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();

        return view('pages.occasions.show', [
            'occasion' => $occasion,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show all recipients landing page.
     */
    public function recipientIndex()
    {
        $recipients = Recipient::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
            ->get();

        return view('pages.recipients.index', compact('recipients'));
    }

    /**
     * Show landing page for a specific recipient.
     */
    public function recipientShow(Request $request, string $slug)
    {
        $recipient = Recipient::where('slug', $slug)->active()->firstOrFail();

        $query = $recipient->products()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();

        return view('pages.recipients.show', [
            'recipient' => $recipient,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show landing page for a specific style.
     */
    public function styleShow(Request $request, string $slug)
    {
        $style = Style::where('slug', $slug)->active()->firstOrFail();

        $query = $style->products()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();

        return view('pages.styles.show', [
            'style' => $style,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show landing page for a specific material.
     */
    public function materialShow(Request $request, string $slug)
    {
        $material = Material::where('slug', $slug)->active()->firstOrFail();

        $query = $material->products()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        $this->applyFiltersAndSorting($query, $request);
        $products = $query->paginate(12)->withQueryString();

        $filterData = $this->getFilterData();

        return view('pages.materials.show', [
            'material' => $material,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Show a specific product detail page.
     */
    public function productShow(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['primaryCategory.parent', 'collections', 'occasions', 'recipients', 'styles', 'materials'])
            ->firstOrFail();

        $relatedProducts = $this->getScoredRelatedProducts($product, 4);

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products by name, description, or taxonomy.
     */
    public function search(Request $request)
    {
        $term = trim($request->input('q', $request->input('search', '')));

        $query = Product::query()->with([
            'primaryCategory',
            'collections',
            'occasions',
            'recipients',
            'styles',
            'materials',
        ]);

        if (!empty($term)) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('details', 'like', "%{$term}%")
                    ->orWhereHas('primaryCategory', fn ($sub) => $sub->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('collections', fn ($sub) => $sub->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('occasions', fn ($sub) => $sub->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('recipients', fn ($sub) => $sub->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('styles', fn ($sub) => $sub->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('materials', fn ($sub) => $sub->where('name', 'like', "%{$term}%"));
            });
        }

        $this->applyFiltersAndSorting($query, $request);

        $products = $query->paginate(12)->withQueryString();
        $filterData = $this->getFilterData();

        return view('pages.search', [
            'searchTerm' => $term,
            'products' => $products,
            'filterData' => $filterData,
            'currentFilters' => $request->all(),
        ]);
    }

    /**
     * Related Products scoring algorithm based on taxonomy overlap:
     * Priority:
     * 1. Same Collection
     * 2. Same Occasion
     * 3. Same Recipient
     * 4. Same Style
     * 5. Same Category
     * Fallback: Random / Featured products.
     */
    protected function getScoredRelatedProducts(Product $product, int $limit = 4)
    {
        $collectionIds = $product->collections->pluck('id')->toArray();
        $occasionIds = $product->occasions->pluck('id')->toArray();
        $recipientIds = $product->recipients->pluck('id')->toArray();
        $styleIds = $product->styles->pluck('id')->toArray();
        $categoryId = $product->category_id;

        $candidates = Product::query()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($collectionIds, $occasionIds, $recipientIds, $styleIds, $categoryId) {
                if (!empty($collectionIds)) {
                    $q->orWhereHas('collections', fn ($sub) => $sub->whereIn('collections.id', $collectionIds));
                }
                if (!empty($occasionIds)) {
                    $q->orWhereHas('occasions', fn ($sub) => $sub->whereIn('occasions.id', $occasionIds));
                }
                if (!empty($recipientIds)) {
                    $q->orWhereHas('recipients', fn ($sub) => $sub->whereIn('recipients.id', $recipientIds));
                }
                if (!empty($styleIds)) {
                    $q->orWhereHas('styles', fn ($sub) => $sub->whereIn('styles.id', $styleIds));
                }
                if ($categoryId) {
                    $q->orWhere('category_id', $categoryId);
                }
            })
            ->with(['primaryCategory', 'collections', 'occasions', 'recipients', 'styles'])
            ->take(30)
            ->get();

        $scored = $candidates->map(function ($cand) use ($collectionIds, $occasionIds, $recipientIds, $styleIds, $categoryId) {
            $score = 0;

            // 1. Same Collection (+100 points per match)
            $candCollections = $cand->collections->pluck('id')->toArray();
            $score += count(array_intersect($candCollections, $collectionIds)) * 100;

            // 2. Same Occasion (+50 points per match)
            $candOccasions = $cand->occasions->pluck('id')->toArray();
            $score += count(array_intersect($candOccasions, $occasionIds)) * 50;

            // 3. Same Recipient (+30 points per match)
            $candRecipients = $cand->recipients->pluck('id')->toArray();
            $score += count(array_intersect($candRecipients, $recipientIds)) * 30;

            // 4. Same Style (+20 points per match)
            $candStyles = $cand->styles->pluck('id')->toArray();
            $score += count(array_intersect($candStyles, $styleIds)) * 20;

            // 5. Same Category (+10 points)
            if ($cand->category_id === $categoryId) {
                $score += 10;
            }

            $cand->relevance_score = $score;
            return $cand;
        })->sortByDesc('relevance_score')->values();

        $results = $scored->take($limit);

        // Fallback to random featured/latest products if fewer than limit found
        if ($results->count() < $limit) {
            $needed = $limit - $results->count();
            $excludeIds = $results->pluck('id')->push($product->id)->toArray();

            $fallbacks = Product::query()
                ->whereNotIn('id', $excludeIds)
                ->with('primaryCategory')
                ->inRandomOrder()
                ->take($needed)
                ->get();

            $results = $results->concat($fallbacks);
        }

        return $results;
    }

    /**
     * Shared filter and sorting engine.
     */
    protected function applyFiltersAndSorting($query, Request $request): void
    {
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $categoryIds = $category->children()->active()->pluck('id')->push($category->id);
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->filled('collection')) {
            $slug = $request->input('collection');
            $query->whereHas('collections', fn ($q) => $q->where('collections.slug', $slug));
        }

        if ($request->filled('occasion')) {
            $slug = $request->input('occasion');
            $query->whereHas('occasions', fn ($q) => $q->where('occasions.slug', $slug));
        }

        if ($request->filled('recipient')) {
            $slug = $request->input('recipient');
            $query->whereHas('recipients', fn ($q) => $q->where('recipients.slug', $slug));
        }

        if ($request->filled('style')) {
            $slug = $request->input('style');
            $query->whereHas('styles', fn ($q) => $q->where('styles.slug', $slug));
        }

        if ($request->filled('material')) {
            $slug = $request->input('material');
            $query->whereHas('materials', fn ($q) => $q->where('materials.slug', $slug));
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->boolean('best_seller')) {
            $query->where('is_best_seller', true);
        }

        if ($request->boolean('new_arrival')) {
            $query->where('is_new_arrival', true);
        }

        if ($request->boolean('trending')) {
            $query->where('is_trending', true);
        }

        // Apply Sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'featured':
                $query->orderByDesc('is_featured')->latest();
                break;
            case 'best_seller':
                $query->orderByDesc('is_best_seller')->latest();
                break;
            case 'trending':
                $query->orderByDesc('is_trending')->latest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
    }

    /**
     * Get lookup datasets for filter sidebars.
     */
    protected function getFilterData(): array
    {
        return [
            'categories' => Category::active()->ordered()->whereNull('parent_id')->with('children')->get(),
            'collections' => Collection::active()->ordered()->get(),
            'occasions' => Occasion::active()->ordered()->get(),
            'recipients' => Recipient::active()->ordered()->get(),
            'styles' => Style::active()->ordered()->get(),
            'materials' => Material::active()->ordered()->get(),
        ];
    }
}
