<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CheckSignin;

class CheckSigninController extends Controller
{
    //? Show all
    public function index()
    {
        $users = CheckSignin::paginate(20);

        return response()->json($users, 200);
    }

    //? Create new
    public function store(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email|max:255',
            'user_type' => 'required|string|max:255',
            'device' => 'required|string|max:255'
        ]);

        $user = CheckSignin::create($fields);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
}
