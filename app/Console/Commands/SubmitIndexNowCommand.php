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
    protected $description = 'Submit URLs to search engines via IndexNow API';

    /**
     * Execute the console command.
     */
    public function handle(IndexNowService $service)
    {
        if (!$service->isEnabled()) {
            $this->warn('IndexNow is disabled in configuration.');
            return self::FAILURE;
        }

        $specificUrl = $this->argument('url');

        if ($specificUrl) {
            $this->info("Submitting single URL to IndexNow: {$specificUrl}");
            $success = $service->submitUrl($specificUrl);
            $count = 1;
        } else {
            $this->info("Gathering all published website URLs...");
            $urls = $service->getAllSiteUrls();
            $count = count($urls);
            $this->info("Found {$count} URLs to submit.");
            $success = $service->submitUrls($urls);
        }

        $this->newLine();

        if ($success) {
            $this->info("✓ Successfully submitted {$count} URL(s) to IndexNow!");
            return self::SUCCESS;
        }

        $this->error("! IndexNow submission failed. Check your logs for details.");
        return self::FAILURE;
    }
}
