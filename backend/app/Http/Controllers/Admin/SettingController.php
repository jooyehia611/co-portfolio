<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\Setting;
use App\Services\MediaService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        $mediaFiles = MediaFile::whereIn(
            'id',
            $settings->where('type', 'media')->pluck('value')->filter()->map(fn ($id) => (int) $id)
        )->get()->keyBy('id');

        return view('admin.settings.index', [
            'settings' => $settings,
            'mediaFiles' => $mediaFiles,
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $id => $value) {
            Setting::where('id', $id)->where('type', '!=', 'media')->update(['value' => $value]);
        }

        foreach ($request->input('settings_bilingual', []) as $id => $data) {
            Setting::where('id', $id)->update([
                'value' => json_encode([
                    'ar' => $data['ar'] ?? '',
                    'en' => $data['en'] ?? '',
                ], JSON_UNESCAPED_UNICODE),
            ]);
        }

        foreach (Setting::where('type', 'media')->get() as $setting) {
            $fileKey = 'media_'.$setting->key;
            $removeKey = 'remove_media_'.$setting->key;
            $altKey = 'media_alt_'.$setting->key;

            if ($request->boolean($removeKey)) {
                $setting->update(['value' => null]);
                continue;
            }

            if ($request->hasFile($fileKey)) {
                $media = $this->mediaService->upload(
                    $request->file($fileKey),
                    $request->input($altKey),
                    'brand'
                );
                $setting->update(['value' => (string) $media->id]);
                continue;
            }

            if ($setting->value && $request->filled($altKey)) {
                MediaFile::whereKey((int) $setting->value)->update([
                    'alt_text' => $request->input($altKey),
                ]);
            }
        }

        return back()->with('success', __('admin.messages.settings_updated'));
    }
}
