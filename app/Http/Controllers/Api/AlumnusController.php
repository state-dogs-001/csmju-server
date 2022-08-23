<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Alumnus;

class AlumnusController extends Controller
{
    //? Index
    public function index()
    {
        $alumnus = Alumnus::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($alumnus, 200);
    }

    //? Show
    public function show($id)
    {
        $alumni = Alumnus::where('id', $id)
            ->where('is_del', false)
            ->first();

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $alumni
            ], 200);
        }
    }

    //? Search
    public function search($keyword)
    {
        $alumnus = Alumnus::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('student_code', 'LIKE', "%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($alumnus, 200);
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'student_code' => 'required|string|unique:alumni,student_code|max:10',
            'name' => 'required|string|max:255',
            'work_place' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'tel_number' => 'nullable|string|max:10',
            'image_profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3584',
        ]);

        //? Upload image
        if ($request->hasFile('image_profile')) {
            $image = $request->file('image_profile');
            $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/alumnus'), $imageName);
            $fields['image_profile'] = $imageName;
        }

        //? create alumni
        $alumnus = Alumnus::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'alumnus' => $alumnus,
        ], 200);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'student_code' => 'required|string|unique:alumni,student_code|max:10' . $id,
            'name' => 'required|string|max:255',
            'work_place' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'tel_number' => 'nullable|string|max:10',
            'image_profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3584',
        ]);

        //? Find alumni by id for update
        $alumnus = Alumnus::findOrFail($id);

        //? Find alumni by id for delete old image profile
        $dbAlumnus = DB::table('alumni')->where('id', $id)->first();

        if ($request->hasFile('image_profile')) {
            //? Delete old image profile
            if (File::exists(public_path('images/alumnus/' . $dbAlumnus->image_profile))) {
                File::delete(public_path('images/alumnus/' . $dbAlumnus->image_profile));
            }

            //? Upload image
            $image = $request->file('image_profile');
            $imageName = 'profile-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/alumnus'), $imageName);
            $fields['image_profile'] = $imageName;
        }

        //? Update
        $alumnus->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูลสำเร็จ',
            'alumnus' => $alumnus,
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        $alumni = Alumnus::findOrFail($id);
        $alumni->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ',
        ], 200);
    }
}
