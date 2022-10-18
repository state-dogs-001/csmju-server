<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubjectResidual;

class SubjectResidualController extends Controller
{
    //? Get all subject residuals paginate
    public function index()
    {
        //? Join table subject_residual and table students and personnels
        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.is_del', false)
            ->orderBy('subject_residuals.id', 'desc')
            ->paginate(20);

        return response()->json($residuals, 200);
    }

    //? Get all subject residuals not paginate
    public function indexNotPaginate()
    {
        //? Join table subject_residual and table students and personnels
        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.is_del', false)
            ->orderBy('subject_residuals.id', 'desc')
            ->get();

        if (!$residuals) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residuals,
            ], 200);
        }
    }

    //? show
    public function residualForShow($id)
    {
        $residual = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.id', $id)
            ->where('subject_residuals.is_del', false)
            ->first();

        //? Check if the subject residual exists
        if (!$residual) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residual,
            ], 200);
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
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residual,
            ], 200);
        }
    }

    //? Search by keyword
    public function searchByKeyword(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $field['keyword'];

        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('students.student_code', 'LIKE', "%{$keyword}%")
                    ->orWhere('students.name_th', 'LIKE', "%{$keyword}%")
                    ->orWhere('subject_residuals.subject_code', 'LIKE', "%{$keyword}%")
                    ->orWhere('subject_residuals.subject_name', 'LIKE', "%{$keyword}%");
            })
            ->paginate(20);

        return response()->json($residuals, 201);
    }

    //? Filter by dates (Paginate)
    public function datesFilter(Request $request)
    {
        $fields = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'keyword' => 'nullable|string',
        ]);

        if (!$request->has('keyword')) {
            $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
                ->select(
                    'subject_residuals.id',
                    'students.student_code',
                    'students.name_th as student_name',
                    'students.tel_number as student_tel_number',
                    'students.email as student_email',
                    'subject_residuals.subject_type',
                    'subject_residuals.subject_code',
                    'subject_residuals.subject_name',
                    'subject_residuals.section',
                    'subject_residuals.advisor',
                    'subject_residuals.detail',
                    'subject_residuals.status',
                    'subject_residuals.is_del',
                    'subject_residuals.created_at as date',
                )
                ->where('subject_residuals.is_del', false)
                ->whereBetween('subject_residuals.created_at', [$fields['start_date'], $fields['end_date']])
                ->paginate(20);
        } else {
            $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
                ->select(
                    'subject_residuals.id',
                    'students.student_code',
                    'students.name_th as student_name',
                    'students.tel_number as student_tel_number',
                    'students.email as student_email',
                    'subject_residuals.subject_type',
                    'subject_residuals.subject_code',
                    'subject_residuals.subject_name',
                    'subject_residuals.section',
                    'subject_residuals.advisor',
                    'subject_residuals.detail',
                    'subject_residuals.status',
                    'subject_residuals.is_del',
                    'subject_residuals.created_at as date',
                )
                ->where('subject_residuals.is_del', false)
                ->where(function ($query) use ($fields) {
                    $query->where('students.student_code', 'LIKE', "%{$fields['keyword']}%")
                        ->orWhere('students.name_th', 'LIKE', "%{$fields['keyword']}%")
                        ->orWhere('subject_residuals.subject_code', 'LIKE', "%{$fields['keyword']}%")
                        ->orWhere('subject_residuals.subject_name', 'LIKE', "%{$fields['keyword']}%");
                })
                ->whereBetween('subject_residuals.created_at', [$fields['start_date'], $fields['end_date']])
                ->paginate(20);
        }

        return response()->json($residuals, 201);
    }

    //? Filter by dates (Not paginate)
    public function datesFilterNotPaginate(Request $request)
    {
        $fields = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.is_del', false)
            ->whereBetween('subject_residuals.created_at', [$fields['start_date'], $fields['end_date']])
            ->get();

        if (!$residuals) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $residuals,
            ], 201);
        }
    }

    //? Search by student citizen id
    public function searchByStudentCitizenId($citizenId)
    {
        $residuals = SubjectResidual::join('students', 'subject_residuals.student_id', '=', 'students.id')
            ->select(
                'subject_residuals.id',
                'students.student_code',
                'students.name_th as student_name',
                'students.tel_number as student_tel_number',
                'students.email as student_email',
                'subject_residuals.subject_type',
                'subject_residuals.subject_code',
                'subject_residuals.subject_name',
                'subject_residuals.section',
                'subject_residuals.advisor',
                'subject_residuals.detail',
                'subject_residuals.status',
                'subject_residuals.is_del',
                'subject_residuals.created_at as date',
            )
            ->where('subject_residuals.is_del', false)
            ->where('students.citizen_id', $citizenId)
            ->orderBy('subject_residuals.id', 'desc')
            ->paginate(10);

        return response()->json($residuals, 200);
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
            'advisor' => 'required|string',
        ]);

        $subjectResidual = SubjectResidual::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $subjectResidual
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'subject_type' => 'required|string',
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
            'section' => 'required|string',
            'detail' => 'required|string',
            'student_id' => 'required|integer',
            'advisor' => 'required|string',
        ]);

        $subjectResidual = SubjectResidual::findOrfail($id);
        $subjectResidual->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลสำเร็จ',
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
            'message' => 'อัพเดทข้อมูลสำเร็จ',
            'data' => $residual
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        $residual = SubjectResidual::findOrFail($id);
        $residual->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
