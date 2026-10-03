<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactLead;
use Illuminate\Http\Request;

class ContactLeadController extends Controller
{
    public function index()
    {
        return view('admin.leads.index', ['items' => ContactLead::with(['service'])->latest()->get()]);
    }

    public function show(ContactLead $lead)
    {
        return view('admin.leads.show', ['lead' => $lead->load(['service'])]);
    }

    public function update(Request $request, ContactLead $lead)
    {
        $data = $request->validate(['status' => 'required|string']);
        $lead->update($data);

        return back()->with('success', __('admin.messages.lead_updated'));
    }

    public function destroy(ContactLead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', __('admin.messages.lead_deleted'));
    }
}
