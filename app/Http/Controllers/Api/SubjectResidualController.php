<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubjectResidual;

class SubjectResidualController extends Controller
{
    //? Get all subject residuals
    public function index()
    {
        //? Join table subject_residual and table students and personnels
        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->join('personnels', 'subject_residuals.personnel_id', '=', 'personnels.id')
            ->select(
                'subject_residuals.id',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.detail',
                'subject_residuals.status',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name',
                'personnels.tel_number as personnel_tel_number',
                'personnels.email as personnel_email',
                'subject_residuals.is_del',
            )
            ->where('subject_residuals.is_del', false)
            ->paginate(20);

        return response()->json($residuals, 200);
    }

    //? show
    public function residualForShow($id)
    {
        $residual = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->join('personnels', 'subject_residuals.personnel_id', '=', 'personnels.id')
            ->select(
                'subject_residuals.id',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.detail',
                'subject_residuals.status',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name',
                'personnels.tel_number as personnel_tel_number',
                'personnels.email as personnel_email',
                'subject_residuals.is_del',
            )
            ->where('subject_residuals.id', $id)
            ->where('subject_residuals.is_del', false)
            ->first();

        //? Check if the subject residual exists
        if (!$residual) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residual,
            ]);
        }
    }

    //? Get a subject residual for update
    public function residualForUpdate($id)
    {
        $residual = SubjectResidual::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if the subject residual exists
        if (!$residual) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residual,
            ]);
        }
    }

    //? Create a subject residual
    public function store(Request $request)
    {
        $fields = $request->validate([
            'subject_type' => 'required|string',
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
            'section' => 'required|string',
            'detail' => 'required|string',
            'student_id' => 'required|integer',
            'personnel_id' => 'required|integer',
        ]);

        $subjectResidual = SubjectResidual::create($fields);

        return response()->json([
            'success' => true,
            'data' => $subjectResidual
        ], 201);
    }

    //? Update status of subject residual 
    public function updateStatus(Request $request, $id)
    {
        $field = $request->validate([
            'status' => 'required|string',
        ]);

        $residual = SubjectResidual::find($id);

        $residual->update($field);

        return response()->json([
            'success' => true,
            'data' => $residual
        ], 200);
    }
}
