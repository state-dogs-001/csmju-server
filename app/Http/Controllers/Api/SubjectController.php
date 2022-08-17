<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subject;

class SubjectController extends Controller
{
    //? Show all subjects
    public function index()
    {
        $subjects = Subject::where('is_del', false)->paginate(20);

        return response()->json($subjects, 200);
    }

    //? Show a subject
    public function show($id)
    {
        $subject = Subject::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $subject
        ], 200);
    }

    //? Create new subject
    public function store(Request $request)
    {
        $fields = $request->validate([
            'subject_code' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'detail' => 'required|string',
            'credit' => 'required|integer',
            'theory_hour' => 'required|integer',
            'practical_hour' => 'required|integer',
            'self_hour' => 'required|integer',
            'term' => 'required|integer',
            'is_show' => 'boolean',
        ]);

        $subject = Subject::create($fields);

        return response()->json([
            'success' => true,
            'data' => $subject
        ], 201);
    }

    //? Update a subject
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'detail' => 'required|string',
            'credit' => 'required|integer',
            'theory_hour' => 'required|integer',
            'practical_hour' => 'required|integer',
            'self_hour' => 'required|integer',
            'term' => 'required|integer',
            'is_show' => 'boolean',
        ]);

        //? Find subject by id
        $subject = Subject::findOrFail($id);

        $subject->update($fields);

        return response()->json([
            'success' => true,
            'data' => $subject
        ], 200);
    }

    //? Search subject by keyword
    public function search($keyword)
    {
        $subjects = Subject::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('name_th', 'LIKE', "%$keyword%")
                    ->orWhere('name_en', 'LIKE', "%$keyword%")
                    ->orWhere('subject_code', 'LIKE', "%$keyword%");
            })
            ->paginate(20);

        return response()->json($subjects, 200);
    }

    //? Filter subject by term
    public function termFilter($term)
    {
        $subjects = Subject::where('term', $term)
            ->where('is_del', false)
            ->get();

        //? Check if subject is empty
        if ($subjects->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบรายวิชาที่ต้องการ'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $subjects
            ], 200);
        }
    }

    //? Filter subject by detail
    public function detailFilter($detail)
    {
        $subjects = Subject::where('detail', 'like', "%$detail%")
            ->where('is_del', false)
            ->get();

        //? Check if subject is empty
        if ($subjects->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบรายวิชาที่ต้องการ'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $subjects
            ], 200);
        }
    }

    //? Dalete a subject set is_del = true
    public function delete(Request $request, $id)
    {
        $field = $request->validate([
            'is_del' => 'required|boolean',
        ]);

        $student = Subject::findOrFail($id);

        //? Update is_del field to true
        $student->update($field);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว'
        ], 200);
    }
}
