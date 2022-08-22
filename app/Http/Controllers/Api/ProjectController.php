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
        $projects = ProjectLibrary::where('is_del', false)
            ->paginate(20);

        return response()->json($projects, 200);
    }

    //? Show
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

    //? Create new project
    public function store(Request $request)
    {
        $fields = $request->validate([
            'project_code' => 'required|string|unique:project_libraries,project_code',
            'name' => 'required|string',
            'years' => 'required|string',
            'file' => 'required|file|mimes:pdf',
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
        $projects = ProjectLibrary::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('project_code', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%');
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
