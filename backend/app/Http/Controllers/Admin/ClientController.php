<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.clients.index', ['items' => Client::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.clients.form', ['item' => new Client]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', __('admin.messages.client_created'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.form', ['item' => $client]);
    }

    public function update(Request $request, Client $client)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', __('admin.messages.client_updated'));
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return back()->with('success', __('admin.messages.client_deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
