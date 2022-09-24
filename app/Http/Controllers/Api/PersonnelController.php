<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Personnel;
use App\Models\PersonnelStatus;

class PersonnelController extends Controller
{
    //? Show all personnels paginate
    public function index()
    {
        //? Join table personnels and personnel_status
        $personnels = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
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
                'personnels.academic_type',
                'personnel_status.status',
                'personnels.is_del',
            )
            ->where('personnels.is_del', false)
            ->orderBy('personnels.id', 'desc')
            ->paginate(20);

        return response()->json($personnels, 200);
    }

    //? Show all personnels
    public function indexAll()
    {
        //? Join table personnels and personnel_status
        $personnels = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
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
                'personnels.academic_type',
                'personnel_status.status',
                'personnels.is_del',
            )
            ->where('personnels.is_del', false)
            ->where('personnels.work_status', 1)
            ->orderBy('personnels.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $personnels,
        ], 200);
    }

    //? Show a personnel
    public function show($id)
    {
        //? Join table personnels and personnel_status
        $personnel = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
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
                'personnels.academic_type',
                'personnel_status.status',
                'personnels.is_del',
            )
            ->where('personnels.id', $id)
            ->where('personnels.is_del', false)
            ->first();

        if (!$personnel) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $personnel
            ], 200);
        };
    }

    //? Show for update a personnel
    public function showUpdate($id)
    {
        $personnel = Personnel::where('id', $id)
            ->where('is_del', false)
            ->first();

        if (!$personnel) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $personnel
            ], 200);
        };
    }

    //? Search personnel
    public function search($keyword)
    {
        //? Join table personnels and personnel_status
        $personnels = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
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
                'personnels.academic_type',
                'personnel_status.status',
                'personnels.is_del',
            )
            ->where('personnels.is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('personnels.citizen_id', 'LIKE', "%$keyword%")
                    ->orWhere(DB::raw('CONCAT(personnels.name_title, personnels.name_th)'), 'LIKE', "%$keyword%")
                    ->orWhere('personnels.name_en', 'LIKE', "%$keyword%")
                    ->orWhere('personnels.position_academic', 'LIKE', "%$keyword%")
                    ->orWhere('personnels.position_manager', 'LIKE', "%$keyword%");
            })
            ->orderBy('personnels.id', 'desc')
            ->paginate(20);

        return response()->json($personnels, 200);
    }

    //? Filter personnel teacher
    public function filterTeacher()
    {
        //? Join table personnels and personnel_status
        $teachers = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.position_academic',
                'personnels.position_manager',
                'personnels.image_profile',
                'personnels.personnel_type',
                'personnels.email',
                'personnels.tel_number',
                'personnels.education',
                'personnels.academic_type',
                'personnels.is_del'
            )
            ->where('personnels.is_del', false)
            ->where('personnels.personnel_type', 'อาจารย์')
            ->where('personnel_status.status', 'ทำงานปกติ')
            ->get();

        if ($teachers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $teachers
            ], 200);
        }
    }

    //? Filter personnel staff
    public function filterStaff()
    {
        //? Join table personnels and personnel_status
        $staff = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.position_academic',
                'personnels.position_manager',
                'personnels.image_profile',
                'personnels.personnel_type',
                'personnels.email',
                'personnels.tel_number',
                'personnels.education',
                'personnels.academic_type',
                'personnels.is_del'
            )
            ->where('personnels.is_del', false)
            ->where('personnels.personnel_type', 'เจ้าหน้าที่')
            ->where('personnel_status.status', 'ทำงานปกติ')
            ->get();

        if ($staff->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $staff
            ], 200);
        }
    }

    //? Get personnel by citizen id
    public function citizenSearch($citizenId)
    {
        //? Join table personnels and personnel_status
        $personnel = Personnel::join('personnel_status', 'personnels.work_status', '=', 'personnel_status.id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
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
                'personnels.academic_type',
                'personnels.work_status as status_id',
                'personnel_status.status',
                'personnels.is_del',
            )
            ->where('personnels.is_del', false)
            ->where('personnels.citizen_id', $citizenId)
            ->first();

        if (!$personnel) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $personnel
            ], 200);
        }
    }

    //? Get personnel status
    public function personnelStatus()
    {
        $personnelStatus = PersonnelStatus::all();

        return response()->json([
            'success' => true,
            'data' => $personnelStatus
        ], 200);
    }

    //? Create new personnel
    public function store(Request $request)
    {
        //? When create new data it'll check if personnel is exist
        $dbCheck = Personnel::where('is_del', true)
            ->where('citizen_id', $request->citizen_id)
            ->first();

        if ($dbCheck) {
            //? If has data, update is_del to false
            $dbCheck->update([
                'is_del' => false,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'update',
                'message' => 'อัพเดตข้อมูลนักศึกษาสำเร็จ',
            ], 200);
        } else {
            //? If not has data, create new data
            $fields = $request->validate([
                'citizen_id' => 'required|string|unique:personnels,citizen_id|min:13',
                'name_title' => 'required|string|max:255',
                'name_th' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'position_academic' => 'required|string',
                'position_manager' => 'nullable|string',
                'image_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
                'email' => 'required|string|email|max:255',
                'tel_number' => 'required|string|max:255',
                'education' => 'required|string',
                'personnel_type' => 'required|string',
                'academic_type' => 'required|string',
                'work_status' => 'required|integer',
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
                'status' => 'create',
                'message' => 'สร้างข้อมูลบุคคลากรสำเร็จ',
                'data' => $personnel,
            ], 201);
        }
    }

    //? Update personnel
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'citizen_id' => 'required|string|min:13',
            'name_title' => 'required|string|max:255',
            'name_th' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'position_academic' => 'required|string',
            'position_manager' => 'nullable|string',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
            'email' => 'required|string|email|max:255',
            'tel_number' => 'required|string|max:255',
            'education' => 'required|string',
            'personnel_type' => 'required|string',
            'academic_type' => 'required|string',
            'work_status' => 'required|integer',
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
            'message' => 'แก้ไขข้อมูลบุคคลากรสำเร็จ',
            'data' => $personnel,
        ], 200);
    }

    //? Delete student
    public function delete($id)
    {
        //? Find personnel by id
        $student = Personnel::findOrFail($id);
        $student->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
