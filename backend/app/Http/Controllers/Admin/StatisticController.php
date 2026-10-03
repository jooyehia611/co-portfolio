<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Support\Translator;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        return view('admin.statistics.index', ['items' => Statistic::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.statistics.form', ['item' => new Statistic]);
    }

    public function store(Request $request)
    {
        Statistic::create($this->validated($request));

        return redirect()->route('admin.statistics.index')->with('success', __('admin.messages.statistic_created'));
    }

    public function edit(Statistic $statistic)
    {
        return view('admin.statistics.form', ['item' => $statistic]);
    }

    public function update(Request $request, Statistic $statistic)
    {
        $statistic->update($this->validated($request));

        return redirect()->route('admin.statistics.index')->with('success', __('admin.messages.statistic_updated'));
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();

        return back()->with('success', __('admin.messages.statistic_deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'label_ar' => 'required|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
        ]);

        return Translator::mergeFromRequest($data, ['label']);
    }
}
