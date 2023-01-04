<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{
    //? Show user
    public function show(Request $request)
    {
        //? Get personnel id by user.personnel_id
        $id = $request->user()->personnel_id;

        //? Join personnel table
        $user = User::join('personnels', 'personnels.id', '=', 'users.personnel_id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.image_profile',
                'personnels.email',
                'personnels.tel_number',
                'users.role'
            )
            ->where('personnels.id', $id)
            ->first();

        //? Response
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }

    //? Admin check
    public function adminCheck($citizenId)
    {
        //? Join personnel table
        $user = User::join('personnels', 'personnels.id', '=', 'users.personnel_id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.image_profile',
                'personnels.email',
                'personnels.tel_number',
                'users.role'
            )
            ->where('personnels.citizen_id', $citizenId)
            ->where('users.role', 'admin')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบผู้ใช้งาน',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);
        }
    }

    //? Signup function
    public function signup(Request $request)
    {
        $fields = $request->validate([
            'personnel_id' => 'required|numeric|exists:personnels,id',
            'role' => 'required|string',
        ]);

        //? Create user
        $user = User::create($fields);

        //? Response
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 201);
    }

    //? Signin function
    // public function signin(Request $request)
    // {
    //     $fields = $request->validate([
    //         'email' => 'required|email|max:255',
    //         'password' => 'required|min:6|max:255',
    //     ]);

    //     $email = $fields['email'];
    //     $password = $fields['password'];

    //     //? Find user by email
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         //! User not found
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'อีเมลล์ไม่ถูกต้อง',
    //         ], 200);
    //     } else {
    //         //! Password's incorrect
    //         if (!Hash::check($password, $user->password)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'รหัสผ่านไม่ถูกต้อง',
    //             ], 200);
    //         } else {
    //             //? Signin successfully and create token
    //             $token = $user->createToken('secret')->plainTextToken;

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'เข้าสู่ระบบสำเร็จ',
    //                 'user' => $user,
    //                 'token' => $token,
    //             ], 200);
    //         }
    //     }
    // }
    public function signin(Request $request)
    {
        $field = $request->validate([
            'personnel_id' => 'required|numeric|exists:personnels,id',
        ]);

        //? Get personnel_id
        $id = $field['personnel_id'];

        //? Find user by personnel_id for create token
        $userToken = User::where('personnel_id', $id)->first();

        //? Join personnel table
        $user = User::join('personnels', 'personnels.id', '=', 'users.personnel_id')
            ->select(
                'personnels.id',
                'personnels.citizen_id',
                'personnels.name_title',
                'personnels.name_th',
                'personnels.name_en',
                'personnels.image_profile',
                'personnels.email',
                'personnels.tel_number',
                'users.role'
            )
            ->where('personnels.id', $id)
            ->first();

        //? Check user
        if (!$user) {
            //? Response error
            return response()->json([
                'success' => false,
                'message' => 'ผู้ใช้งานไม่มีสิทธิ์ในการเข้าใช้งาน',
            ], 200);
        } else {
            $token = $userToken->createToken('anonymous' . $id)->plainTextToken;

            //? Response
            return response()->json([
                'success' => true,
                'message' => 'เข้าสู่ระบบสำเร็จ',
                'data' => $user,
                'token' => $token,
            ], 200);
        }
    }

    //? Signout function
    public function signout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'ออกจากระบบสำเร็จ',
        ], 200);
    }
}
