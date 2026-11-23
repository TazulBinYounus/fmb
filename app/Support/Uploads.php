<?php

namespace App\Support;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Stores admin uploads in public/uploads/{folder} with random file names,
 * scales down oversized photos and records each file in the media library.
 */
class Uploads
{
    public const IMAGE_RULES = ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];   // 5 MB
    public const PDF_RULES = ['file', 'mimes:pdf', 'max:15360'];                   // 15 MB
    private const MAX_WIDTH = 2400;

    public static function disk()
    {
        return Storage::disk('uploads');
    }

    /** Saves the file and returns its path relative to public/uploads (e.g. "projects/abc.jpg"). */
    public static function store(UploadedFile $file, string $folder, ?string $alt = null): string
    {
        // Extension comes from the detected MIME type, never from the client's file name.
        $extension = $file->guessExtension() ?: 'bin';
        $folder = trim(preg_replace('/[^a-z0-9\-]/', '', strtolower($folder)), '/') ?: 'misc';
        $path = $folder.'/'.now()->format('Y/m').'/'.Str::random(32).'.'.$extension;

        self::disk()->putFileAs(dirname($path), $file, basename($path));

        $width = $height = null;
        if (str_starts_with((string) $file->getMimeType(), 'image/')) {
            [$width, $height] = self::downscale(self::disk()->path($path)) ?? [null, null];
        }

        Media::create([
            'path' => $path,
            'original_name' => Str::limit($file->getClientOriginalName(), 250, ''),
            'mime_type' => (string) $file->getMimeType(),
            'size' => self::disk()->size($path),
            'width' => $width,
            'height' => $height,
            'alt' => $alt,
            'uploaded_by' => auth()->id(),
        ]);

        return $path;
    }

    /**
     * Deletes an uploaded file once no record uses it any more.
     * Call it AFTER the database row has been updated/deleted.
     * Theme images under assets/ are never deleted.
     */
    public static function delete(?string $path): void
    {
        if (! $path || ! self::isUpload($path) || self::referenceCount($path) > 0) {
            return;
        }
        self::disk()->delete($path);
        Media::where('path', $path)->delete();
    }

    /** Deletes a file from the media library, whether or not it is still used. */
    public static function forceDelete(string $path): void
    {
        if (! self::isUpload($path)) {
            return;
        }
        self::disk()->delete($path);
        Media::where('path', $path)->delete();
    }

    public static function isUpload(string $path): bool
    {
        return ! str_starts_with($path, 'assets/')
            && ! str_contains($path, '..')
            && ! preg_match('#^(https?:)?//#', $path);
    }

    /** Number of content records (projects, banners, settings …) that use this path. */
    public static function referenceCount(string $path): int
    {
        $count = 0;
        foreach ([
            ['projects', ['cover_image', 'og_image', 'brochure']],
            ['project_images', ['path']],
            ['project_units', ['floor_plan']],
            ['banners', ['image']],
            ['pages', ['banner_image', 'og_image']],
            ['testimonials', ['photo']],
        ] as [$table, $columns]) {
            foreach ($columns as $column) {
                $count += \DB::table($table)->where($column, $path)->count();
            }
        }
        $count += \DB::table('settings')->where('value', $path)->count();

        return $count;
    }

    /** Scales a JPEG/PNG/WebP down to MAX_WIDTH; returns [width, height]. */
    private static function downscale(string $file): ?array
    {
        $info = @getimagesize($file);
        if (! $info) {
            return null;
        }
        [$w, $h, $type] = $info;
        if ($w <= self::MAX_WIDTH || ! function_exists('imagecreatetruecolor')) {
            return [$w, $h];
        }

        $src = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($file),
            IMAGETYPE_PNG => @imagecreatefrompng($file),
            IMAGETYPE_WEBP => @imagecreatefromwebp($file),
            default => null,
        };
        if (! $src) {
            return [$w, $h];
        }

        $nw = self::MAX_WIDTH;
        $nh = (int) round($h * $nw / $w);
        $dst = imagecreatetruecolor($nw, $nh);
        if ($type !== IMAGETYPE_JPEG) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($dst, $file, 82),
            IMAGETYPE_PNG => imagepng($dst, $file, 8),
            IMAGETYPE_WEBP => imagewebp($dst, $file, 82),
        };
        imagedestroy($src);
        imagedestroy($dst);

        return [$nw, $nh];
    }
}
