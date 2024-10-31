<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private function validasiTeam(Request $request, $imageRule)
    {
        $request->validate(
            [
                'name' => 'required',
                'img' => $imageRule . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'skill' => 'required',
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

        $path = public_path('dist/assets/img/teams/' . $directory);
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
        $page = 'Team';
        $skills = Skill::all();
        $teams = Team::with('rSkill')->latest()->get();
        return view('admin.pages.Team.index', compact('page', 'skills', 'teams'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validasiTeam($request, 'required');
        $image = $this->getImage($request->file('img'), $request->name);
        $data = [
            'name' => request('name'),
            'img' => $image,
        ];
        $team = Team::create($data);
        if ($request->has('skill')) {
            $skills = $request->skill;
            $team->rSkill()->attach($skills);
        }
        if ($team) {
            return redirect()->back()->with('success', 'Team Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $team = Team::findOrFail($id);
        $this->validasiTeam($request, 'sometimes');
        if ($request->hasFile('img')) {
            $this->deleteImage('teams', $team->img);
            $image = $this->getImage($request->file('img'), $request->name);
        } else {
            $image = $team->img;
        }
        $team->update([
            'name' => $request->name,
            'img' => $image,
        ]);
        $team->rSkill()->sync($request->skill);
        return redirect()->back()->with('success', 'Team Updated Successfully');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        if ($team->img) {
            $this->deleteImage('teams', $team->img);
        }
        $team->delete();
        return redirect()->back()->with('success', 'Team Deleted Successfully');
    }
}
