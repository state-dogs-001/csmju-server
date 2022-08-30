<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{
    //? Show user
    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ], 200);
    }

    //? Signup function
    public function signup(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:255|confirmed',
            'citizen_id' => 'required|unique:users,citizen_id|max:13',
            'role' => 'required|string|max:255',
        ]);

        //? Create new user
        $user = User::create([
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'citizen_id' => $fields['citizen_id'],
            'role' => $fields['role'],
        ]);

        //? Response message
        return response()->json([
            'success' => true,
            'message' => 'สมัครสมาชิกสำเร็จ',
            'user' => $user,
        ], 201);
    }

    //? Signin function
    public function signin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        $email = $fields['email'];
        $password = $fields['password'];

        //? Find user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            //! User not found
            return response()->json([
                'success' => false,
                'message' => 'อีเมลล์ไม่ถูกต้อง',
            ], 401);
        } else {
            //! Password's incorrect
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'รหัสผ่านไม่ถูกต้อง',
                ], 401);
            } else {
                //? Signin successfully and create token
                $token = $user->createToken('secret')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'เข้าสู่ระบบสำเร็จ',
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }
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
