<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Personnel;

class PersonnelController extends Controller
{
    //? Show all personnels
    public function index()
    {
        $personnels = Personnel::where('is_del', false)->paginate(20);

        return response()->json($personnels, 200);
    }

    //? Show a personnel
    public function show($id)
    {
        $personnel = Personnel::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if personnel is exist
        if (!$personnel) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $personnel,
            ], 200);
        }
    }

    //? Create new personnel
    public function store(Request $request)
    {
        $fields = $request->validate([
            'citizen_id' => 'required|string|min:13|max:255',
            'name_title' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image_profile' => 'image|mimes:jpeg,png,jpg|max:3584',
            'email' => 'required|string|email|max:255',
            'tel_number' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_type' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'edu_level' => 'required|string|max:255',
            'edu_course_name' => 'required|string|max:255',
            'edu_major' => 'required|string|max:255',
            'edu_institute' => 'required|string|max:255',
            'work_status' => 'required|string|max:255',
        ]);

        //? Upload image
        if ($request->hasFile('image_profile')) {
            $image = $request->file('image_profile');
            $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/personnels'), $imageName);
            $fields['image_profile'] = $imageName;
        }

        //? Create student
        $personnel = Personnel::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูลบุคคลากรเรียบร้อยแล้ว',
            'data' => $personnel,
        ], 201);
    }

    //? Update personnel
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'citizen_id' => 'required|string|min:13|max:255',
            'name_title' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image_profile' => 'image|mimes:jpeg,png,jpg|max:3584',
            'email' => 'required|string|email|max:255',
            'tel_number' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_type' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'edu_level' => 'required|string|max:255',
            'edu_course_name' => 'required|string|max:255',
            'edu_major' => 'required|string|max:255',
            'edu_institute' => 'required|string|max:255',
            'work_status' => 'required|string|max:255',
        ]);

        //? Find personnel by id for update
        $personnel = Personnel::findOrFail($id);

        //? Find personnel by id for check if profile image is changed
        $dbPersonnel = DB::table('personnels')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image_profile')) {
            //? Check old image if exist delete old image
            if (File::exists(public_path('images/personnels/' . $dbPersonnel->image_profile))) {
                File::delete(public_path('images/personnels/' . $dbPersonnel->image_profile));
            }

            //? Upload new image
            $image = $request->file('image_profile');
            $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/personnels'), $imageName);
            $fields['image_profile'] = $imageName;
        }

        //? Update personnel
        $personnel->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลบุคคลากรเรียบร้อยแล้ว',
            'data' => $personnel,
        ], 200);
    }

    //? Search personnel
    public function search($keyword)
    {
        $personnel = Personnel::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('name_th', 'LIKE', "%$keyword%")
                    ->orWhere('name_en', 'LIKE', "%$keyword%")
                    ->orWhere('citizen_id', 'LIKE', "%$keyword%");
            })
            ->paginate(20);

        return response()->json($personnel, 200);
    }

    //? Delete student
    public function delete(Request $request, $id)
    {
        $field = $request->validate([
            'is_del' => 'required|boolean',
        ]);

        $student = Personnel::findOrFail($id);

        //? Update is_del field to true
        $student->update($field);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว'
        ], 200);
    }
}
