<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Models\Banner;

class BannerController extends Controller
{
    //? Index private (use in dashboard)
    public function index()
    {
        $banners = Banner::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($banners, 200);
    }

    //? Index public
    public function indexPublic()
    {
        $banners = Banner::where('is_show', true)
            ->where('is_del', false)
            ->get();

        //? if banner is empty
        if ($banners->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่มีข้อมูล Banner'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $banners,
            ], 200);
        }
    }

    //? Show
    public function show($id)
    {
        $banner = Banner::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if banner is exist
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $banner,
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:3584',
            'link' => 'nullable|url',
            'is_show' => 'boolean',
        ]);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = 'banner-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banners'), $imageName);
            $fields['banner'] = $imageName;
        }

        $banner = Banner::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูลแบนเนอร์สำเร็จ',
            'data' => $banner,
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'banner' => 'image|mimes:jpeg,png,jpg|max:3584',
            'link' => 'nullable|url',
            'is_show' => 'boolean',
        ]);

        //? Find banner by id for update
        $banner = Banner::findOrFail($id);

        //? Find banner by id for check if banner is exist
        $dbBanner = DB::table('banners')->where('id', $id)->first();

        if ($request->hasFile('banner')) {
            //? Check old image if exist delete it
            if (File::exists(public_path('images/banners/' . $dbBanner->banner))) {
                File::delete(public_path('images/banners/' . $dbBanner->banner));
            }

            //? Upload new image
            $image = $request->file('banner');
            $imageName = 'banner-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banners'), $imageName);
            $fields['banner'] = $imageName;
        }

        $banner->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลแบนเนอร์สำเร็จ',
            'data' => $banner,
        ], 200);
    }

    //? Delete
    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลแบนเนอร์สำเร็จ',
        ], 200);
    }
}
