<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    private function validasiTestimony(Request $request, $imageRule)
    {
        $request->validate(
            [
                'name' => 'required',
                'img' => $imageRule . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required',
                'comment' => 'required',
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

        $path = public_path('dist/assets/img/comments/' . $directory);
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
        $page = 'Testimony';
        $testimonies = Testimony::latest()->get();
        return view('admin.pages.Testimony.index', compact('page', 'testimonies'));
    }

    public function store(Request $request)
    {
        $this->validasiTestimony($request, 'required');
        $image = $this->getImage($request->file('img'), $request->name);
        $data = [
            'name' => request('name'),
            'title' => request('title'),
            'img' => $image,
            'comment' => request('comment'),
        ];
        $testimony = Testimony::create($data);
        if ($testimony) {
            return redirect()->back()->with('success', 'Testimony Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $testimony = Testimony::findOrFail($id);

        $this->validasiTestimony($request, 'sometimes');

        if ($request->hasFile('img')) {
            $this->deleteImage('comments', $testimony->img);
            $image = $this->getImage($request->file('img'), $request->name);
        } else {
            $image = $testimony->img;
        }

        $testimony->update([
            'name' => request('name'),
            'title' => request('title'),
            'img' => $image,
            'comment' => request('comment'),
        ]);

        return redirect()->back()->with('success', 'Testimony Updated Successfully');
    }

    public function destroy($id)
    {
        $testimony = Testimony::findOrFail($id);

        if ($testimony->img) {
            $this->deleteImage('comments', $testimony->img);
        }
        $testimony->delete();

        return redirect()->back()->with('success', 'Testimony Deleted Successfully');
    }
}
