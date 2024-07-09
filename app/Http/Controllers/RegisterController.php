<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $code = Code::where("email", $data["email"])->where("code", $data['code'])->first();

        if (!$code) {
            return response()->json([
                "status" => false,
                "message" => "Invaild Code"
            ], 400);
        }

        //Create User
        $user = User::create([
            "fullname" => $data['fullname'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "address" => $data['address'],
            "status" => UserStatus::PENDING->value
        ]);

        Cache::put("user_{$user->id}", $user, 60);
        
        //Delete Used Codes
        $code->delete();

        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ], 200);
    }

    public function getUser(UserRequest $request)
    {
        $query = $request->validated();
        $cacheKey = $query['status'];

        if ($cacheKey == 'all') {
            $user = Cache::remember("user_{$cacheKey}", 60, function () use ($cacheKey) {
                return User::all();
            });
        } else {
            $status = UserStatus::from($cacheKey);
            $user = Cache::remember("user_{$status->value}", 60, function () use ($status) {
                return User::where("status", $status->value)->get();
            });
        }

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => $user
        ], 200);
    }
}