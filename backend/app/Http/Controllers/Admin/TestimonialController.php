<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\VoiceReviewInvite;
use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.testimonials.index', ['items' => Testimonial::orderByRaw("CASE WHEN status = 'draft' THEN 0 ELSE 1 END")->latest()->get()]);
    }

    public function create()
    {
        return view('admin.testimonials.form', [
            'item' => new Testimonial,
            'statuses' => ContentStatus::cases(),
            'projects' => Project::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validated($request));

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.messages.testimonial_created'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', [
            'item' => $testimonial,
            'statuses' => ContentStatus::cases(),
            'projects' => Project::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validated($request));

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.messages.testimonial_updated'));
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->audio_path) Storage::disk('public')->delete($testimonial->audio_path);
        $testimonial->delete();

        return back()->with('success', __('admin.messages.testimonial_deleted'));
    }

    public function createInvite(Request $request)
    {
        $data = $request->validate(['client_name' => 'nullable|string|max:120']);
        $token = bin2hex(random_bytes(32));
        VoiceReviewInvite::create([
            'token_hash' => hash('sha256', $token),
            'client_name' => $data['client_name'] ?? null,
            'expires_at' => now()->addDays(30),
        ]);

        $url = config('app.frontend_url').'/'.app()->getLocale().'/record-review/'.$token;
        return redirect()->route('admin.testimonials.index')->with('invite_url', $url);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_title' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'content_ar' => [$request->route('testimonial')?->audio_path ? 'nullable' : 'required', 'string'],
            'content_en' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'project_id' => 'nullable|exists:projects,id',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published,archived',
            'sort_order' => 'integer|min:0',
        ]);
        $data = Translator::mergeFromRequest($data, ['content']);
        unset($data['content_ar'], $data['content_en']);
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
