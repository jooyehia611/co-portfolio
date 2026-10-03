<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\ProcessStep;
use App\Services\MediaService;
use App\Support\Translator;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.process-steps.index', ['items' => ProcessStep::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.process-steps.form', ['item' => new ProcessStep]);
    }

    public function store(Request $request)
    {
        $step = ProcessStep::create($this->validated($request));
        $this->syncImage($request, $step);

        return redirect()->route('admin.process-steps.index')->with('success', __('admin.messages.process_step_created'));
    }

    public function edit(ProcessStep $process_step)
    {
        $process_step->load('image');

        return view('admin.process-steps.form', ['item' => $process_step]);
    }

    public function update(Request $request, ProcessStep $process_step)
    {
        $process_step->update($this->validated($request));
        $this->syncImage($request, $process_step);

        return redirect()->route('admin.process-steps.index')->with('success', __('admin.messages.process_step_updated'));
    }

    public function destroy(ProcessStep $process_step)
    {
        $process_step->delete();

        return back()->with('success', __('admin.messages.process_step_deleted'));
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'remove_image' => 'boolean',
        ]);

        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'step_number' => 'integer|min:1',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
        ]);

        return Translator::mergeFromRequest($data, ['title', 'description']);
    }

    private function syncImage(Request $request, ProcessStep $step): void
    {
        if ($request->boolean('remove_image')) {
            $step->update(['image_id' => null]);

            return;
        }

        if ($request->hasFile('image')) {
            $media = $this->mediaService->upload(
                $request->file('image'),
                $request->input('image_alt'),
                'process'
            );
            $step->update(['image_id' => $media->id]);

            return;
        }

        if ($step->image_id && $request->filled('image_alt')) {
            MediaFile::whereKey($step->image_id)->update([
                'alt_text' => $request->input('image_alt'),
            ]);
        }
    }
}
