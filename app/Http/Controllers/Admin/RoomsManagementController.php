<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRoomRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;

class RoomsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::with(['type'])->paginate(25);
        $layout = 'full';
        $roomTypes = RoomType::pluck('type', 'id');

        return view('roomsmanagement.index', compact('rooms', 'layout', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::with('type')->paginate(25);
        $layout = 'split';
        $roomTypes = RoomType::pluck('type', 'id');

        return view('roomsmanagement.index', compact('layout', 'rooms', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        $room = $request->processData();
        $room->save();

        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $rooms = Room::with(['type'])->paginate(25);
        $layout = 'split';
        $roomTypes = RoomType::pluck('type', 'id');

        return view('roomsmanagement.index', compact('layout', 'rooms', 'roomTypes', 'room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $rooms = Room::with(['type'])->paginate(25);
        $layout = 'split';
        $e_room = $room;
        $roomTypes = RoomType::pluck('type', 'id');

        return view('roomsmanagement.index', compact('layout', 'rooms', 'roomTypes', 'e_room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $updatedRoom = $request->processData($room);
        $updatedRoom->save();

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRoomRequest $request,Room $room)
    {
        $request->processData($room);

        return redirect()->route('rooms.index');
    }
}
