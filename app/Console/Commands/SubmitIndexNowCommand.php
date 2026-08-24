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
            $this->warn("! IndexNow submission completed with warnings.");
        }

        $this->newLine();
        $this->line("Endpoint Details:");
        foreach ($result['endpoints'] ?? [] as $endpoint => $details) {
            $status = $details['status'] ?? 'N/A';
            $success = !empty($details['success']) ? 'SUCCESS' : 'FAILED';
            $this->line("- [{$endpoint}] HTTP {$status} ({$success})");
            if (!empty($details['error'])) {
                $this->error("  Error: " . $details['error']);
            }
        }

        return $result['success'] ? self::SUCCESS : self::FAILURE;
    }
}
