<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        try {
            $teams = Team::with('rSkill')->latest()->get();
            if ($teams->isEmpty()) {
                return new TeamResource(false, 'No teams found', null);
            }
            return new TeamResource(true, 'List Data teams', $teams);
        } catch (\Exception $e) {
            return new TeamResource(false, 'Failed to fetch teams', null);
        }
    }
}
