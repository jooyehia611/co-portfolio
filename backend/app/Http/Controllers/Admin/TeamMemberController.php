<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\TeamMember;
use App\Services\MediaService;
use App\Support\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function index()
    {
        return view('admin.team.index', ['items' => TeamMember::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.team.form', ['item' => new TeamMember]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $member = TeamMember::create($data);
        $this->syncPhoto($request, $member);

        return redirect()->route('admin.team.index')->with('success', __('admin.messages.team_created'));
    }

    public function edit(TeamMember $team)
    {
        $team->load('photo');

        return view('admin.team.form', ['item' => $team]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $team->update($data);
        $this->syncPhoto($request, $team);

        return redirect()->route('admin.team.index')->with('success', __('admin.messages.team_updated'));
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();

        return back()->with('success', __('admin.messages.team_deleted'));
    }

    private function validated(Request $request): array
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:5120',
            'photo_alt' => 'nullable|string|max:255',
            'remove_photo' => 'boolean',
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role_ar' => 'required|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'email' => 'nullable|email',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);
        $data = Translator::mergeFromRequest($data, ['role', 'bio']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function syncPhoto(Request $request, TeamMember $member): void
    {
        if ($request->boolean('remove_photo')) {
            $member->update(['photo_id' => null]);

            return;
        }

        if ($request->hasFile('photo')) {
            $media = $this->mediaService->upload(
                $request->file('photo'),
                $request->input('photo_alt'),
                'team'
            );
            $member->update(['photo_id' => $media->id]);

            return;
        }

        if ($member->photo_id && $request->filled('photo_alt')) {
            MediaFile::whereKey($member->photo_id)->update([
                'alt_text' => $request->input('photo_alt'),
            ]);
        }
    }
}
