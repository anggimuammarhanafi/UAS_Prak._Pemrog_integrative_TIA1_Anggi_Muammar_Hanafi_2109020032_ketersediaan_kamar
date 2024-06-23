<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(5);

        //return collection of posts as a resource
        return new RoomResource(true, 'List Data Rooms', $rooms);
    }

    public function show($id)
    {
        $rooms = Room::find($id);

        //return single post as a resource
        return new RoomResource(true, 'Detail Data Room', $rooms);
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());
        return response()->json($room, 201);
    }

    public function updateStatus($id, $status)
    {
        $room = Room::find($id);
        $room->status = $status;
        $room->save();

        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        // Validasi request jika diperlukan
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,'.$id,
            'level' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|boolean',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Update data kamar
        $room->update($request->all());

        return response()->json($room);
    }
}