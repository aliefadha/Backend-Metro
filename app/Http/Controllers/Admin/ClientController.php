<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private function validasiClient(Request $request, $imageRule)
    {
        $request->validate(
            [
                'title' => 'required',
                'img' => $imageRule . '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'desc' => 'required',
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

        $path = public_path('dist/assets/img/clients/' . $directory);
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
        $page = 'Clients';
        $clients = Client::latest()->get();
        return view('admin.pages.Clients.index', compact('page', 'clients'));
    }

    public function store(Request $request)
    {
        $this->validasiClient($request, 'required');
        $image = $this->getImage($request->file('img'), $request->title);
        $data = [
            'title' => request('title'),
            'img' => $image,
            'desc' => request('desc'),
        ];
        $client = Client::create($data);
        if ($client) {
            return redirect()->back()->with('success', 'Client Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $this->validasiClient($request, 'sometimes');

        if ($request->hasFile('img')) {
            $this->deleteImage('clients', $client->img);
            $image = $this->getImage($request->file('img'), $request->title);
        } else {
            $image = $client->img;
        }

        $client->update([
            'title' => $request->title,
            'img' => $image,
            'desc' => request('desc'),
        ]);

        return redirect()->back()->with('success', 'Client Updated Successfully');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        if ($client->img) {
            $this->deleteImage('clients', $client->img);
        }
        $client->delete();

        return redirect()->back()->with('success', 'Client Deleted Successfully');
    }
}
