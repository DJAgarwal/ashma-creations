<?php

namespace App\Models;

use App\Models\Concerns\FlushesHomeCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class HeroBanner extends Model
{
    use HasFactory;
    use SoftDeletes;
    use FlushesHomeCache;

    protected $fillable = [
        'title',
        'link_type',
        'link_id',
        'custom_url',
        'desktop_image',
        'mobile_image',
        'active',
        'display_order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Scope a query to only include active hero banners.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to order hero banners by display order then creation date.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get image alt text (defaults to destination label for SEO compliance).
     */
    public function getAltTextAttribute(): string
    {
        return 'Ashma Creations Banner - ' . $this->destination_label;
    }

    /**
     * Dynamically resolve the destination link URL.
     */
    public function getLinkUrlAttribute(): string
    {
        if (empty($this->link_type)) {
            return '#';
        }

        $type = strtolower(trim($this->link_type));

        try {
            switch ($type) {
                case 'category':
                    if ($this->link_id && $cat = Category::find($this->link_id)) {
                        return Route::has('categories.show') ? route('categories.show', $cat->slug) : url('/category/' . $cat->slug);
                    }
                    break;

                case 'collection':
                    if ($this->link_id && $col = Collection::find($this->link_id)) {
                        return Route::has('collections.show') ? route('collections.show', $col->slug) : url('/collection/' . $col->slug);
                    }
                    break;

                case 'occasion':
                    if ($this->link_id && $occ = Occasion::find($this->link_id)) {
                        return Route::has('occasions.show') ? route('occasions.show', $occ->slug) : url('/occasion/' . $occ->slug);
                    }
                    break;

                case 'recipient':
                    if ($this->link_id && $rec = Recipient::find($this->link_id)) {
                        return Route::has('recipients.show') ? route('recipients.show', $rec->slug) : url('/recipient/' . $rec->slug);
                    }
                    break;

                case 'product':
                    if ($this->link_id && $prod = Product::find($this->link_id)) {
                        return Route::has('products.show') ? route('products.show', $prod->slug) : url('/product/' . $prod->slug);
                    }
                    break;

                case 'page':
                    if ($this->link_id) {
                        $page = StaticPage::find($this->link_id);
                        $slug = $page ? $page->page_name : $this->link_id;
                        return Route::has('page.show') ? route('page.show', $slug) : url('/' . $slug);
                    }
                    break;

                case 'custom url':
                case 'custom_url':
                case 'custom':
                default:
                    return $this->custom_url ?: '#';
            }
        } catch (\Throwable $e) {
            return $this->custom_url ?: '#';
        }

        return $this->custom_url ?: '#';
    }

    /**
     * Friendly summary label for destination.
     */
    public function getDestinationLabelAttribute(): string
    {
        $type = $this->link_type;
        if (in_array(strtolower($type), ['custom url', 'custom_url', 'custom'])) {
            return 'Custom: ' . ($this->custom_url ? \Illuminate\Support\Str::limit($this->custom_url, 30) : 'None');
        }

        if ($this->link_id) {
            $typeLower = strtolower($type);
            $entityName = null;

            if ($typeLower === 'category') {
                $entityName = Category::where('id', $this->link_id)->value('name');
            } elseif ($typeLower === 'collection') {
                $entityName = Collection::where('id', $this->link_id)->value('name');
            } elseif ($typeLower === 'occasion') {
                $entityName = Occasion::where('id', $this->link_id)->value('name');
            } elseif ($typeLower === 'recipient') {
                $entityName = Recipient::where('id', $this->link_id)->value('name');
            } elseif ($typeLower === 'product') {
                $entityName = Product::where('id', $this->link_id)->value('name');
            } elseif ($typeLower === 'page') {
                $entityName = StaticPage::where('id', $this->link_id)->value('page_name');
            }

            if ($entityName) {
                return "{$type}: {$entityName}";
            }
        }

        return "{$type} (#{$this->link_id})";
    }
}
