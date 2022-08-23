<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CvPersonnel;

class CvController extends Controller
{
    //? Search by citizen_id
    public function citizenSearch($citizenId)
    {
        $cv = CvPersonnel::where('citizen_id', $citizenId)->first();

        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $cv,
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'citizen_id' => 'required|string|unique:cv_personnels,citizen_id|max:13',
            'bachelor_degree' => 'required|string',
            'masters_degree' => 'nullable|string',
            'doctoral_degree' => 'nullable|string',
            'bio' => 'nullable|string',
            'experience' => 'nullable|string',
            'expertise' => 'nullable|string',
        ]);

        //? Create
        $cv = CvPersonnel::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูล CV สำเร็จ',
            'data' => $cv,
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'bachelor_degree' => 'required|string',
            'masters_degree' => 'nullable|string',
            'doctoral_degree' => 'nullable|string',
            'bio' => 'nullable|string',
            'experience' => 'nullable|string',
            'expertise' => 'nullable|string',
        ]);

        $cv = CvPersonnel::findOrFail($id);

        //? Update
        $cv->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล CV สำเร็จ',
            'data' => $cv,
        ], 200);
    }
}
