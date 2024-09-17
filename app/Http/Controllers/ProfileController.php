<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\UserAdminPhoneNumberRequest;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService)
    {
        $this->middleware('auth:user-api', [
            'except' => ['getNameAndEmailUsers']
        ]);
        
    }

    public function getNameAndEmailUsers(UserAdminPhoneNumberRequest $request): JsonResponse
    {
        $getrequest = $request->validated();
        DB::beginTransaction();

        try{
            $name = $this->profileService->getNameAndEmailUsers($getrequest);

            DB::commit();
        }catch(\Exception $e) {

            return response()->json([
                'message' => config('sessionmessages.an_error_has_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }

        if ($name) {
            return response()->json([
                'data' => $name,
            ], 200);
        }

        return response()->json([
            'data' => 'Номер телефона не найден',
        ], 200);

    }
}
