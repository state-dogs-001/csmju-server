<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\ActivityImage;

class ActivityImageController extends Controller
{
    //? Index Activity Image
    public function index()
    {
        $activities = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
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
                DB::raw('COUNT(activity_images.id) as images_count'),
                DB::raw('GROUP_CONCAT(activity_images.images) as images'),
            )
            ->groupBy('activities.id')
            ->orderBy('activities.id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Show images sort by activity id
    public function show($id)
    {
        $images = ActivityImage::where('activity_id', $id)->get();

        if (!$images) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบรูปภาพ',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'รูปภาพ',
                'data' => $images
            ], 200);
        }
    }

    //? Search activity images
    public function search($keyword)
    {
        $activities = Activity::leftJoin('activity_images', 'activities.id', '=', 'activity_images.activity_id')
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
                DB::raw('COUNT(activity_images.id) as images_count'),
                DB::raw('GROUP_CONCAT(activity_images.images) as images'),
            )
            ->where('activities.name', 'LIKE', "%$keyword%")
            ->groupBy('activities.id')
            ->orderBy('activities.id', 'desc')
            ->paginate(20);

        return response()->json($activities, 200);
    }

    //? Store or update
    public function storeOrUpdate(Request $request)
    {
        $fields = $request->validate([
            'activity_id' => 'required|integer',
            'images' => 'required',
        ]);

        //? Find activity images
        $activityImages = ActivityImage::where('activity_id', $fields['activity_id'])->get();

        if ($activityImages->count() < 0) {
            //? Not have images
            if ($request->hasFile('images')) {
                //? Upload images
                $images = $request->file('images');
                $i = 0; //? Index use in loop
                foreach ($images as $image) {
                    //? If not add index in image name, image may be overwrite
                    $imageName = 'activity-' . time() + $i . '.' . $image->getClientOriginalExtension();

                    //? Move image to folder
                    $image->move(public_path('images/activities/images'), $imageName);

                    //? Create new activity image
                    $activityImage = new ActivityImage();
                    $activityImage->activity_id = $fields['activity_id'];
                    $activityImage->images = $imageName;
                    $activityImage->save();

                    //? Count index
                    $i++;
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            ], 201);
        } else {
            //? Have images update new images
            if ($request->hasFile('images')) {
                $dbActivityImages = DB::table('activity_images')->where('activity_id', $fields['activity_id'])->get();
                foreach ($dbActivityImages as $dbActivityImage) {
                    //? Delete old images
                    if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
                        File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
                    }
                }

                //? Delete old images in database
                DB::table('activity_images')->where('activity_id', $fields['activity_id'])->delete();

                //? Upload new images
                $images = $request->file('images');
                $i = 0; //? Index use in loop
                foreach ($images as $image) {
                    //? If not add index in image name, image may be overwrite
                    $imageName = 'activity-' . time() + $i . '.' . $image->getClientOriginalExtension();

                    //? Move image to folder
                    $image->move(public_path('images/activities/images'), $imageName);

                    //? Create new activity image
                    $activityImage = new ActivityImage();
                    $activityImage->activity_id = $fields['activity_id'];
                    $activityImage->images = $imageName;
                    $activityImage->save();

                    //? Count index
                    $i++;
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'อัปเดทข้อมูลเรียบร้อยแล้ว',
            ], 201);
        }
    }

    //? Update activity images
    // public function updateAll(Request $request)
    // {
    //     $fields = $request->validate([
    //         'activity_id' => 'required|integer',
    //         'images' => 'required',
    //     ]);

    //     if ($request->hasFile('images')) {
    //         $dbActivityImages = DB::table('activity_images')->where('activity_id', $fields['activity_id'])->get();
    //         foreach ($dbActivityImages as $dbActivityImage) {
    //             //? Delete old images
    //             if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
    //                 File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
    //             }
    //         }

    //         //? Delete old images in database
    //         DB::table('activity_images')->where('activity_id', $fields['activity_id'])->delete();

    //         //? Upload new images
    //         $images = $request->file('images');
    //         $i = 0; //? Index use in loop
    //         foreach ($images as $image) {
    //             //? If not add index in image name, image may be overwrite
    //             $imageName = 'activity-' . time() + $i . '.' . $image->getClientOriginalExtension();

    //             //? Move image to folder
    //             $image->move(public_path('images/activities/images'), $imageName);

    //             //? Create new activity image
    //             $activityImage = new ActivityImage();
    //             $activityImage->activity_id = $fields['activity_id'];
    //             $activityImage->images = $imageName;
    //             $activityImage->save();

    //             //? Count index
    //             $i++;
    //         }
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'อัปเดทข้อมูลเรียบร้อยแล้ว',
    //     ], 201);
    // }

    //? Update activity image
    public function update(Request $request, $id)
    {
        $field = $request->validate([
            'images' => 'required|image|mimes:jpeg,png,jpg|max:3584',
        ]);

        //? Get activity image
        $activityImage = ActivityImage::findOrFail($id);

        //? Find activity images by id for check if poster is changed
        $dbActivityImage = DB::table('activity_images')->where('id', $id)->first();

        if ($request->hasFile('images')) {
            //? Delete old images
            if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
                File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
            }

            //? Upload new images
            $image = $request->file('images');
            $imageName = 'activity-' . time() . '.' . $image->getClientOriginalExtension();

            //? Move image to folder
            $image->move(public_path('images/activities/images'), $imageName);
            $field['images'] = $imageName;

            //? Update activity image
            $activityImage->update($field);
        }

        return response()->json([
            'success' => true,
            'message' => 'อัปเดทข้อมูลเรียบร้อยแล้ว',
            'data' => $activityImage,
        ], 201);
    }

    //? Delete activity images
    public function deleteAll($id)
    {
        $dbActivityImages = DB::table('activity_images')->where('activity_id', $id)->get();
        foreach ($dbActivityImages as $dbActivityImage) {
            //? Delete old images
            if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
                File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
            }
        }

        //? Delete old images in database
        ActivityImage::where('activity_id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
        ], 201);
    }

    //? Delete activity image
    public function delete($id)
    {
        //? Get activity image
        $activityImage = ActivityImage::findOrFail($id);

        //? Find activity images by id for check if poster is changed
        $dbActivityImage = DB::table('activity_images')->where('id', $id)->first();

        //? Delete old images
        if (File::exists(public_path('images/activities/images/' . $dbActivityImage->images))) {
            File::delete(public_path('images/activities/images/' . $dbActivityImage->images));
        }

        //? Delete activity image
        $activityImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว',
        ], 201);
    }
}
