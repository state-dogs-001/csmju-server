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
        //? Join table activity_images
        $activities = Activity::where('is_show', true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Index Activity (Private)
    public function indexPrivate()
    {
        //? Join table activity_images
        $activities = Activity::orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Activity All
    public function all()
    {
        $activities = Activity::all();

        return response()->json([
            'success' => true,
            'data' => $activities
        ], 200);
    }

    //? Limit Activity
    public function limit($number)
    {
        $activities = Activity::where('is_show', true)
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
        $activity = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
            ->select(
                'activities.id',
                'activities.name',
                'activities.organizer',
                'activities.date_start',
                'activities.date_end',
                'activities.detail',
                'activities.is_show',
                'activities.location',
                'activities.poster',
                DB::raw('GROUP_CONCAT(activity_images.images) as images')
            )
            ->where('activities.is_show', true)
            ->where('activities.id', $id)
            ->groupBy('activities.id')
            ->first();

        if ($activity) {
            return response()->json([
                'success' => true,
                'data' => $activity,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 200);
        }
    }

    //? Show for update
    public function showUpdate($id)
    {
        $activity = Activity::where('id', $id)
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
        $activities = Activity::where('is_show', true)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('organizer', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Search Activity (Private)
    public function searchPrivate($keyword)
    {
        $activities = Activity::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('organizer', 'LIKE', "%$keyword%")
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
            'location' => 'required|string',
            'poster' => 'required',
            'is_show' => 'boolean',
        ]);

        //? Has request from user to upload activity aposter
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $posterName = 'activity-poster-' . time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(public_path('images/activities/posters'), $posterName);
            $fields['poster'] = $posterName;
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
            'location' => 'required|string',
            'poster' => 'nullable',
            'is_show' => 'boolean',
        ]);

        //? Find activity by id for update
        $activity = Activity::findOrFail($id);

        //?  Find activity by id for check if poster is changed
        $dbActivity = DB::table('activities')->where('id', $id)->first();

        //? Has request from user to update activity aposter
        if ($request->hasFile('poster')) {
            //? Check old poster if exist delete old poster
            if (File::exists(public_path('images/activities/posters/' . $dbActivity->poster))) {
                File::delete(public_path('images/activities/posters/' . $dbActivity->poster));
            }

            $poster = $request->file('poster');
            $posterName = 'activity-poster-' . time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(public_path('images/activities/posters'), $posterName);
            $fields['poster'] = $posterName;
        }

        //? Update activity
        $activity->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขกิจกรรมสำเร็จ',
            'data' => $activity,
        ], 201);
    }

    //? Delete activity
    public function delete($id)
    {
        //? Find activity by id for delete
        $activity = Activity::findOrFail($id);

        //? Find activity by id for check if poster is exist
        $dbActivity = DB::table('activities')->where('id', $id)->first();

        //? Delete poster
        if (File::exists(public_path('images/activities/posters/' . $dbActivity->poster))) {
            File::delete(public_path('images/activities/posters/' . $dbActivity->poster));
        }

        //? Find activity images by activity id for delete
        $activityImages = DB::table('activity_images')->where('activity_id', $id)->get();
        //? Delete images
        foreach ($activityImages as $activityImage) {
            if (File::exists(public_path('images/activities/images/' . $activityImage->images))) {
                File::delete(public_path('images/activities/images/' . $activityImage->images));
            }
        }

        //? Delete activity
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบกิจกรรมสำเร็จ',
        ], 201);
    }
}
