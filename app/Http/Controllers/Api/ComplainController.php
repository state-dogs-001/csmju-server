<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Complain;

class ComplainController extends Controller
{
    //? Index
    public function index()
    {
        $complains = Complain::where('is_del', false)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($complains, 200);
    }

    //? Show
    public function show($id)
    {
        $complain = Complain::where('is_del', false)
            ->where('id', $id)
            ->first();

        if (!$complain) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $complain
            ], 200);
        }
    }

    //? Store
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
        ]);

        //? Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = 'complain-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/complains'), $name);
            $fields['image'] = $name;
        }

        //? Store
        $complain = Complain::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลร้องเรียนสำเร็จ',
            'data' => $complain,
        ], 201);
    }

    //? Delete
    public function delete($id)
    {
        $complain = Complain::findOrFail($id);
        $complain->update([
            'is_del' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
