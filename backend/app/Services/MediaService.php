<?php

namespace App\Services;

use App\Models\MediaFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function upload(UploadedFile $file, ?string $altText = null, string $directory = 'uploads'): MediaFile
    {
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');

        return MediaFile::create([
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt_text' => $altText,
            'disk' => 'public',
        ]);
    }

    public function delete(MediaFile $mediaFile): bool
    {
        Storage::disk($mediaFile->disk)->delete($mediaFile->path);

        return $mediaFile->delete();
    }
}
