<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactLead;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'services' => Service::count(),
                'leads' => ContactLead::count(),
                'new_leads' => ContactLead::where('status', 'new')->count(),
                'users' => User::count(),
            ],
            'recent_leads' => ContactLead::latest()->limit(5)->get(),
        ]);
    }
}
