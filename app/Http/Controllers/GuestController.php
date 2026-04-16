<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::with('user')->latest()->get();
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $guest = Guest::with('user')->findOrFail($id);
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, string $id)
    {
        $guest = Guest::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guest->user->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $guest->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        $guest->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('guests.index')->with('success', 'Guest updated successfully.');
    }

    public function destroy(string $id)
    {
        $guest = Guest::with('user')->findOrFail($id);

        if ($guest->user) {
            $guest->user->delete();
        }

        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}