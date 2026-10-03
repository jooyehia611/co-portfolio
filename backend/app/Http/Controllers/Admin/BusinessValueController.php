<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessValue;
use App\Support\Translator;
use Illuminate\Http\Request;

class BusinessValueController extends Controller
{
    public function index()
    {
        return view('admin.business-values.index', ['items' => BusinessValue::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.business-values.form', ['item' => new BusinessValue]);
    }

    public function store(Request $request)
    {
        BusinessValue::create($this->validated($request));

        return redirect()->route('admin.business-values.index')->with('success', __('admin.messages.business_value_created'));
    }

    public function edit(BusinessValue $business_value)
    {
        return view('admin.business-values.form', ['item' => $business_value]);
    }

    public function update(Request $request, BusinessValue $business_value)
    {
        $business_value->update($this->validated($request));

        return redirect()->route('admin.business-values.index')->with('success', __('admin.messages.business_value_updated'));
    }

    public function destroy(BusinessValue $business_value)
    {
        $business_value->delete();

        return back()->with('success', __('admin.messages.business_value_deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
        ]);

        return Translator::mergeFromRequest($data, ['title', 'description']);
    }
}
