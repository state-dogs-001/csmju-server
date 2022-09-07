<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Equipment;
use App\Models\EquipmentStatus;

class EquipmentController extends Controller
{
    //? Index (Paginate)
    public function index()
    {
        $equipments = Equipment::join('equipment_status', 'equipment_status.id', '=', 'equipment.status_id')
            ->join('personnels', 'personnels.id', '=', 'equipment.personnel_id')
            ->join('rooms', 'rooms.room_id', '=', 'equipment.room_id')
            ->select(
                'equipment.id',
                'equipment.equip_id',
                'equipment.serial_number',
                'equipment.name',
                'equipment.model',
                'equipment.detail',
                'equipment.price',
                'equipment.quantity',
                'equipment.main_type',
                'equipment.sub_type',
                'equipment.purchase_date',
                'equipment.purchase_from',
                'equipment.budget',
                'equipment.note',
                'equipment_status.status',
                'personnels.name_title',
                'personnels.name_th',
                'rooms.room_id',
                'rooms.room_name_th',
                'equipment.is_del'
            )
            ->where('equipment.is_del', false)
            ->orderBy('equipment.purchase_date', 'desc')
            ->paginate(20);

        return response()->json($equipments, 200);
    }

    //? Show For Read
    public function show($id)
    {
        $equipment = Equipment::join('equipment_status', 'equipment_status.id', '=', 'equipment.status_id')
            ->join('personnels', 'personnels.id', '=', 'equipment.personnel_id')
            ->join('rooms', 'rooms.room_id', '=', 'equipment.room_id')
            ->select(
                'equipment.id',
                'equipment.equip_id',
                'equipment.serial_number',
                'equipment.name',
                'equipment.model',
                'equipment.detail',
                'equipment.price',
                'equipment.quantity',
                'equipment.main_type',
                'equipment.sub_type',
                'equipment.purchase_date',
                'equipment.purchase_from',
                'equipment.budget',
                'equipment.note',
                'equipment_status.status',
                'personnels.name_title',
                'personnels.name_th',
                'rooms.room_id',
                'rooms.room_name_th',
                'equipment.is_del'
            )
            ->where('equipment.is_del', false)
            ->where('equipment.id', $id)
            ->first();

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $equipment
            ], 200);
        }
    }

    //? Show For Update
    public function showUpdate($id)
    {
        $equipment = Equipment::findOrfail($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $equipment
            ], 200);
        }
    }

    //? Search (Paginate)
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        //? Use Request because some keyword has '/' it cannot use with api
        $keyword = $request->search;

        $equipment = Equipment::join('equipment_status', 'equipment_status.id', '=', 'equipment.status_id')
            ->join('personnels', 'personnels.id', '=', 'equipment.personnel_id')
            ->join('rooms', 'rooms.room_id', '=', 'equipment.room_id')
            ->select(
                'equipment.id',
                'equipment.equip_id',
                'equipment.serial_number',
                'equipment.name',
                'equipment.model',
                'equipment.detail',
                'equipment.price',
                'equipment.quantity',
                'equipment.main_type',
                'equipment.sub_type',
                'equipment.purchase_date',
                'equipment.purchase_from',
                'equipment.budget',
                'equipment.note',
                'equipment_status.status',
                'personnels.name_title',
                'personnels.name_th',
                'rooms.room_id',
                'rooms.room_name_th',
                'equipment.is_del'
            )
            ->where('equipment.is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('equipment.equip_id', 'LIKE', "%$keyword%")
                    ->orWhere('equipment.name', 'LIKE', "%$keyword%")
                    ->orWhere('equipment.main_type', 'LIKE', "%$keyword%")
                    ->orWhere('equipment.sub_type', 'LIKE', "%$keyword%")
                    ->orWhere('equipment.budget', 'LIKE', "%$keyword%")
                    ->orWhere('rooms.room_id', 'LIKE', "%$keyword%")
                    ->orWhere('rooms.room_name_th', 'LIKE', "%$keyword%");
            })
            ->orderBy('equipment.purchase_date', 'desc')
            ->paginate(20);

        return response()->json($equipment, 200);
    }

    //? Equipment Status
    public function equipmentStatus()
    {
        $equipmentStatus = EquipmentStatus::all();

        return response()->json([
            'success' => true,
            'data' => $equipmentStatus
        ], 200);
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'equip_id' => 'required|string|unique:equipment,equip_id',
            'serial_number' => 'nullable|string',
            'name' => 'required|string',
            'model' => 'nullable|string',
            'detail' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|string',
            'main_type' => 'required|string',
            'sub_type' => 'nullable|string',
            'purchase_date' => 'required|date|date_format:Y-m-d',
            'purchase_from' => 'nullable|string',
            'budget' => 'required|string',
            'note' => 'nullable|string',
            'status_id' => 'required|integer',
            'personnel_id' => 'required|integer',
            'room_id' => 'required|string',
        ]);

        //? Create Equipment
        $equipment = Equipment::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มข้อมูลครุภัณฑ์สำเร็จ',
            'data' => $equipment
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrfail($id);

        $fields = $request->validate([
            'equip_id' => 'required|string',
            'serial_number' => 'nullable|string',
            'name' => 'required|string',
            'model' => 'nullable|string',
            'detail' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|string',
            'main_type' => 'required|string',
            'sub_type' => 'nullable|string',
            'purchase_date' => 'required|date|date_format:Y-m-d',
            'purchase_from' => 'nullable|string',
            'budget' => 'required|string',
            'note' => 'nullable|string',
            'status_id' => 'required|integer',
            'personnel_id' => 'required|integer',
            'room_id' => 'required|string',
        ]);

        //? Update Equipment
        $equipment->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลครุภัณฑ์สำเร็จ',
            'data' => $equipment
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        $equipment = Equipment::findOrfail($id);
        $equipment->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลครุภัณฑ์สำเร็จ'
        ], 200);
    }
}
