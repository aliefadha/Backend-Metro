<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::with('rService')->latest()->get();
            if ($projects->isEmpty()) {
                return new ProjectResource(false, 'No projects found', null);
            }
            return new ProjectResource(true, 'List Data projects', $projects);
        } catch (\Exception $e) {
            return new ProjectResource(false, 'Failed to fetch projects', null);
        }
    }

    public function show($id)
    {
        try {
            $project = Project::with('rService')->find($id);
            if ($project == null) {
                return new ProjectResource(false, 'No project found', null);
            }
            return new ProjectResource(true, 'List Data project', $project);
        } catch (\Exception $e) {
            return new ProjectResource(false, 'Failed to fetch project', null);
        }
    }
}
