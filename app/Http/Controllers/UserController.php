<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users_admin', compact('users'));
    }

    public function operator()
    {
        $users = User::where('role', 'operator')->get();
        return view('admin.users_operator', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
        ]);

        $emailPart = substr($request->email, 0, 4);
        $lastId = User::max('id') + 1;
        $passwordPlain = $emailPart . $lastId;
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($passwordPlain),
        ]);
        return redirect()->back()->with('success', 'ini adalah password kamu = ' . $passwordPlain);
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('operator.users_edit', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('operator.profile', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->back()->with('success', 'User updated berhasil.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        // password baru
        $newPassword = Str::random(8);

        // update password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
        return back()->with('reset_password', $newPassword);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}