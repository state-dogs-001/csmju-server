<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\TypeRoom;
use App\Models\Building;

class RoomController extends Controller
{
    //? Get all rooms paginate
    public function index()
    {
        //? Join table personnel, building, type_room
        $rooms = Room::join('personnels', 'personnels.id', '=', 'rooms.personnel_id')
            ->join('buildings', 'buildings.id', '=', 'rooms.building_id')
            ->join('type_rooms', 'type_rooms.id', '=', 'rooms.type_room_id')
            ->select(
                'rooms.id',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
                'rooms.image',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name_th',
                'rooms.amount_seat',
                'rooms.floor',
                'buildings.building',
                'type_rooms.type_room',
                'rooms.is_del',
            )
            ->where('rooms.is_del', false)
            ->orderBy('rooms.id', 'desc')
            ->paginate(20);

        return response()->json($rooms, 200);
    }

    //? Building
    public function building()
    {
        $buildings = Building::all();

        return response()->json([
            'success' => true,
            'data' => $buildings,
        ], 200);
    }

    //? type room
    public function typeRoom()
    {
        $typeRooms = TypeRoom::all();

        return response()->json([
            'success' => true,
            'data' => $typeRooms,
        ], 200);
    }

    //? Show
    public function show($id)
    {
        $room = Room::join('personnels', 'personnels.id', '=', 'rooms.personnel_id')
            ->join('buildings', 'buildings.id', '=', 'rooms.building_id')
            ->join('type_rooms', 'type_rooms.id', '=', 'rooms.type_room_id')
            ->select(
                'rooms.id',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
                'rooms.image',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name_th',
                'rooms.amount_seat',
                'rooms.floor',
                'buildings.building',
                'type_rooms.type_room',
                'rooms.is_del',
            )
            ->where('rooms.id', $id)
            ->where('rooms.is_del', false)
            ->orderBy('rooms.id', 'desc')
            ->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $room
            ], 200);
        }
    }

    //? Show for update
    public function showUpdate($id)
    {
        $room = Room::where('is_del', false)
            ->where('id', $id)
            ->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $room
            ], 200);
        }
    }

    //? Search
    public function search($keyword)
    {
        //? Join table personnel, building, type_room
        $rooms = Room::join('personnels', 'personnels.id', '=', 'rooms.personnel_id')
            ->join('buildings', 'buildings.id', '=', 'rooms.building_id')
            ->join('type_rooms', 'type_rooms.id', '=', 'rooms.type_room_id')
            ->select(
                'rooms.id',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
                'rooms.image',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name_th',
                'rooms.amount_seat',
                'rooms.floor',
                'buildings.building',
                'type_rooms.type_room',
                'rooms.is_del',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('rooms.room_id', 'LIKE', "%$keyword%")
                    ->orWhere('rooms.room_name_th', 'LIKE', "%$keyword%")
                    ->orWhere('rooms.room_name_en', 'LIKE', "%$keyword%")
                    ->orWhere('type_rooms.type_room', 'LIKE', "%$keyword%");
            })
            ->where('rooms.is_del', false)
            ->orderBy('rooms.id', 'desc')
            ->paginate(20);

        return response()->json($rooms, 200);
    }

    //? Type room is 1 or 'ห้องปฏิบัติการ'
    public function labRoom()
    {
        //? Join table personnel, building, type_room
        $rooms = Room::join('personnels', 'personnels.id', '=', 'rooms.personnel_id')
            ->join('buildings', 'buildings.id', '=', 'rooms.building_id')
            ->join('type_rooms', 'type_rooms.id', '=', 'rooms.type_room_id')
            ->select(
                'rooms.id',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
                'rooms.image',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name_th',
                'rooms.amount_seat',
                'rooms.floor',
                'buildings.building',
                'type_rooms.type_room',
                'rooms.is_del',
            )
            ->where('rooms.is_del', false)
            ->where('rooms.type_room_id', 1)
            ->orderBy('rooms.id', 'desc')
            ->get();

        if ($rooms->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $rooms
            ], 200);
        }
    }

    //? Type room is 2 or 'ห้องบรรยาย'
    public function lectureRoom()
    {
        //? Join table personnel, building, type_room
        $rooms = Room::join('personnels', 'personnels.id', '=', 'rooms.personnel_id')
            ->join('buildings', 'buildings.id', '=', 'rooms.building_id')
            ->join('type_rooms', 'type_rooms.id', '=', 'rooms.type_room_id')
            ->select(
                'rooms.id',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
                'rooms.image',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name_th',
                'rooms.amount_seat',
                'rooms.floor',
                'buildings.building',
                'type_rooms.type_room',
                'rooms.is_del',
            )
            ->where('rooms.is_del', false)
            ->where('rooms.type_room_id', 2)
            ->orderBy('rooms.id', 'desc')
            ->get();

        if ($rooms->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $rooms
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        //? When create new data it'll check if room is exist
        $dbCheck = Room::where('is_del', true)
            ->where('room_id', $request->room_id)
            ->first();

        if ($dbCheck) {
            //? If has data, update is_del to false
            $dbCheck->update([
                'is_del' => false,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'update',
                'message' => 'อัพเดตข้อมูลสำเร็จ',
            ], 200);
        } else {
            //? data is not exist, create new data
            $fields = $request->validate([
                'room_id' => 'required|unique:rooms,room_id|string',
                'room_name_th' => 'required|string',
                'room_name_en' => 'nullable|string',
                'personnel_id' => 'required|integer',
                'building_id' => 'required|integer',
                'floor' => 'required|string',
                'amount_seat' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
                'type_room_id' => 'required|integer',
            ]);

            //? Upload image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'room-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/rooms'), $imageName);
                $fields['image'] = $imageName;
            }

            //? Create new data
            $room = Room::create($fields);

            return response()->json([
                'success' => true,
                'status' => 'create',
                'message' => 'เพิ่มข้อมูลสำเร็จ',
                'data' => $room,
            ], 201);
        }
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'room_id' => 'required|string',
            'room_name_th' => 'required|string',
            'room_name_en' => 'nullable|string',
            'personnel_id' => 'required|integer',
            'building_id' => 'required|integer',
            'floor' => 'required|string',
            'amount_seat' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
            'type_room_id' => 'required|integer',
        ]);

        //? Find room by id for update
        $room = Room::findOrFail($id);

        //? Find room by id for check if image is changed
        $dbRoom = DB::table('rooms')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image')) {
            //? Check old image if exist delete old image
            if (File::exists(public_path('images/rooms/' . $dbRoom->image))) {
                File::delete(public_path('images/rooms/' . $dbRoom->image));
            }

            //? Upload new image
            $image = $request->file('image');
            $imageName = 'room-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/rooms'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Update data
        $room->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'อัพเดตข้อมูลสำเร็จ',
            'data' => $room,
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        //? Find personnel by id
        $room = Room::findOrFail($id);
        $room->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
