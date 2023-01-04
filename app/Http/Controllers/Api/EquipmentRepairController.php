<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EquipmentRepair;

class EquipmentRepairController extends Controller
{
    //? Index
    public function index()
    {
        //? Join equipment repairs and rooms
        $equipments = EquipmentRepair::join('rooms', 'equipment_repairs.room', '=', 'rooms.room_id')
            ->select(
                'equipment_repairs.*',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
            )
            ->orderBy('equipment_repairs.id', 'desc')
            ->paginate(20);

        return response()->json($equipments, 200);
    }

    //? Search
    public function search(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string',
        ]);

        //? Get search keyword
        $keyword = $field['keyword'];

        //? Join equipment repairs and rooms
        $equipments = EquipmentRepair::join('rooms', 'equipment_repairs.room', '=', 'rooms.room_id')
            ->select(
                'equipment_repairs.*',
                'rooms.room_id',
                'rooms.room_name_th',
                'rooms.room_name_en',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('equip_id', 'LIKE', "%$keyword%")
                    ->orWhere('equip_name', 'LIKE', "%$keyword%");
            })
            ->orderBy('equipment_repairs.id', 'desc')
            ->paginate(20);

        return response()->json($equipments, 200);
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'equip_id' => 'nullable|string',
            'equip_name' => 'required|string',
            'room' => 'required|string|exists:rooms,room_id',
            'initial_symptoms' => 'required|string',
            'image' => 'nullable|image',
            'notifier_name' => 'required|string',
        ]);

        //? Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            //? Generate poster name
            $imageName = 'repair-' . time() . '.' . $image->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Set path to store poster
            $path = 'images/equip-repair/' . $year . '/' . $month;

            //? Move poster to public storage
            $image->move(public_path($path), $imageName);

            //? Set poster name to field
            $fields['image'] =  $year . '/' . $month . '/' . $imageName;
        }

        //? Create equipment repair
        $equipmentRepair = EquipmentRepair::create($fields);

        //? Return response
        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            'data' => $equipmentRepair
        ], 201);
    }
}
