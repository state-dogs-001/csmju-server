<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Student;

class StudentController extends Controller
{
    //? Show all students
    public function index()
    {
        $students = Student::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($students, 200);
    }

    //? Show a student
    public function show($id)
    {
        $student = Student::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if student is exist
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $student,
            ], 200);
        }
    }

    //? Create new student
    public function store(Request $request)
    {
        //? When create new data it'll check if student is exist
        $dbCheck = Student::where('is_del', true)
            ->where(function ($query) use ($request) {
                $query->where('citizen_id', $request->citizen_id)
                    ->orWhere('student_code', $request->student_code);
            })
            ->first();

        if ($dbCheck) {
            //? If has data, update is_del to false
            $dbCheck->update([
                'is_del' => false,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'update',
                'message' => 'อัพเดตข้อมูลนักศึกษาเรียบร้อย',
            ]);
        } else {
            //? data is not exist, create new data
            $fields = $request->validate([
                'citizen_id' => 'required|string|unique:students,citizen_id|max:13',
                'student_code' => 'required|string|unique:students,student_code|max:10',
                'name_th' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'image_profile' => 'image|mimes:jpeg,png,jpg|max:3584',
                'email' => 'required|string|email|max:255',
                'tel_number' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'district' => 'required|string|max:255',
                'sub_district' => 'required|string|max:255',
                'postcode' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            //? Upload image
            if ($request->hasFile('image_profile')) {
                $image = $request->file('image_profile');
                $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/students'), $imageName);
                $fields['image_profile'] = $imageName;
            }

            //? Create student
            $student = Student::create($fields);

            return response()->json([
                'success' => true,
                'status' => 'create',
                'message' => 'สร้างข้อมูลนักศึกษาเรียบร้อยแล้ว',
                'data' => $student,
            ], 201);
        }
    }

    //? Update function
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image_profile' => 'image|mimes:jpeg,png,jpg|max:3584',
            'email' => 'required|string|email|max:255',
            'tel_number' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'sub_district' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        //? Find student by id for update
        $student = Student::findOrFail($id);

        //? Find student by id for check if profile image is changed
        $dbStudent = DB::table('students')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image_profile')) {
            //? Check old image if exist delete old image
            if (File::exists(public_path('images/students/' . $dbStudent->image_profile))) {
                File::delete(public_path('images/students/' . $dbStudent->image_profile));
            }

            //? Upload new image
            $image = $request->file('image_profile');
            $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/students'), $imageName);
            $fields['image_profile'] = $imageName;
        }

        //? Update student
        $student->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลนักศึกษาเรียบร้อยแล้ว',
            'data' => $student,
        ], 200);
    }

    //? Search student
    public function search($keyword)
    {
        $student = Student::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('name_th', 'LIKE', "%$keyword%")
                    ->orWhere('name_en', 'LIKE', "%$keyword%")
                    ->orWhere('student_code', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($student, 200);
    }

    //? Delete student
    public function delete(Request $request, $id)
    {
        $field = $request->validate([
            'is_del' => 'required|boolean',
        ]);

        $student = Student::findOrFail($id);

        //? Update is_del field to true
        $student->update($field);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว'
        ], 200);
    }
}
