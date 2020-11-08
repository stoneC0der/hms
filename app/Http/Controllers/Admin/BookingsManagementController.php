<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::paginate(25);
        $layout = 'full';
        $rooms  = Room::pluck('room_number', 'id');
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('bookingsmanagement.index', compact('bookings', 'layout', 'rooms', 'occupations', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bookings = Booking::paginate(25);
        $layout = 'split';
        $rooms  = Room::available()->pluck('room_number', 'id');
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('bookingsmanagement.index', compact('layout', 'bookings', 'rooms', 'occupations', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $updatedBooking = $request->processData();
        $updatedBooking->save();

        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $bookings = Booking::paginate(25);
        $layout = 'split';
        $rooms  = Room::pluck('room_number', 'id');
        $roomTypes = RoomType::pluck('type', 'price');
        return view('bookingsmanagement.index', compact('layout', 'bookings', 'rooms', 'roomTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $bookings = Booking::paginate(25);
        $layout = 'split';
        $rooms  = Room::available($booking->room_id)->pluck('room_number', 'id');
        $booked = $booking;
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('bookingsmanagement.index', compact('layout', 'bookings', 'rooms', 'booked', 'occupations', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $updatedBooking = $request->processData($booking);
        $updatedBooking->save();

        return redirect()->route('bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteBookingRequest $request, Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index');
    }

    public function availableRooms(Request $request)
    {
        if ($request->ajax()) {
            $room_price =json_decode(file_get_contents('php://input'));
            $room_type = RoomType::where('price', $room_price->room_price)->first()->id;
            $available_rooms = Room::available($room_type)->pluck('room_number', 'id');
            $data = [
                'message' => 'Success!',
                'rooms' => $available_rooms,
                'status'    => Response::HTTP_OK,
            ];
            return response()->json(['data' => $data],Response::HTTP_OK);
        }
        return response()->json(['data' => ['status' => '400', 'message' => 'Invalid request.', 'rooms' => []]],Response::HTTP_OK);
    }
}
