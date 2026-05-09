<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuestProfileController extends Controller
{
    public function edit()
    {
        $guest = Guest::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone_number' => null,
                'address' => null,
                'profile_photo' => null,
            ]
        );

        return view('guest.profile.edit', compact('guest'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $guest = Guest::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => null,
                'address' => null,
                'profile_photo' => null,
            ]
        );

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        $photoPath = $guest->profile_photo;

        if ($request->hasFile('profile_photo')) {
            if ($guest->profile_photo) {
                Storage::disk('public')->delete($guest->profile_photo);
            }

            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $guest->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'profile_photo' => $photoPath,
        ]);

        return redirect()
            ->route('guest.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}