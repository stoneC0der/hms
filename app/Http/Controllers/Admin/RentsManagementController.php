<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRentRequest;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Rent;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentsManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rents = Rent::paginate(25);
        $layout = 'full';
        $rooms  = Room::pluck('room_number', 'id');
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('rentsmanagement.index', compact('rents', 'layout', 'rooms', 'occupations', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rents = Rent::paginate(25);
        $layout = 'split';
        $rooms  = Room::allAvailable()->pluck('room_number', 'id');
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('rentsmanagement.index', compact('layout', 'rents', 'rooms', 'occupations', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $newRentInfos = $request->processData();
            // dd($newRentInfos);
            $newTenant = $newRentInfos['tenant'];
            $newRent = $newRentInfos['rent'];

            $alreadyBooked = Rent::where('room_id', $newRent['room_id'])->get();
            // dd($alreadyBooked);
            // if ($alreadyBooked) {
            //     // dd($newRentInfos['room_type'] == 'double');
            //     if ($alreadyBooked->first()->room_type->type == 'single') {
            //         return back()->with('error', 'room full!');
            //     }elseif ($alreadyBooked->first()->room_type->type == 'double' && $alreadyBooked->count() == 2) {
            //         return back()->with('error', 'room full!');
            //     }
            // }
            if($newRentInfos['room_type'] == 'single') {
                $tenant = Tenant::create($newTenant);
                $newRent['tenant_id'] = $tenant->id; // TODO:  Auto attach tenant_id by defining a belongs to relation in \App\Models\Rent
                $rent = Rent::create($newRent);
                $room = Room::where('id', $rent->room_id)->first();
                $room->is_available = boolval(false);
                $room->save();
            }elseif($newRentInfos['room_type'] == 'double') {

                // dd($newRentInfos['room_type'] == 'double');
                if ($alreadyBooked->count() == 0) {
                    // dd($newRentInfos['room_type'] == 'double', 'has no room');
                    $tenant = Tenant::create($newTenant);
                    $newRent['tenant_id'] = $tenant->id;
                    $rent = Rent::create($newRent);
                }else {
                    // dd($newRentInfos['room_type'] == 'double', 'has a least 1 room');
                    $tenant = Tenant::create($newTenant);
                    $newRent['tenant_id'] = $tenant->id;
                    $rent = Rent::create($newRent);
                    $room = Room::where('id', $rent->room_id)->first();
                    $room->is_available = boolval(false);
                    $room->save();
                }
            }
        });

        return redirect()->route('rents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        $rents = Rent::paginate(25);
        $layout = 'split';
        $rooms  = Room::pluck('room_number', 'id');
        $roomTypes = RoomType::pluck('type', 'price');
        return view('rentsmanagement.index', compact('layout', 'rents', 'rooms', 'roomTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        $rents = Rent::paginate(25);
        $layout = 'split';
        $rooms  = Room::available($rent->room_type_id, $rent->room_id)->pluck('room_number', 'id');
        $booked = $rent;
        $occupations = ['student' => 'Student', 'worker' => 'Worker'];
        $roomTypes = RoomType::pluck('type', 'price');

        return view('rentsmanagement.index', compact('layout', 'rents', 'rooms', 'booked', 'occupations', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        $updatedRent = $request->processData($rent);
        $updatedRent->save();

        return redirect()->route('rents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRentRequest $request, Rent $rent)
    {
        DB::transaction(function () use ($rent) {
            $room = $rent->room;
            $rent->delete();
            $room->is_available = boolval(true);
            $room->save();
        });
        return redirect()->route('rents.index');
    }

    /**
     * Get All available rooms of a given type (of room)
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableRooms(Request $request)
    {
        // FIXME:  The current user room should not return if type of room has change while editing.
        if ($request->ajax()) {
            $roomInfos =json_decode(file_get_contents('php://input'));
            
            $validator = Validator::make((array)$roomInfos,[
                'room_price' => 'required|exists:room_types,price',
                'room_id'   => 'nullable|exists:rooms,id',
            ],[
                'room_type.require' => 'Room type no provided!',
                'room_type.exists'  => 'Room type no found!',
                'room_id.exists'    => 'The room is not available',
            ]);

            if ($validator->fails()) {
                return response()->json(['data' => ['status' => '412', 'message' => 'Unprocessed data.', 'errors' => $validator->errors()]],Response::HTTP_OK, ['Status' => 412]);
            }

            $room_type = RoomType::where('price', $roomInfos->room_price)->first()->id;
            if ($roomInfos->room_id) {
                $room = Room::where('id', $roomInfos->room_id)->first()->id;
            }else {
                $room = null;
            }
            $available_rooms = Room::available($room_type, $room)->pluck('room_number', 'id');
            $data = [
                'message' => 'Success!',
                'rooms' => $available_rooms,
                'status'    => Response::HTTP_OK,
                'errors' => [],
            ];
            return response()->json(['data' => $data],Response::HTTP_OK);
        }
        return response()->json(['data' => ['status' => '400', 'message' => 'Invalid request.']],Response::HTTP_OK, ['Status' => '400']);
    }
}
