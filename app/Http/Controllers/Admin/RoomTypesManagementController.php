<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRoomTypeRequest;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;

class RoomTypesManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomTypes   = RoomType::all();
        $layout      = 'full';

        return view('roomtypesmanagement.index', compact('roomTypes', 'layout'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $layout = 'split';
        $roomTypes   = RoomType::all();

        return view('roomtypesmanagement.index', compact('layout', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $roomType = $request->processData();
        
        $roomType->save();

        return redirect()->route('roomTypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomType $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $roomType)
    {
        $roomTypes   = RoomType::all();
        $layout = 'split';

        return view('roomtypesmanagement.index', compact('roomType', 'roomTypes', 'layout'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomType $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        $roomTypes   = RoomType::all();
        $layout = 'split';
        $room_type = $roomType;
        return view('roomtypesmanagement.index', compact('room_type', 'roomTypes', 'layout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomType $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $updatedRoomType = $request->processData($roomType);

        $updatedRoomType->save();

        return redirect()->route('roomTypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomType $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRoomTypeRequest $request, RoomType $roomType)
    {
        $request->processData($roomType);

        return redirect()->route('roomTypes.index');
    }
}
