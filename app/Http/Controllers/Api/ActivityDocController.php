<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// use App\Models\Activity;
use App\Models\ActivityDoc;

class ActivityDocController extends Controller
{
    //? Index
    public function index()
    {
        $activities = ActivityDoc::join('activities', 'activity_docs.activity_id', '=', 'activities.id')
            ->select(
                'activity_docs.id',
                'activity_docs.name',
                'activity_docs.file',
                'activity_docs.activity_id',
                'activities.name as activity_name',
            )
            ->orderBy('activity_docs.id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Search
    public function search(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $field['keyword'];

        $docs = ActivityDoc::join('activities', 'activity_docs.activity_id', '=', 'activities.id')
            ->select(
                'activity_docs.id',
                'activity_docs.name',
                'activity_docs.file',
                'activity_docs.activity_id',
                'activities.name as activity_name'
            )
            ->where(function ($query) use ($keyword) {
                $query->where('activity_docs.name', 'LIKE', "%$keyword%")
                    ->orWhere('activities.name', 'LIKE', "%$keyword%");
            })
            ->orderBy('activity_docs.id', 'desc')
            ->paginate(20);

        return response()->json($docs, 201);
    }

    //? Show
    public function show($id)
    {
        $doc = ActivityDoc::join('activities', 'activity_docs.activity_id', '=', 'activities.id')
            ->select(
                'activity_docs.id',
                'activity_docs.name',
                'activity_docs.file',
                'activity_docs.activity_id',
                'activities.name as activity_name'
            )
            ->where('activity_docs.id', $id)
            ->orderBy('activity_docs.id', 'desc')
            ->first();

        if ($doc) {
            return response()->json([
                'success' => true,
                'data' => $doc,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'activity_id' => 'required|integer',
            'name' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        //? Has request uplaod file
        if ($request->hasFile('file')) {
            $doc = $request->file('file');

            //? Generate file name
            $filename = 'activity-doc-' . time() . '.' . $doc->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Set path
            $path = 'documents/activities/' . $year . '/' . $month;

            //? Move file to public storage
            $doc->move(public_path($path), $filename);

            //? Set file name to fields
            $fields['file'] = $year . '/' . $month . '/' . $filename;
        }

        //? Create doc
        $activityDoc = ActivityDoc::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกเอกสารกิจกรรมสำเร็จ',
            'data' => $activityDoc,
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'activity_id' => 'required|integer',
            'name' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        //? Find doc by id for update
        $activityDoc = ActivityDoc::findOrFail($id);

        //? Find doc by id for delete old doc
        $dbDoc = DB::table('activity_docs')->where('id', $id)->first();

        //? Has request file
        if ($request->hasFile('file')) {
            //? Delete old doc
            if (File::exists(public_path('documents/activities/' . $dbDoc->file))) {
                File::delete(public_path('documents/activities/' . $dbDoc->file));
            }

            //? Upload new doc
            $doc = $request->file('file');

            //? Generate file name
            $filename = 'activity-doc-' . time() . '.' . $doc->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Set path
            $path = 'documents/activities/' . $year . '/' . $month;

            //? Move file to public storage
            $doc->move(public_path($path), $filename);

            //? Set file name to fields
            $fields['file'] = $year . '/' . $month . '/' . $filename;
        }

        //? Update doc
        $activityDoc->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขเอกสารกิจกรรมสำเร็จ',
            'data' => $activityDoc,
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        //? Find doc by id for delete
        $activityDoc = ActivityDoc::findOrFail($id);

        //? Find doc by id for delete old doc
        $dbDoc = DB::table('activity_docs')->where('id', $id)->first();

        //? Delete old doc
        if (File::exists(public_path('documents/activities/' . $dbDoc->file))) {
            File::delete(public_path('documents/activities/' . $dbDoc->file));
        }

        //? Delete doc
        $activityDoc->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบเอกสารกิจกรรมสำเร็จ',
            'data' => $activityDoc,
        ], 200);
    }
}
