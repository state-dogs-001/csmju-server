<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Material;

class MaterialController extends Controller
{
    //? Index show in public
    public function index()
    {
        $materials = Material::where('is_del', false)
            ->where('status', true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Index show in dashboard
    public function indexPrivate()
    {
        $materials = Material::where('is_del', false)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Show material is in stock
    public function show($id)
    {
        $material = Material::where('id', $id)
            ->where('is_del', false)
            ->where('status', true)
            ->first();

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $material
            ], 200);
        }
    }

    //? Show material for update
    public function showUpdate($id)
    {
        $material = Material::where('id', $id)
            ->where('is_del', false)
            ->first();

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $material
            ], 200);
        }
    }

    //? Search material in public
    public function search($keyword)
    {
        $materials = Material::where('is_del', false)
            ->where('status', true)
            ->where('name', 'LIKE', "%$keyword%")
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Search material in dashboard
    public function searchPrivate($keyword)
    {
        $materials = Material::where('is_del', false)
            ->where('name', 'LIKE', "%$keyword%")
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($materials, 200);
    }

    //? Create new material
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
            'status' => 'boolean',
        ]);

        //? Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'material-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/materials'), $imageName);
            $fields['image'] = $imageName;
        }

        //? if quantity is 0, set status to false
        if ($fields['quantity'] == 0) {
            $fields['status'] = false;
        } else {
            $fields['status'] = true;
        }

        $material = Material::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $material
        ], 201);
    }

    //? Update material
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3584',
            'status' => 'boolean',
        ]);

        //? Find material by id for update
        $material = Material::findOrFail($id);

        //? Find material by id for check image
        $dbMaterial = DB::table('materials')->where('id', $id)->first();

        //? Upload image
        if ($request->hasFile('image')) {
            //? Delete old image
            if (File::exists(public_path('images/materials/' . $dbMaterial->image))) {
                File::delete(public_path('images/materials/' . $dbMaterial->image));
            }

            //? Upload new image
            $image = $request->file('image');
            $imageName = 'material-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/materials'), $imageName);
            $fields['image'] = $imageName;
        }

        //? if quantity is 0, set status to false
        if ($fields['quantity'] == 0) {
            $fields['status'] = false;
        } else {
            $fields['status'] = true;
        }

        $material->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลสำเร็จ',
            'data' => $material
        ], 200);
    }

    //? Delete material
    public function delete($id)
    {
        $material = Material::findOrFail($id);
        $material->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 200);
    }
}
