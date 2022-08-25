<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Information;

class InformationController extends Controller
{
    //? Infornation public
    public function index()
    {
        $news = Information::where('is_show', true)
            ->where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($news, 200);
    }

    //? Imformation private
    public function indexPrivate()
    {
        $news = Information::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($news, 200);
    }

    //? Information get all not paginate
    public function indexAll()
    {
        $news = Information::where('is_show', true)
            ->where('is_del', false)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'news' => $news
        ], 200);
    }

    //? Show public
    public function show($id)
    {
        $news = Information::where('id', $id)
            ->where('is_show', true)
            ->where('is_del', false)
            ->first();

        //? Check if news is exist
        if (!$news) {
            return response()->json([
                'sucess' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $news,
            ], 200);
        }
    }

    //? Show private
    public function showPrivate($id)
    {
        $news = Information::where('id', $id)
            ->where('is_del', false)
            ->first();

        //? Check if news is exist
        if (!$news) {
            return response()->json([
                'sucess' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $news,
            ], 200);
        }
    }

    //? Store new information
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3584',
            'link' => 'nullable|string',
            'type' => 'required|string',
            'is_show' => 'boolean',
        ]);

        //? Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'news-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/news'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Create new information
        $news = Information::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'อัพโหลดข้อมูลสำเร็จ',
            'data' => $news,
        ], 201);
    }

    //? Update information
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:3584',
            'link' => 'nullable|string',
            'type' => 'required|string',
            'is_show' => 'boolean',
        ]);

        //? Find information by id for update
        $news = Information::findOrFail($id);

        //? Find information by id for check if image is changed
        $dbNews = DB::table('information')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image')) {
            //? Check old image if exist delete old image
            if (File::exists(public_path('images/news/' . $dbNews->image))) {
                File::delete(public_path('images/news/' . $dbNews->image));
            }

            //? Upload new image
            $image = $request->file('image');
            $imageName = 'news-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/news'), $imageName);
            $fields['image'] = $imageName;
        }

        //? Update information
        $news->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลสำเร็จ',
            'data' => $news,
        ], 200);
    }

    //? Search information public
    public function search($keyword)
    {
        $news = Information::where('is_show', true)
            ->where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%")
                    ->orWhere('type', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($news, 200);
    }

    //? Search information private
    public function searchPrivate($keyword)
    {
        $news = Information::where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%")
                    ->orWhere('type', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($news, 200);
    }

    //? Search information all
    public function searchAll($keyword)
    {
        $news = Information::where('is_show', true)
            ->where('is_del', false)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%")
                    ->orWhere('type', 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->get();

        //? Check if news is empty
        if ($news->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $news,
            ], 200);
        }
    }

    //? Limit information
    public function newsLimit($number)
    {
        $news = Information::where('is_show', true)
            ->where('is_del', false)
            ->orderBy('id', 'desc')
            ->limit($number)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $news,
        ], 200);
    }

    //? Delete information
    public function delete($id)
    {
        //? Find information by id for delete
        $news = Information::findOrFail($id);
        $news->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ',
            'data' => $news,
        ], 200);
    }
}
