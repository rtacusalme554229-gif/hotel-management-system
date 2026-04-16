<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
{
    $rooms = Room::latest()->get();
    return view('rooms.index', compact('rooms'));
}

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_no' => 'required|unique:rooms,room_no',
            'room_type' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,occupied,inactive',
        ]);

        Room::create([
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'floor' => $request->floor,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'room_no' => 'required|unique:rooms,room_no,' . $room->id,
            'room_type' => 'required|string|max:255',
            'floor' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,occupied,inactive',
        ]);

        $room->update([
            'room_no' => $request->room_no,
            'room_type' => $request->room_type,
            'floor' => $request->floor,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}