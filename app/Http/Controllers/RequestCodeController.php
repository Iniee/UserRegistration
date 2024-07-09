<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Jobs\SendCodeJob;
use App\Traits\CodeTrait;
use App\Jobs\SendCodeEmail;
use App\Http\Requests\CodeRequest;
use Illuminate\Support\Facades\Log;

class RequestCodeController extends Controller
{
    use CodeTrait;
    public function requestCode(CodeRequest $request)
    {
        try {
            $input = $request->validated();
            $generatedCode = $this->codeGenerator();
            $email = $input['email'];

            $code = Code::updateOrCreate(
                [
                    "email" => $email
                ],
                ["code" => $generatedCode],
            );
            
            SendCodeJob::dispatch($code->code, $code->email);

            return response()->json([
                "status" => true,
                "message" => "Verification Mail Sent Successfully",
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