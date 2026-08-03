<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\ImageOptimizationTrait;
use App\Models\Occasion;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OccasionSeeder extends Seeder
{
    use ImageOptimizationTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Force delete existing occasions so new ones are created cleanly every time
        Occasion::query()->forceDelete();

        $occasions = [
            'Rakhi',
            'Birthday',
            'Anniversary',
            'Wedding',
            'Housewarming',
            'Baby Shower',
            'Engagement',
            'Diwali',
            "Mother's Day",
            "Father's Day",
            'Friendship Day',
            "Women's Day",
            "Valentine's Day",
            'Christmas',
            'New Year',
        ];

        // Scan seed images in database/seeders/occasions
        $seedDir = database_path('seeders/occasions');
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

        $destinationPath = public_path('uploads/occasions');

        // Delete existing files in uploads/occasions so old unused images don't accumulate
        if (File::isDirectory($destinationPath)) {
            File::cleanDirectory($destinationPath);
        } else {
            File::makeDirectory($destinationPath, 0755, true);
        }

        foreach ($occasions as $index => $name) {
            $slug = Str::slug($name);

            $occasion = Occasion::create([
                'name' => $name,
                'slug' => $slug,
                'active' => true,
                'display_order' => $index + 1,
            ]);

            // Direct match image by slug name
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

                $newRelativePath = $this->saveOptimizedOccasionImage($uploadedFile, $destinationPath, $name);

                $occasion->update(['image_path' => $newRelativePath]);
            }
        }

        Occasion::flushHomeCacheKeys();
    }
}
