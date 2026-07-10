<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $message = ContactMessage::create([
            'reference' => $request->string('reference')->toString(),
            'name' => $request->string('name')->toString(),
            'phone' => $request->string('phone')->toString(),
            'service' => $request->string('service')->toString(),
            'expected_budget' => $request->string('budget')->toString(),
            'requested_discount' => $request->integer('requested_discount'),
            'detail' => $request->input('detail'),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'ส่งคำขอเรียบร้อย! ทีมงานจะติดต่อกลับเร็วที่สุด',
            'reference' => $message->reference,
            'requested_discount' => $message->requested_discount,
        ]);
    }
}
