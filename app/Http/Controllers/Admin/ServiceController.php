<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private function validasiService(Request $request, $imageRule)
    {
        $request->validate(
            [
                'title' => 'required',
                'img' => $imageRule . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        $path = public_path('dist/assets/img/services/' . $directory);
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
        $page = 'Service';
        $services = Service::latest()->get();
        return view('admin.pages.Service.index', compact('page', 'services'));
    }

    public function store(Request $request)
    {
        $this->validasiService($request, 'required');
        $image = $this->getImage($request->file('img'), $request->title);
        $data = [
            'title' => request('title'),
            'img' => $image,
            'description' => request('description'),
        ];
        $service = Service::create($data);
        if ($service) {
            return redirect()->back()->with('success', 'Service Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $this->validasiService($request, 'sometimes');

        if ($request->hasFile('img')) {
            $this->deleteImage('services', $service->img);
            $image = $this->getImage($request->file('img'), $request->title);
        } else {
            $image = $service->img;
        }

        $service->update([
            'title' => $request->title,
            'img' => $image,
            'description' => request('description'),
        ]);

        return redirect()->back()->with('success', 'Service Updated Successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->img) {
            $this->deleteImage('services', $service->img);
        }
        $service->delete();

        return redirect()->back()->with('success', 'Service Deleted Successfully');
    }
}
