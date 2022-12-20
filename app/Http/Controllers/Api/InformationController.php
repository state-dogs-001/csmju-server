<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Information;
use App\Models\InformationImage;

class InformationController extends Controller
{
    //? Private information (paginate)
    public function indexPrivate()
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->paginate(20);

        return response()->json($information, 200);
    }

    //? Public information (paginate)
    public function indexPublic()
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->paginate(15);

        return response()->json($information, 200);
    }

    //? Search Private
    public function searchPrivate(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $field['keyword'];

        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('information.title', 'LIKE', "%$keyword%")
                    ->orWhere('information.detail', 'LIKE', "%$keyword%")
                    ->orWhere('information.type', 'LIKE', "%$keyword%");
            })
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->paginate(20);

        return response()->json($information, 201);
    }

    //? Search Public
    public function searchPublic(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $field['keyword'];

        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('information.title', 'LIKE', "%$keyword%")
                    ->orWhere('information.detail', 'LIKE', "%$keyword%")
                    ->orWhere('information.type', 'LIKE', "%$keyword%");
            })
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->paginate(20);

        return response()->json($information, 201);
    }

    //? Private information (all)
    public function allPrivateInformation()
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data success',
            'data' => $information,
        ], 200);
    }

    //? Public information (all)
    public function allPublicInformation()
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $information,
        ], 200);
    }

    //? Search All Information Private
    public function searchAllPrivate(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $field['keyword'];

        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('information.title', 'LIKE', "%$keyword%")
                    ->orWhere('information.detail', 'LIKE', "%$keyword%")
                    ->orWhere('information.type', 'LIKE', "%$keyword%");
            })
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $information,
        ], 201);
    }

    //? Search All Information Public
    public function searchAllPublic(Request $request)
    {
        $field = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $field['keyword'];

        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where(function ($query) use ($keyword) {
                $query->where('information.title', 'LIKE', "%$keyword%")
                    ->orWhere('information.detail', 'LIKE', "%$keyword%")
                    ->orWhere('information.type', 'LIKE', "%$keyword%");
            })
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $information,
        ], 201);
    }

    //? Limit information data (public)
    public function limitData($number)
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->limit($number)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $information,
        ], 200);
    }

    //? Show Private
    public function showPrivate($id)
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.id', $id)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->first();

        if ($information !== null) {
            return response()->json([
                'success' => true,
                'data' => $information,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }

    //? Show Public
    public function showPublic($id)
    {
        //? Join table information and information_images
        $information = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.id', $id)
            ->where('information.is_show', true)
            ->groupBy('information.id')
            ->orderBy('information.id', 'desc')
            ->first();

        if ($information !== null) {
            return response()->json([
                'success' => true,
                'data' => $information,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'poster' => 'required',
            'link' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'images' => 'nullable',
            'is_show' => 'boolean',
        ]);

        //? Has request poster
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');

            //? Create name
            $posterName = 'poster-news-' . time() . '-' . mt_rand() . '.' . $poster->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Create path
            $path = 'images/news/posters/' . $year . '/' . $month;

            //? Move file
            $poster->move(public_path($path), $posterName);

            //? Set poster name to field
            $fields['poster'] =  $year . '/' . $month . '/' . $posterName;
        }

        //? Create information
        $information = Information::create($fields);

        //? Has request images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                //? Create image name
                $imageName = 'image-news-' . time() . '-' . mt_rand() . '.' . $image->getClientOriginalExtension();

                //? Get year and month
                $year = date('Y');
                $month = date('m');

                //? Create path
                $path = 'images/news/images/' . $year . '/' . $month;

                //? Move file
                $image->move(public_path($path), $imageName);

                //? Create information image
                $informationImage = new InformationImage();
                $informationImage->information_id = $information->id;
                $informationImage->image = $year . '/' . $month . '/' . $imageName;
                $informationImage->save();
            }
        }

        //? Join table information and information_images
        $response = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.id', $information->id)
            ->groupBy('information.id')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'บันทึกกิจกรรมสำเร็จ',
            'data' => $response,
        ], 201);
    }

    //? Update
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'poster' => 'nullable',
            'link' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'images' => 'nullable',
            'is_show' => 'boolean',
        ]);

        //? Find information for update
        $information = Information::findOrFail($id);

        //? Find information for check if poster is changed
        $dbInformation = DB::table('information')->where('id', $id)->first();

        //? Has request poster
        if ($request->hasFile('poster')) {
            //? Check old poster if exist delete old poster
            if (File::exists(public_path('images/news/posters/' . $dbInformation->poster))) {
                File::delete(public_path('images/news/posters/' . $dbInformation->poster));
            }

            $poster = $request->file('poster');

            //? Create name
            $posterName = 'poster-news-' . time() . '-' . mt_rand() . '.' . $poster->getClientOriginalExtension();

            //? Get year and month
            $year = date('Y');
            $month = date('m');

            //? Create path
            $path = 'images/news/posters/' . $year . '/' . $month;

            //? Move file
            $poster->move(public_path($path), $posterName);

            //? Set poster name to field
            $fields['poster'] =  $year . '/' . $month . '/' . $posterName;
        }

        //? Update information
        $information->update($fields);

        //? Has request images
        if ($request->hasFile('images')) {
            $dbInformationImages = DB::table('information_images')->where('information_id', $id)->get();
            foreach ($dbInformationImages as $dbInformationImage) {
                //? Check old image if exist delete old image
                if (File::exists(public_path('images/news/images/' . $dbInformationImage->image))) {
                    File::delete(public_path('images/news/images/' . $dbInformationImage->image));
                }
            }

            //? Delete information images
            InformationImage::where('information_id', $id)->delete();

            $images = $request->file('images');
            foreach ($images as $image) {
                //? Create image name
                $imageName = 'image-news-' . time() . '-' . mt_rand() . '.' . $image->getClientOriginalExtension();

                //? Get year and month
                $year = date('Y');
                $month = date('m');

                //? Create path
                $path = 'images/news/images/' . $year . '/' . $month;

                //? Move file
                $image->move(public_path($path), $imageName);

                //? Create information image
                $informationImage = new InformationImage();
                $informationImage->information_id = $id;
                $informationImage->image = $year . '/' . $month . '/' . $imageName;
                $informationImage->save();
            }
        }

        //? Join table information and information_images
        $response = Information::leftJoin('information_images', 'information.id', '=', 'information_images.information_id')
            ->select(
                'information.id',
                'information.title',
                'information.detail',
                'information.poster',
                'information.link',
                'information.type',
                'information.is_show',
                DB::raw('GROUP_CONCAT(information_images.image) as images'),
                'information.created_at',
                'information.updated_at',
            )
            ->where('information.id', $id)
            ->groupBy('information.id')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'บันทึกกิจกรรมสำเร็จ',
            'data' => $response,
        ], 201);
    }

    //? Delete
    public function delete($id)
    {
        //? Find information for delete
        $information = Information::findOrFail($id);

        //? Delete information poster file 
        $dbInformation = DB::table('information')->where('id', $id)->first();
        if (File::exists(public_path('images/news/posters/' . $dbInformation->poster))) {
            File::delete(public_path('images/news/posters/' . $dbInformation->poster));
        }

        //? Delete information images file
        $dbInformationImages = DB::table('information_images')->where('information_id', $id)->get();
        foreach ($dbInformationImages as $dbInformationImage) {
            if (File::exists(public_path('images/news/images/' . $dbInformationImage->image))) {
                File::delete(public_path('images/news/images/' . $dbInformationImage->image));
            }
        }

        //? Delete information
        $information->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ',
        ], 201);
    }
}
