<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Support\Translator;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function index()
    {
        return view('admin.awards.index', ['items' => Award::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.awards.form', ['item' => new Award]);
    }

    public function store(Request $request)
    {
        Award::create($this->validated($request));

        return redirect()->route('admin.awards.index')->with('success', __('admin.messages.award_created'));
    }

    public function edit(Award $award)
    {
        return view('admin.awards.form', ['item' => $award]);
    }

    public function update(Request $request, Award $award)
    {
        $award->update($this->validated($request));

        return redirect()->route('admin.awards.index')->with('success', __('admin.messages.award_updated'));
    }

    public function destroy(Award $award)
    {
        $award->delete();

        return back()->with('success', __('admin.messages.award_deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'year' => 'required|string|max:10',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'platform_ar' => 'nullable|string|max:255',
            'platform_en' => 'nullable|string|max:255',
            'result_ar' => 'nullable|string|max:255',
            'result_en' => 'nullable|string|max:255',
            'link_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = Translator::mergeFromRequest($data, ['title', 'platform', 'result']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
