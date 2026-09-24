<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoneClickRequest;
use App\Models\PhoneClickLog;
use Illuminate\Http\JsonResponse;

class PhoneClickController extends Controller
{
    public function store(StorePhoneClickRequest $request): JsonResponse
    {
        PhoneClickLog::create([
            'phone' => $request->string('phone')->toString(),
            'page_url' => $request->input('page_url'),
            'placement' => $request->input('placement'),
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 500) ?: null,
        ]);

        return response()->json(['saved' => true]);
    }
}
