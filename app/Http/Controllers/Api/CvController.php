<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CvPersonnel;
use App\Models\Personnel;

class CvController extends Controller
{
    //? Search by citizen_id
    public function citizenSearch($citizenId)
    {
        //? Join table personnels with citizen_id
        $cv = CvPersonnel::join('personnels', 'cv_personnels.citizen_id', '=', 'personnels.citizen_id')
            ->select(
                'cv_personnels.*',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.position_academic',
                'personnels.position_manager',
                'personnels.image_profile',
                'personnels.email',
                'personnels.tel_number',
                'personnels.education',
                'personnels.personnel_type',
            )
            ->where('cv_personnels.citizen_id', $citizenId)
            ->first();

        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
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
            'workplace' => 'nullable|string',
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'experts' => 'nullable|array',
            'experiences' => 'nullable|array',
            'researches' => 'nullable|array',
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
            'citizen_id' => 'required|string|max:13',
            'workplace' => 'nullable|string',
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'experts' => 'nullable|array',
            'experiences' => 'nullable|array',
            'researches' => 'nullable|array',
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
