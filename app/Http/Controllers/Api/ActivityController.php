<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\ActivityImage;

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
                'activities.location',
                'activities.poster',
                'activities.is_show',
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
        $activity = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
            ->select(
                'activities.id',
                'activities.name',
                'activities.organizer',
                'activities.date_start',
                'activities.date_end',
                'activities.detail',
                'activities.location',
                'activities.poster',
                'activities.is_show',
                DB::raw('GROUP_CONCAT(activity_images.images) as images')
            )
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

    //? Search Activity (Public)
    public function search(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $field['keyword'];

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
    public function searchPrivate(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $field['keyword'];

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
            'name' => 'required|string|max:255|unique:activities,name',
            'organizer' => 'required|string|max:255',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'nullable|date_format:Y-m-d',
            'detail' => 'required|string',
            'location' => 'required|string',
            'poster' => 'required',
            'images' => 'nullable',
            'is_show' => 'boolean',
        ]);

        //? Has request from user to upload activity aposter
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');

            //? Generate poster name
            $posterName = 'activity-poster-' . time() . '-' . mt_rand() . '.' . $poster->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Set path to store poster
            $path = 'images/activities/posters/' . $year . '/' . $month;

            //? Move poster to public storage
            $poster->move(public_path($path), $posterName);

            //? Set poster name to field
            $fields['poster'] =  $year . '/' . $month . '/' . $posterName;
        }

        //? Create new activity
        $activity = Activity::create($fields);

        //? Has request from user to upload activity images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                //? Generate image name
                $imageName = 'activity-img-' . time() . '-' . mt_rand() . '.' . $image->getClientOriginalExtension();

                //? Get year and month
                $year = date('Y');
                $month = date('m');

                //? Set path to store image
                $path = 'images/activities/images/' . $year . '/' . $month;

                //? Move image to public storage
                $image->move(public_path($path), $imageName);

                //? Create new activity image
                $activityImage = new ActivityImage();
                $activityImage->activity_id = $activity->id;
                $activityImage->images = $year . '/' . $month . '/' . $imageName;
                $activityImage->save();
            }
        }

        $response = $activity = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
            ->select(
                'activities.id',
                'activities.name',
                'activities.organizer',
                'activities.date_start',
                'activities.date_end',
                'activities.detail',
                'activities.location',
                'activities.poster',
                'activities.is_show',
                DB::raw('GROUP_CONCAT(activity_images.images) as images')
            )
            ->where('activities.id', $activity->id)
            ->groupBy('activities.id')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'บันทึกกิจกรรมสำเร็จ',
            'data' => $response,
        ], 201);
    }

    //? Update activity
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:activities,name,' . $id,
            'organizer' => 'required|string|max:255',
            'date_start' => 'required|date_format:Y-m-d',
            'date_end' => 'nullable|date_format:Y-m-d',
            'detail' => 'required|string',
            'location' => 'required|string',
            'poster' => 'nullable',
            'images' => 'nullable',
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

            //? Generate poster name
            $posterName = 'activity-poster-' . time() . '-' . mt_rand() . '.' . $poster->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Set path to store poster
            $path = 'images/activities/posters/' . $year . '/' . $month;

            //? Move poster to public storage
            $poster->move(public_path($path), $posterName);

            //? Set poster name to field
            $fields['poster'] =  $year . '/' . $month . '/' . $posterName;
        }

        //? Update activity
        $activity->update($fields);

        //? Has request from user to update activity images
        if ($request->hasFile('images')) {
            $dbActivityImages = DB::table('activity_images')->where('activity_id', $id)->get();
            foreach ($dbActivityImages as $dbActivityImage) {
                //? Delete old images
                if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
                    File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
                }
            }

            //? Delete old images in database
            ActivityImage::where('activity_id', $id)->delete();

            //? Upload new images
            $images = $request->file('images');
            foreach ($images as $image) {
                //? Generate image name
                $imageName = 'activity-img-' . time() . '-' . mt_rand() . '.' . $image->getClientOriginalExtension();

                //? Get year and month
                $year = date('Y');
                $month = date('m');

                //? Set path to store image
                $path = 'images/activities/images/' . $year . '/' . $month;

                //? Move image to public storage
                $image->move(public_path($path), $imageName);

                //? Create new activity image
                $activityImage = new ActivityImage();
                $activityImage->activity_id = $id;
                $activityImage->images = $year . '/' . $month . '/' . $imageName;
                $activityImage->save();
            }
        }

        $response = $activity = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
            ->select(
                'activities.id',
                'activities.name',
                'activities.organizer',
                'activities.date_start',
                'activities.date_end',
                'activities.detail',
                'activities.location',
                'activities.poster',
                'activities.is_show',
                DB::raw('GROUP_CONCAT(activity_images.images) as images')
            )
            ->where('activities.id', $id)
            ->groupBy('activities.id')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'บันทึกกิจกรรมสำเร็จ',
            'data' => $response,
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

        //? Find activity docs by activity id for delete
        $activityDocs = DB::table('activity_docs')->where('activity_id', $id)->get();
        //? Delete docs
        foreach ($activityDocs as $activityDoc) {
            if (File::exists(public_path('documents/activities/' . $activityDoc->file))) {
                File::delete(public_path('documents/activities/' . $activityDoc->file));
            }
        }

        //? Delete activity
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ',
        ], 201);
    }
}
