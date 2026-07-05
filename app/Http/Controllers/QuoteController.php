<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $quote = Quote::create([
            'reference' => $request->string('reference')->toString(),
            'name' => $request->string('name')->toString(),
            'phone' => $request->string('phone')->toString(),
            'service' => $request->string('service')->toString(),
            'expected_budget' => $request->string('budget')->toString(),
            'requested_discount' => $request->integer('requested_discount'),
            'detail' => $request->input('detail'),
        ]);

        return response()->json([
            'message' => 'ส่งคำขอเรียบร้อย! ทีมงานจะติดต่อกลับเร็วที่สุด',
            'reference' => $quote->reference,
            'requested_discount' => $quote->requested_discount,
        ]);
    }
}
