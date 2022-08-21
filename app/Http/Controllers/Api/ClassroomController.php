<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Models\Classroom;

class ClassroomController extends Controller
{
    //? Classrooms
    public function index()
    {
        $classrooms = Classroom::where('is_del', false)
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return response()->json($classrooms, 200);
    }

    //? Show
    public function show($id)
    {
        $classroom = Classroom::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if classroom is exist
        if (!$classroom) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $classroom
            ], 200);
        }
    }

    //? Create new classroom
    public function store(Request $request)
    {
        //? When create new data it'll check if classroom is exist
        $dbCheck = Classroom::where('is_del', true)
            ->where('code', $request->code)
            ->first();

        if ($dbCheck) {
            //? If has data, update is_del to false
            $dbCheck->update([
                'is_del' => false,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'update',
                'message' => 'อัพเดทข้อมูลห้องเรียนสำเร็จ',
            ], 200);
        } else {
            //? If not has data, create new data
            $fields = $request->validate([
                'code' => 'required|unique:classrooms,code|string',
                'name' => 'required|string',
                'floor' => 'required|string',
                'building' => 'required|string',
                'faculty' => 'required|string',
                'univerity' => 'required|string',
                'reserve_seats' => 'required|integer',
                'room_type' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg|max:3584',
            ]);

            //? Upload image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'classroom-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/classrooms'), $imageName);
                $fields['image'] = $imageName;
            }

            //? Create new classroom
            $classroom = Classroom::create($fields);

            return response()->json([
                'success' => true,
                'status' => 'create',
                'message' => 'บันทึกข้อมูลห้องเรียนสำเร็จ',
                'data' => $classroom,
            ], 201);
        }
    }

    //? Update classroom
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'floor' => 'required|string',
            'building' => 'required|string',
            'faculty' => 'required|string',
            'univerity' => 'required|string',
            'reserve_seats' => 'required|integer',
            'room_type' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:3584',
        ]);

        //? Find classroom by id for update
        $classroom = Classroom::findOrFail($id);

        //? Find classroom by id for check if classroom is exist
        $dbClassroom = DB::table('classrooms')->where('id', $id)->first();

        //? If image is exist delete old image and upload new image
        if ($request->hasFile('image')) {
            //? if exist delete old image
            if (File::exists(public_path('images/classrooms/' . $dbClassroom->image))) {
                File::delete(public_path('images/classrooms/' . $dbClassroom->image));
            }

            //? Upload new image
            $image = $request->file('image');
            $imageName = 'classroom-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/classrooms'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Update classroom
        $classroom->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูลห้องเรียนสำเร็จ',
            'data' => $classroom,
        ], 200);
    }

    //? Search classroom
    public function search($keyword)
    {
        $classrooms = Classroom::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('code', 'LIKE', "%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($classrooms, 200);
    }

    //? Filter by room type
    public function filterRoomType($roomType)
    {
        $classrooms = Classroom::where('is_del', false)
            ->where('room_type', $roomType)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $classrooms
        ], 200);
    }

    //? Delete classroom
    public function delete(Request $request, $id)
    {
        $field = $request->validate([
            'is_del' => 'required|boolean',
        ]);

        //? Find classroom by id for update
        $classroom = Classroom::findOrFail($id);

        //? Update classroom
        $classroom->update($field);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลห้องเรียนสำเร็จ',
        ], 200);
    }
}
