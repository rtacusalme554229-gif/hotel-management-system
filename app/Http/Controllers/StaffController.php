<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::whereIn('role', ['staff', 'manager'])->latest()->get();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:staff,manager',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff account created successfully.');
    }

    public function edit($id)
    {
        $staff = User::whereIn('role', ['staff', 'manager'])->findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::whereIn('role', ['staff', 'manager'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'role' => 'required|in:staff,manager',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff account updated successfully.');
    }

    public function destroy($id)
    {
        $staff = User::whereIn('role', ['staff', 'manager'])->findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff account deleted successfully.');
    }
}