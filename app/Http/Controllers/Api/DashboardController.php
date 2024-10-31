<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $clientTotal = Client::count();
            $projectTotal = Project::count();

            $dashboardData = [
                'clientTotal'  => $clientTotal,
                'clientDesc' => 'Klien Terselesaikan',
                'projectTotal' => $projectTotal,
                'projectDesc'  => 'Project Terselesaikan',
                'workhours'    => $projectTotal * 16,
                'workhoursDesc' => 'Jam Kerja',
            ];

            return new DashboardResource(true, 'Dashboard data fetched successfully', $dashboardData);
        } catch (\Exception $e) {

            return new DashboardResource(false, 'Failed to fetch dashboard data', null);
        }
    }
}
