<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    private function validasiSkill(Request $request)
    {
        $request->validate(
            [
                'skill' => 'required',
            ]
        );
    }

    public function index()
    {
        $page = 'Skill';
        $skills = Skill::latest()->get();
        return view('admin.pages.Skills.index', compact('page', 'skills'));
    }

    public function store(Request $request)
    {
        $this->validasiSkill($request);
        $data = [
            'skill' => request('skill')
        ];
        $skill = Skill::create($data);
        if ($skill) {
            return redirect()->back()->with('success', 'Skill Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $this->validasiSkill($request);

        $skill->update([
            'skill' => $request->skill,
        ]);

        return redirect()->back()->with('success', 'Skill Updated Successfully');
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return redirect()->back()->with('success', 'Skill Deleted Successfully');
    }
}
