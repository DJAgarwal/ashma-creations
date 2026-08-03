<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\ImageOptimizationTrait;
use App\Models\Recipient;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RecipientSeeder extends Seeder
{
    use ImageOptimizationTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Force delete existing recipients so new ones are created cleanly every time
        Recipient::query()->forceDelete();

        $recipients = [
            'Mom',
            'Dad',
            'Wife',
            'Husband',
            'Girlfriend',
            'Boyfriend',
            'Best Friend',
            'Friends',
            'Sister',
            'Brother',
            'Daughter',
            'Son',
            'Parents',
            'Couples',
            'Bride',
            'Groom',
            'Kids',
            'Teacher',
            'Colleague',
            'Boss',
        ];

        // Scan seed images in database/seeders/recipients
        $seedDir = database_path('seeders/recipients');
        $seedImages = [];

        if (File::isDirectory($seedDir)) {
            foreach (File::files($seedDir) as $file) {
                $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $slug = Str::slug($filename);
                if ($slug) {
                    $seedImages[$slug] = $file->getRealPath();
                }
            }
        }

        $destinationPath = public_path('uploads/recipients');

        // Delete existing files in uploads/recipients so old unused images don't accumulate
        if (File::isDirectory($destinationPath)) {
            File::cleanDirectory($destinationPath);
        } else {
            File::makeDirectory($destinationPath, 0755, true);
        }

        foreach ($recipients as $index => $name) {
            $slug = Str::slug($name);

            $recipient = Recipient::create([
                'name' => $name,
                'slug' => $slug,
                'active' => true,
                'display_order' => $index + 1,
            ]);

            $matchedSeedPath = $seedImages[$slug] ?? null;

            if ($matchedSeedPath) {
                $mimeType = File::mimeType($matchedSeedPath) ?: 'image/png';
                $uploadedFile = new UploadedFile(
                    $matchedSeedPath,
                    basename($matchedSeedPath),
                    $mimeType,
                    null,
                    true
                );

                $newRelativePath = $this->saveOptimizedRecipientImage($uploadedFile, $destinationPath, $name);

                $recipient->update(['image_path' => $newRelativePath]);
            }
        }

        Recipient::flushHomeCacheKeys();
    }
}

