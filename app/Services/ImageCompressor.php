<?php

namespace App\Services;

use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageCompressor
{
    private const array COMPRESSIBLE = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];

    private const int MAX_BYTES = 300 * 1024;

    private const int MAX_DIMENSION = 2000;

    private const int START_QUALITY = 80;

    private const int MIN_QUALITY = 40;

    private const int QUALITY_STEP = 10;

    public static function compress(Media $media): void
    {
        if (! in_array($media->type, self::COMPRESSIBLE, true)) {
            return;
        }

        $disk         = Storage::disk($media->disk);
        $originalPath = $media->path;
        $newImagePath = $media->directory.'/'.Str::uuid().'.webp';

        $image   = ImageManager::gd()->read($disk->get($originalPath))->orient();
        $encoded = $image->toWebp();

        if ($encoded->size() > self::MAX_BYTES) {
            $image->scaleDown(self::MAX_DIMENSION, self::MAX_DIMENSION);

            $quality = self::START_QUALITY;

            do {
                $encoded  = $image->toWebp($quality);
                $quality -= self::QUALITY_STEP;
            } while ($encoded->size() > self::MAX_BYTES && $quality >= self::MIN_QUALITY);
        }

        $disk->put($newImagePath, (string) $encoded, 'public');
        $disk->delete($originalPath);

        $media->forceFill([
            'path'   => $newImagePath,
            'name'   => pathinfo($newImagePath, PATHINFO_FILENAME),
            'ext'    => 'webp',
            'type'   => 'image/webp',
            'size'   => $disk->size($newImagePath),
            'width'  => $image->width(),
            'height' => $image->height(),
        ])->saveQuietly();
    }
}
