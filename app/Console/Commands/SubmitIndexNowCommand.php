<?php

namespace App\Console\Commands;

use App\Services\IndexNowService;
use Illuminate\Console\Command;

class SubmitIndexNowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indexnow:submit {url? : Optional specific URL to submit} {--all : Submit all website URLs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Submit URLs to Bing and search engines via IndexNow API';

    /**
     * Execute the console command.
     */
    public function handle(IndexNowService $service)
    {
        if (!$service->isEnabled()) {
            $this->warn('IndexNow is currently disabled in configuration (INDEXNOW_ENABLED=false).');
            return self::FAILURE;
        }

        $specificUrl = $this->argument('url');

        if ($specificUrl) {
            $this->info("Submitting single URL to IndexNow: {$specificUrl}");
            $result = $service->submitUrl($specificUrl);
        } else {
            $this->info("Gathering all published website URLs...");
            $urls = $service->getAllSiteUrls();
            $this->info("Found " . count($urls) . " URLs to submit.");
            $result = $service->submitUrls($urls);
        }

        $this->newLine();

        if ($result['success']) {
            $this->info("✓ Successfully submitted " . ($result['count'] ?? 1) . " URL(s) to IndexNow!");
        } else {
            $this->warn("! IndexNow submission completed with warnings / errors.");
        }

        $this->newLine();
        $this->line("Endpoint Details:");
        $has403 = false;
        foreach ($result['endpoints'] ?? [] as $endpoint => $details) {
            $status = $details['status'] ?? 'N/A';
            $success = !empty($details['success']) ? 'SUCCESS' : 'FAILED';
            $this->line("- [{$endpoint}] HTTP {$status} ({$success})");
            
            if ($status == 403) {
                $has403 = true;
            }

            if (!empty($details['body'])) {
                $decoded = json_decode($details['body'], true);
                if (isset($decoded['message'])) {
                    $this->warn("  Message: " . $decoded['message']);
                } else {
                    $this->line("  Body: " . $details['body']);
                }
            }
            if (!empty($details['error'])) {
                $this->error("  Error: " . $details['error']);
            }
        }

        if ($has403) {
            $this->newLine();
            $this->warn("Note regarding HTTP 403 on Bing / api.indexnow.org:");
            $this->line("1. Cloudflare WAF / Bot Fight Mode: If your domain is behind Cloudflare, Cloudflare may block Bing's IndexNow validation crawler. Ensure requests to /<key>.txt are bypassed in Cloudflare WAF, or enable 'Crawler Hints' in Cloudflare Dashboard (Caching -> Configuration -> Crawler Hints).");
            $this->line("2. Bing Webmaster Tools: Ensure your site is verified in Bing Webmaster Tools (https://www.bing.com/webmasters).");
        }

        return $result['success'] ? self::SUCCESS : self::FAILURE;
    }
}
