<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndexNowService
{
    private string $endpoint;
    private bool $enabled;
    private ?string $key;
    private ?string $host;

    public function __construct()
    {
        $this->enabled = (bool) config('indexnow.enabled', true);
        $this->key = config('indexnow.key', '8f3c67d804d74cc989691be23221c1e4');
        $this->host = config('indexnow.host', 'ashmacreations.net');
        $this->endpoint = config('indexnow.endpoint', 'https://yandex.com/indexnow');
    }

    /**
     * Submit a single URL to IndexNow.
     */
    public function submitUrl(string $url): bool
    {
        return $this->submitUrls([$url]);
    }

    /**
     * Submit multiple URLs to IndexNow in a batch.
     */
    public function submitUrls(array $urls): bool
    {
        if (!$this->enabled) {
            return false;
        }

        if (empty($this->key)) {
            Log::warning('IndexNow: API key is missing. Skipping submission.');
            return false;
        }

        if (empty($urls)) {
            return false;
        }

        // Normalize and unique URLs
        $normalizedUrls = [];
        foreach ($urls as $u) {
            if (empty($u)) {
                continue;
            }
            $parsed = parse_url($u);
            $path = ($parsed['path'] ?? '/') . (!empty($parsed['query']) ? '?' . $parsed['query'] : '');
            $normalizedUrls[] = "https://{$this->host}" . $path;
        }

        $normalizedUrls = array_values(array_unique(array_filter($normalizedUrls)));

        if (empty($normalizedUrls)) {
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json; charset=utf-8'])
                ->post($this->endpoint, [
                    'host' => $this->host,
                    'key' => $this->key,
                    'urlList' => $normalizedUrls,
                ]);

            if ($response->successful()) {
                Log::info('IndexNow: Successfully submitted URLs.', [
                    'count' => count($normalizedUrls),
                    'status' => $response->status(),
                ]);
                return true;
            }

            Log::warning('IndexNow: Submission returned non-200 status.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('IndexNow: Exception during submission.', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Gathers all published website URLs.
     */
    public function getAllSiteUrls(): array
    {
        $urls = [];
        $base = "https://{$this->host}";

        // Homepage & Core Pages
        $urls[] = "{$base}/";
        $urls[] = "{$base}/search";
        $urls[] = "{$base}/reviews";
        $urls[] = "{$base}/categories";
        $urls[] = "{$base}/collections";
        $urls[] = "{$base}/occasions";
        $urls[] = "{$base}/recipients";

        // Static Pages
        try {
            foreach (StaticPage::all() as $page) {
                $urls[] = "{$base}/page/{$page->slug}";
            }
        } catch (\Throwable $e) {}

        // Categories
        try {
            foreach (Category::active()->get() as $cat) {
                $urls[] = "{$base}/category/{$cat->slug}";
            }
        } catch (\Throwable $e) {}

        // Collections
        try {
            foreach (Collection::active()->get() as $col) {
                $urls[] = "{$base}/collection/{$col->slug}";
            }
        } catch (\Throwable $e) {}

        // Occasions
        try {
            foreach (Occasion::active()->get() as $occ) {
                $urls[] = "{$base}/occasion/{$occ->slug}";
            }
        } catch (\Throwable $e) {}

        // Recipients
        try {
            foreach (Recipient::active()->get() as $rec) {
                $urls[] = "{$base}/recipient/{$rec->slug}";
            }
        } catch (\Throwable $e) {}

        // Products
        try {
            foreach (Product::all() as $prod) {
                $urls[] = "{$base}/product/{$prod->slug}";
            }
        } catch (\Throwable $e) {}

        return array_values(array_unique($urls));
    }

    /**
     * Submits the entire site URLs to IndexNow.
     */
    public function submitAllSiteUrls(): bool
    {
        return $this->submitUrls($this->getAllSiteUrls());
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
