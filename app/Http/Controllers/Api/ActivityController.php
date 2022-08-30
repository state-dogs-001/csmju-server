<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{
    //? Index Activity (Public)
    public function index()
    {
        $activities = Activity::where('is_del', false)
            ->where('is_show', true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Index Activity (Private)
    public function indexPrivate()
    {
        $activities = Activity::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Limit Activity
    public function limit($number)
    {
        $activities = Activity::where('is_del', false)
            ->where('is_show', true)
            ->orderBy('id', 'desc')
            ->limit($number)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $activities,
        ], 200);
    }

    //? Show for read
    public function showRead($id)
    {
        $activity = Activity::where('is_del', false)
            ->where('is_show', true)
            ->where('id', $id)
            ->first();

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $activity,
            ], 200);
        }
    }

    //? Show for update
    public function showUpdate($id)
    {
        $activity = DB::table('activities')
            ->where('is_del', false)
            ->where('id', $id)
            ->first();

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $activity,
            ], 200);
        }
    }

    //? Search Activity (Public)
    public function search($keyword)
    {
        $activities = Activity::where('is_del', false)
            ->where('is_show', true)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Search Activity (Private)
    public function searchPrivate($keyword)
    {
        $activities = Activity::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Create new activity
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'nullable|date_format:Y-m-d',
            'detail' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3584',
            'is_show' => 'boolean',
        ]);

        //? Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'activity-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/activities'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Create new activity
        $activity = Activity::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกกิจกรรมสำเร็จ',
            'data' => $activity,
        ], 201);
    }

    //? Update activity
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'nullable|date_format:Y-m-d',
            'detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3584',
            'is_show' => 'boolean',
        ]);

        //? Find activity by id for update
        $activity = Activity::findOrFail($id);

        //? Find image for delete
        $dbActivity = DB::table('activities')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image')) {
            //? Delete old image
            if (File::exists(public_path('images/activities/' . $dbActivity->image))) {
                File::delete(public_path('images/activities/' . $dbActivity->image));
            }

            //? Upload new image
            $image = $request->file('image');
            $imageName = 'activity-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/activities'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Update activity
        $activity->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขกิจกรรมสำเร็จ',
            'data' => $activity,
        ], 200);
    }

    //? Delete activity
    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบกิจกรรมสำเร็จ',
        ], 200);
    }
}
