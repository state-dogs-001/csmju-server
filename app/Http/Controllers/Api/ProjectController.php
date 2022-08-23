<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\ProjectLibrary;

class ProjectController extends Controller
{
    //? Index
    public function index()
    {
        $projects = ProjectLibrary::join('personnels', 'project_libraries.chairman', '=', 'personnels.id')
            ->select(
                'project_libraries.id',
                'project_libraries.name',
                'project_libraries.years',
                'project_libraries.file',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name',
                'project_libraries.type',
                'project_libraries.is_del',
            )
            ->where('project_libraries.is_del', false)
            ->paginate(20);

        return response()->json($projects, 200);
    }

    //? Show for update
    public function show($id)
    {
        $project = ProjectLibrary::where('id', $id)
            ->where('is_del', false)
            ->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $project
            ], 200);
        }
    }

    //? Show for read
    public function showRead($id)
    {
        $project = ProjectLibrary::join('personnels', 'project_libraries.chairman', '=', 'personnels.id')
            ->select(
                'project_libraries.id',
                'project_libraries.name',
                'project_libraries.years',
                'project_libraries.file',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name',
                'project_libraries.type',
                'project_libraries.is_del',
            )
            ->where('project_libraries.is_del', false)
            ->where('project_libraries.id', $id)
            ->first();

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $project,
            ], 200);
        }
    }

    //? Create new project
    public function store(Request $request)
    {
        //? Check if project name is already exist but is_del is true
        $dbCheck = ProjectLibrary::where('project_code', $request->project_code)
            ->where('is_del', true)
            ->first();

        if ($dbCheck) {
            //? Update is_del to false
            $dbCheck->update([
                'is_del' => false
            ]);

            return response()->json([
                'success' => false,
                'message' => 'อัปเดตข้อมูลสำเร็จ',
                'data' => $dbCheck
            ], 200);
        } else {
            $fields = $request->validate([
                'project_code' => 'required|string|unique:project_libraries,project_code',
                'name' => 'required|string',
                'years' => 'required|string',
                'file' => 'required|file|mimes:pdf',
                'chairman' => 'required|integer',
                'type' => 'required|string',
            ]);

            //? Upload file
            if ($request->hasFile('file')) {
                $pdf = $request->file('file');
                $pdfName = 'project-' . $fields['project_code'] . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('documents/projects'), $pdfName);
                $fields['file'] = $pdfName;
            }

            //? Create new project
            $project = ProjectLibrary::create($fields);

            return response()->json([
                'success' => true,
                'message' => 'บันทึกโครงงานสำเร็จ',
                'data' => $project,
            ], 201);
        }
    }

    //? Update project
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'project_code' => 'required|string|unique:project_libraries,project_code,' . $id,
            'name' => 'required|string',
            'years' => 'required|string',
            'file' => 'file|mimes:pdf',
            'type' => 'required|string',
        ]);

        //? Find project by id for update
        $project = ProjectLibrary::findOrFail($id);

        //? Find project by id for check file exist
        $dbProject = DB::table('project_libraries')->where('id', $id)->first();

        //? Upload file
        if ($request->hasFile('file')) {
            //? Delete old file
            if (File::exists(public_path('documents/projects/' . $dbProject->file))) {
                File::delete(public_path('documents/projects/' . $dbProject->file));
            }

            //? Upload new file
            $pdf = $request->file('file');
            $pdfName = 'project-' . $fields['project_code'] . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('documents/projects'), $pdfName);
            $fields['file'] = $pdfName;
        }
        $project->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขโครงงานสำเร็จ',
            'data' => $project,
        ], 200);
    }

    //? Search project
    public function search($keyword)
    {
        $projects = ProjectLibrary::join('personnels', 'project_libraries.chairman', '=', 'personnels.id')
            ->select(
                'project_libraries.id',
                'project_libraries.name',
                'project_libraries.years',
                'project_libraries.file',
                'personnels.name_title as personnel_name_title',
                'personnels.name_th as personnel_name',
                'project_libraries.type',
                'project_libraries.is_del',
            )
            ->where('project_libraries.is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('project_libraries.project_code', 'LIKE', "%$keyword%")
                    ->orWhere('project_libraries.name', 'LIKE', "%$keyword%")
                    ->orWhere('project_libraries.type', 'LIKE', "%$keyword%")
                    ->orWhere('personnels.name_th', 'LIKE', "%$keyword%");
            })
            ->paginate(20);

        return response()->json($projects, 200);
    }

    //? Delete project
    public function delete($id)
    {
        $project = ProjectLibrary::findOrFail($id);

        $project->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบโครงงานสำเร็จ',
        ], 200);
    }
}
