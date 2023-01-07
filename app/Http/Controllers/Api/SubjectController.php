<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subject;

class SubjectController extends Controller
{
    //? subjects pagination
    public function index()
    {
        $subjects = Subject::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($subjects, 200);
    }

    //? subjects all
    public function subjectsAll()
    {
        $subjects = Subject::where('is_del', false)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subjects
        ], 200);
    }

    //? Show a subject
    public function show($id)
    {
        $subject = Subject::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if subject is exist
        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $subject
            ], 200);
        }
    }

    //? Create new subject
    public function store(Request $request)
    {
        //? When create new data it'll check if subject is exist
        $dbCheck = Subject::where('is_del', true)
            ->where('subject_code', $request->subject_code)
            ->first();

        if ($dbCheck) {
            //? If has data, update is_del to false
            $dbCheck->update([
                'is_del' => false,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'update',
                'message' => 'อัพเดทข้อมูลรายวิชาสำเร็จ',
            ], 200);
        } else {
            //? If not has data, create new subject
            $fields = $request->validate([
                'subject_code' => 'required|string|unique:subjects,subject_code|max:255',
                'name_th' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'detail' => 'required|string',
                'credit' => 'required|integer',
                'theory_hour' => 'required|integer',
                'practical_hour' => 'required|integer',
                'self_hour' => 'required|integer',
                'term' => 'nullable|integer',
            ]);

            $subject = Subject::create($fields);

            return response()->json([
                'success' => true,
                'status' => 'create',
                'data' => $subject
            ], 201);
        }
    }

    //? Update a subject
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'subject_code' => 'required|string|max:255' . $id,
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'detail' => 'required|string',
            'credit' => 'required|integer',
            'theory_hour' => 'required|integer',
            'practical_hour' => 'required|integer',
            'self_hour' => 'required|integer',
            'term' => 'nullable|integer',
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
                    ->orWhere('subject_code', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
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
            ], 200);
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
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $subjects
            ], 200);
        }
    }

    //? Subject count
    public function count()
    {
        $count = Subject::where('is_del', false)
            ->count();
        return response()->json($count, 200);
    }

    //? Dalete a subject set is_del = true
    public function delete($id)
    {
        $student = Subject::findOrFail($id);
        $student->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
