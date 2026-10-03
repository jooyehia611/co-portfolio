<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use App\Support\Translator;
use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    public function index()
    {
        return view('admin.seo.index', ['items' => SeoPage::all()]);
    }

    public function edit(SeoPage $seo)
    {
        return view('admin.seo.form', ['item' => $seo]);
    }

    public function update(Request $request, SeoPage $seo)
    {
        $data = $request->validate([
            'page_title_ar' => 'nullable|string|max:255',
            'page_title_en' => 'nullable|string|max:255',
            'page_description_ar' => 'nullable|string',
            'page_description_en' => 'nullable|string',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string',
            'meta_description_en' => 'nullable|string',
            'og_title_ar' => 'nullable|string|max:255',
            'og_title_en' => 'nullable|string|max:255',
            'og_description_ar' => 'nullable|string',
            'og_description_en' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'is_indexable' => 'boolean',
        ]);
        $data = Translator::mergeFromRequest($data, [
            'page_title', 'page_description', 'meta_title', 'meta_description', 'og_title', 'og_description',
        ]);
        $data['is_indexable'] = $request->boolean('is_indexable');
        $seo->update($data);

        return redirect()->route('admin.seo.index')->with('success', __('admin.messages.seo_updated'));
    }
}
