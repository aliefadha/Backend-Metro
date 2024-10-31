<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page = "Dashboard";
        $serviceTotal = Service::count();
        $clientTotal = Client::count();
        $projectTotal = Project::count();
        $ourTeamTotal = Team::count();
        return view('admin.pages.dashboard', compact('page', 'serviceTotal', 'clientTotal', 'projectTotal', 'ourTeamTotal'));
    }
}
