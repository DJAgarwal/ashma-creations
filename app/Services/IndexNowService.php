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
    protected string $key;
    protected string $host;
    protected string $keyLocation;
    protected array $endpoints = [
        'https://api.indexnow.org/indexnow',
        'https://www.bing.com/indexnow',
        'https://yandex.com/indexnow',
    ];

    public function __construct()
    {
        $this->key = config('services.indexnow.key', '8f3c67d804d74cc989691be23221c1e4');
        
        $configuredHost = config('services.indexnow.host');
        if (empty($configuredHost) || in_array($configuredHost, ['localhost', '127.0.0.1'])) {
            $configuredHost = 'ashmacreations.net';
        }
        $this->host = preg_replace('#^https?://#', '', rtrim($configuredHost, '/'));
        
        $this->keyLocation = config('services.indexnow.key_location') ?: "https://{$this->host}/{$this->key}.txt";
    }

    /**
     * Submit a single URL to IndexNow.
     */
    public function submitUrl(string $url): array
    {
        return $this->submitUrls([$url]);
    }

    /**
     * Submit multiple URLs in bulk to IndexNow.
     */
    public function submitUrls(array $urls): array
    {
        // Normalize URLs to ensure they use the public host
        $normalizedUrls = [];
        foreach ($urls as $u) {
            $parsed = parse_url($u);
            $path = ($parsed['path'] ?? '/') . (!empty($parsed['query']) ? '?' . $parsed['query'] : '');
            $normalizedUrls[] = "https://{$this->host}" . $path;
        }

        $normalizedUrls = array_values(array_unique(array_filter($normalizedUrls)));

        if (empty($normalizedUrls)) {
            return [
                'success' => false,
                'message' => 'No URLs provided for submission.',
                'status' => null,
            ];
        }

        $payload = [
            'host' => $this->host,
            'key' => $this->key,
            'keyLocation' => $this->keyLocation,
            'urlList' => $normalizedUrls,
        ];

        $results = [];
        $overallSuccess = false;

        foreach ($this->endpoints as $endpoint) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders(['Content-Type' => 'application/json; charset=utf-8'])
                    ->post($endpoint, $payload);

                $status = $response->status();
                $isOk = in_array($status, [200, 202]);

                if ($isOk) {
                    $overallSuccess = true;
                }

                $results[$endpoint] = [
                    'status' => $status,
                    'success' => $isOk,
                    'body' => $response->body(),
                ];
            } catch (\Throwable $e) {
                Log::warning("IndexNow submission failed for {$endpoint}: " . $e->getMessage());
                $results[$endpoint] = [
                    'status' => 0,
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return [
            'success' => $overallSuccess,
            'count' => count($normalizedUrls),
            'urls' => $normalizedUrls,
            'endpoints' => $results,
        ];
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
    public function submitAllSiteUrls(): array
    {
        $urls = $this->getAllSiteUrls();
        return $this->submitUrls($urls);
    }
}
