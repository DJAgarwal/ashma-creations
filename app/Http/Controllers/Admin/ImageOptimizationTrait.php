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


        // Scale down while preserving aspect ratio without distortion.
        if (method_exists($image, 'scaleDown')) {
            $image->scaleDown(width: $maxWidth);
        } elseif (method_exists($image, 'scale')) {
            $image->scale(width: $maxWidth);
        } else {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Encode to WebP with target quality (Intervention Image v3 expects an EncoderInterface, not a string).
        $image->encode(new \Intervention\Image\Encoders\WebpEncoder($quality));


        // Write file
        $image->save($absoluteOutputPath);

        // Return path relative to public/ (uploads/<type>/<file>.webp)
        $destinationPath = rtrim(str_replace('\\', '/', $destinationPath), '/');
        if (str_ends_with($destinationPath, '/uploads/categories')) {
            return 'uploads/categories/' . $webpFilename;
        }

        if (str_ends_with($destinationPath, '/uploads/products')) {
            return 'uploads/products/' . $webpFilename;
        }

        if (str_ends_with($destinationPath, '/uploads/collections')) {
            return 'uploads/collections/' . $webpFilename;
        }

        if (str_ends_with($destinationPath, '/uploads/recipients')) {
            return 'uploads/recipients/' . $webpFilename;
        }

        if (str_ends_with($destinationPath, '/uploads/occasions')) {
            return 'uploads/occasions/' . $webpFilename;
        }

        // Fallback: infer uploads subfolder name from the destinationPath
        $parts = explode('/', $destinationPath);
        $folder = $parts ? end($parts) : 'uploads';
        return 'uploads/' . $folder . '/' . $webpFilename;
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

    protected function saveOptimizedRecipientImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 1000, 85);
    }

    protected function saveOptimizedOccasionImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 1000, 85);
    }

    protected function saveOptimizedHeroBannerDesktopImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 1920, 85);
    }

    protected function saveOptimizedHeroBannerMobileImage(UploadedFile $file, string $destinationPath, string $originalFilename): string
    {
        return $this->saveOptimizedImage($file, $destinationPath, $originalFilename, 800, 85);
    }
}

