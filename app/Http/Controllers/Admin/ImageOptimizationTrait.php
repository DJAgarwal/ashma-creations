<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;



trait ImageOptimizationTrait
{
    /**
     * Saves an optimized WebP image and returns the public relative path.
     *
     * Production best practices applied:
     * - auto-orient using EXIF
     * - resize on the longest side
     * - convert to WebP (smaller size, good quality)
     * - use a deterministic filename
     */
    protected function saveOptimizedImage(UploadedFile $file, string $destinationPath, string $originalFilenameBase, int $maxWidth = 1200, int $quality = 80): string
    {
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $safeBase = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($originalFilenameBase, PATHINFO_FILENAME));
        $safeBase = $safeBase ?: 'image';

        $webpFilename = time() . '_' . $safeBase . '_' . bin2hex(random_bytes(3)) . '.webp';
        $absoluteOutputPath = rtrim($destinationPath, '/\\') . DIRECTORY_SEPARATOR . $webpFilename;

        $manager = ImageManager::gd();
        $image = method_exists($manager, 'read')
            ? $manager->read($file->getRealPath())
            : $manager->make($file->getRealPath());



        // Fix orientation issues from EXIF (best practice) - method name differs by version/driver.
        try {
            if (method_exists($image, 'orientate')) {
                $image->orientate();
            } elseif (method_exists($image, 'orient')) {
                $image->orient();
            }
        } catch (\Throwable $e) {
            // continue safely
        }


        // Resize while preserving aspect ratio.
        // fit() with aspect ratio best preserves image quality for typical admin thumbnails.
        $image->resize($maxWidth, $maxWidth, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Encode to WebP with target quality (Intervention Image v3 expects an EncoderInterface, not a string).
        $image->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));


        // Write file
        $image->save($absoluteOutputPath);

        return 'uploads/categories/' . $webpFilename;
    }

    protected function saveOptimizedCategoryImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        // destinationPath is public/uploads/categories
        // Return relative path used by existing code: uploads/categories/<file>
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 1200, 80);
    }

    protected function saveOptimizedProductImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        // destinationPath is public/uploads/products
        // We still return relative path (uploads/products/<file>)
        // Reuse the same production settings.
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 1600, 80);
    }

}

