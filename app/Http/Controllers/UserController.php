<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private function validasiInputData(Request $request, $passwordRule)
    {
        $request->validate(
            [
                'name' => 'required',
                'gender' => 'required',
                'email' => 'required|email',
                'password' => $passwordRule,
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'gender.required' => 'Gender wajib dipilih',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email harus berupa email',
                'password.required' => 'Password wajib diisi',
            ],
        );
    }

    public function index()
    {
        $page = 'Users';
        $users = User::get();
        return view('admin.pages.User.index', compact('page', 'users'));
    }

    public function store(Request $request)
    {
        $this->validasiInputData($request, 'required');

        user::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'role' => 'Admin',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.show')->with('success', 'User Added Successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->validasiInputData($request, 'sometimes');

        $update = User::find($id);
        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'role' => 'Admin',
        ];
        if ($request->password == null) {
            User::updateOrCreate(['id' => $update->id], $data);
        } else {
            $data['password'] = Hash::make($request->password);
            User::updateOrCreate(['id' => $update->id], $data);
        }
        return redirect()->route('user.show')->with('success', 'User Updated Successfully');
    }

    public function destroy($id)
    {
        $destroy = User::find($id);
        $destroy->delete();
        return redirect()->route('user.show')->with('success', 'User Deleted Successfully');
    }
}
