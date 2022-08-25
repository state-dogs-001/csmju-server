<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\OfficialDocument;

class DocumentController extends Controller
{
    //? Get all (public)
    public function index()
    {
        $documents = OfficialDocument::where('is_del', false)
            ->where('is_show', true)
            ->paginate(20);

        return response()->json($documents, 200);
    }

    //? Get all (private)
    public function indexPrivate()
    {
        $documents = OfficialDocument::where('is_del', false)
            ->paginate(20);

        return response()->json($documents, 200);
    }

    //? Show
    public function show($id)
    {
        $document = OfficialDocument::where('is_del', false)
            ->where('id', $id)
            ->first();

        if (!$document) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data' => $document
            ], 200);
        }
    }

    //? Create new Document
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'file|mimes:pdf|max:15360',
            'is_show' => 'boolean',
        ]);

        //? Upload file
        if ($request->hasFile('file')) {
            $pdf = $request->file('file');
            $pdfName = 'official-' . time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move(public_path('documents/official'), $pdfName);
            $fields['file'] = $pdfName;
        }

        //? Create document
        $document = OfficialDocument::create($fields);

        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูลเอกสารสำเร็จ',
            'data' => $document,
        ], 201);
    }

    //? Update document
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'file|mimes:pdf|max:15360',
            'is_show' => 'boolean',
        ]);

        //? Find document by id for update
        $document = OfficialDocument::findOrFail($id);

        //? Find document by id for check file
        $dbDocument = DB::table('official_documents')->where('id', $id)->first();

        if ($request->hasFile('file')) {
            if (File::exists(public_path('documents/official/' . $dbDocument->file))) {
                //? Delete old file
                File::delete(public_path('documents/official/' . $dbDocument->file));

                //? Upload new file
                $pdf = $request->file('file');
                $pdfName = 'official-' . time() . '.' . $pdf->getClientOriginalExtension();
                $pdf->move(public_path('documents/official'), $pdfName);
                $fields['file'] = $pdfName;
            }
        }

        $document->update($fields);

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลเอกสารสำเร็จ',
            'data' => $document,
        ], 200);
    }

    //? Search document by name (public)
    public function search($keyword)
    {
        $documents = OfficialDocument::where('is_del', false)
            ->where('is_show', true)
            ->where('name', 'LIKE', "%$keyword%")
            ->paginate(20);

        return response()->json($documents, 200);
    }

    //? Search document by name (private)
    public function searchPrivate($keyword)
    {
        $documents = OfficialDocument::where('is_del', false)
            ->where('name', 'LIKE', "%$keyword%")
            ->paginate(20);

        return response()->json($documents, 200);
    }

    //? Delete document
    public function delete($id)
    {
        $document = OfficialDocument::findOrFail($id);
        $document->update([
            'is_del' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบข้อมูลเอกสารสำเร็จ',
        ], 200);
    }
}
