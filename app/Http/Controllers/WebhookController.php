<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateStatusRequest;

class WebhookController extends Controller
{
    public function updateStatus(UpdateStatusRequest $request)
    {
        try {
            $input = $request->validated();
            $user = User::where("email", $input['email'])->first();
            $user->status = UserStatus::from($input['status']);
            $user->save();
            return response()->json([
                "status" => true,
                "message" => "User Status Updated successfully"
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                "status" => false,
                "message" => "Error Occured",
            ], 500);
        }
    }
}