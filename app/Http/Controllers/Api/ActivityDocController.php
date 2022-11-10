<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Activity;
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
                'activity_docs.docs',
                'activities.name as activity_name'
            )
            ->orderBy('activity_docs.id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Show
    public function show($id)
    {
        $doc = ActivityDoc::where('activity_id', $id)->get();

        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบเอกสาร',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'เอกสาร',
                'data' => $doc
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'activity_id' => 'required|integer',
            'name' => 'required|string',
            'docs' => 'required|file|mimes:pdf|max:10240',
        ]);

        //? Has request file
        if ($request->hasFile('docs')) {
            $doc = $request->file('docs');
            $filename = 'activity-doc-' . time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('documents/activities'), $filename);
            $fields['docs'] = $filename;
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
            'name' => 'required|string',
            'docs' => 'required|file|mimes:pdf|max:10240',
        ]);

        //? Find doc by id for update
        $activityDoc = ActivityDoc::findOrFail($id);

        //? Find doc by id for delete old doc
        $dbDoc = DB::table('activity_docs')->where('id', $id)->first();

        //? Has request file
        if ($request->hasFile('docs')) {
            //? Delete old doc
            if (File::exists(public_path('documents/activities/' . $dbDoc->doc))) {
                File::delete(public_path('documents/activities/' . $dbDoc->doc));
            }

            //? Upload new doc
            $doc = $request->file('docs');
            $filename = 'activity-doc-' . time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('documents/activities'), $filename);
            $fields['docs'] = $filename;
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
        if (File::exists(public_path('documents/activities/' . $dbDoc->doc))) {
            File::delete(public_path('documents/activities/' . $dbDoc->doc));
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
