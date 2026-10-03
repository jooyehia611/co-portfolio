<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    public function index()
    {
        return view('admin.technologies.index', ['items' => Technology::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.technologies.form', ['item' => new Technology]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        Technology::create($data);

        return redirect()->route('admin.technologies.index')->with('success', __('admin.messages.technology_created'));
    }

    public function edit(Technology $technology)
    {
        return view('admin.technologies.form', ['item' => $technology]);
    }

    public function update(Request $request, Technology $technology)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $technology->update($data);

        return redirect()->route('admin.technologies.index')->with('success', __('admin.messages.technology_updated'));
    }

    public function destroy(Technology $technology)
    {
        $technology->delete();

        return back()->with('success', __('admin.messages.technology_deleted'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
        ]);
    }
}
