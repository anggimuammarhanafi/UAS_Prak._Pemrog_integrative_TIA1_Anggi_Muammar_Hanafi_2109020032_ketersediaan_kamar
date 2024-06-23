<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return new BookingResource($booking);
    }

    public function store(Request $request)
    {
        $booking = Booking::create($request->all());
        $validatedData = $request->validate([
            'patient_id' => 'required|integer',
            'room_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // tambahkan validasi lain yang diperlukan
        ]);
                
        $booking = new Booking();
    $booking->room_id = $validatedData['room_id'];
    $booking->patient_id = $validatedData['patient_id'];
    $booking->check_in = $validatedData['check_in'];
    $booking->check_out = $validatedData['check_out'];
    $booking->save();

    return response()->json(['message' => 'Booking created successfully']);
    }

    public function checkOut($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->check_out = now();
        $booking->save();

        $room = Room::find($booking->room_id);
        if ($room) {
            $room->status = true;
            $room->save();
        }

        return response()->json($booking);
    }

    public function update(BookingRequest $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validatedData = $request->validated();

        $booking->update($validatedData);

        return response()->json($booking);
    }
}
