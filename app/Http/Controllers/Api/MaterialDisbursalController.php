<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MaterialDisbursal;
use App\Models\Material;

class MaterialDisbursalController extends Controller
{
    //? Index
    public function index()
    {
        $materials = MaterialDisbursal::join('materials', 'material_disbursals.material_id', '=', 'materials.id')
            ->join('personnels', 'material_disbursals.citizen_id', '=', 'personnels.citizen_id')
            ->select(
                'material_disbursals.id',
                'personnels.name_th as disburser',
                'materials.name as material_name',
                'materials.image as material_image',
                'material_disbursals.quantity',
                'material_disbursals.is_del',
            )
            ->where('material_disbursals.is_del', false)
            ->orderBy('material_disbursals.id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Search
    public function search($keyword)
    {
        $materials = MaterialDisbursal::join('materials', 'material_disbursals.material_id', '=', 'materials.id')
            ->join('personnels', 'material_disbursals.citizen_id', '=', 'personnels.citizen_id')
            ->select(
                'material_disbursals.id',
                'personnels.name_th as disburser',
                'materials.name as material_name',
                'materials.image as material_image',
                'material_disbursals.quantity',
                'material_disbursals.is_del',
            )
            ->where('material_disbursals.is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('materials.name', 'LIKE', "%$keyword%")
                    ->orWhere('personnels.name_th', 'LIKE', "%$keyword%")
                    ->orWhere('personnels.citizen_id', 'LIKE', "%$keyword%");
            })
            ->orderBy('material_disbursals.id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Filter by citizen id
    public function filterByCitizenId($citizen_id)
    {
        $materials = MaterialDisbursal::join('materials', 'material_disbursals.material_id', '=', 'materials.id')
            ->join('personnels', 'material_disbursals.citizen_id', '=', 'personnels.citizen_id')
            ->select(
                'material_disbursals.id',
                'personnels.name_th as disburser',
                'materials.name as material_name',
                'materials.image as material_image',
                'material_disbursals.quantity',
                'material_disbursals.is_del',
            )
            ->where('material_disbursals.is_del', false)
            ->where('material_disbursals.citizen_id', $citizen_id)
            ->orderBy('material_disbursals.id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }


    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'citizen_id' => 'required|string|max:13',
            'material_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $material = Material::where('id', $fields['material_id'])
            ->where('is_del', false)
            ->where('status', true)
            ->first();

        if (!$material) {
            //! Material is not found
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลวัสดุอุปกรณ์',
            ], 200);
        } else {
            //? Calculate new quantity
            $oldQuantity = $material->quantity;
            $newQuantity = $oldQuantity - $fields['quantity'];

            //? If new quantity is less than 0
            if ($newQuantity < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ทำรายการไม่สำเร็จ จำนวนวัสดุอุปกรณ์ไม่พอ',
                ], 400);
            } else {
                //? If material quantity is 0, set status to false
                if ($newQuantity == 0) {
                    $material->update([
                        'quantity' => $newQuantity,
                        'status' => false
                    ]);
                } else {
                    $material->update([
                        'quantity' => $newQuantity
                    ]);
                }

                //? Create new material disbursal
                $disbursal = MaterialDisbursal::create($fields);

                return response()->json([
                    'success' => true,
                    'message' => 'บันทึกข้อมูลสำเร็จ',
                    'data' => $disbursal
                ], 200);
            }
        }
    }

    //? Delete
    public function delete($id)
    {
        $disbursal = MaterialDisbursal::findOrFail($id);
        $disbursal->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
