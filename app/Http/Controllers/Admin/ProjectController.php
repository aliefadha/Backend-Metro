<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function validasiProject(Request $request, $imageRule)
    {
        $request->validate(
            [
                'title' => 'required',
                'img' => $imageRule . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'service' => 'required',
                'description' => 'required',
            ]
        );
    }

    private function getImage($image, $name, $directory = '')
    {
        if ($image == null) {
            return null;
        }
        $extension = $image->getClientOriginalExtension();

        $timestamp = date('Ymd_His');
        $filename = preg_replace('/\s+/', '_', $name) . '_' . $timestamp . '.' . $extension;

        $path = public_path('dist/assets/img/projects/' . $directory);
        $image->move($path, $filename);
        return $filename;
    }

    private function deleteImage($folder, $filename)
    {
        $path = public_path("dist/assets/img/$folder/$filename");
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function index()
    {
        $page = 'Project';
        $services = Service::all();
        $projects = Project::with('rService')->latest()->get();
        return view('admin.pages.Project.index', compact('page', 'services', 'projects'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validasiProject($request, 'required');
        $image = $this->getImage($request->file('img'), $request->title);
        $data = [
            'title' => request('title'),
            'img' => $image,
            'description' => request('description'),
            'link' => request('link'),
        ];
        $project = Project::create($data);
        if ($request->has('service')) {
            $services = $request->service;
            $project->rService()->attach($services);
        }
        if ($project) {
            return redirect()->back()->with('success', 'Project Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $project = Project::findOrFail($id);
        $this->validasiProject($request, 'sometimes');
        if ($request->hasFile('img')) {
            $this->deleteImage('projects', $project->img);
            $image = $this->getImage($request->file('img'), $request->title);
        } else {
            $image = $project->img;
        }
        $project->update([
            'title' => $request->title,
            'img' => $image,
            'description' => request('description'),
            'link' => request('link'),

        ]);
        $project->rService()->sync($request->service);
        return redirect()->back()->with('success', 'Project Updated Successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        if ($project->img) {
            $this->deleteImage('projects', $project->img);
        }
        $project->delete();
        return redirect()->back()->with('success', 'Project Deleted Successfully');
    }
}
