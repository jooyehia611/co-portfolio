<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaFileController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.media.index', ['items' => MediaFile::latest()->paginate(24)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $this->mediaService->upload($request->file('file'), $request->input('alt_text'));

        return back()->with('success', __('admin.messages.file_uploaded'));
    }

    public function destroy(MediaFile $medium)
    {
        $this->mediaService->delete($medium);

        return back()->with('success', __('admin.messages.file_deleted'));
    }
}
