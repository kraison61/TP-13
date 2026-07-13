<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherCopyRequest;
use App\Models\DiscountAttribution;
use Illuminate\Http\JsonResponse;

class VoucherController extends Controller
{
    public function storeCopy(StoreVoucherCopyRequest $request): JsonResponse
    {
        $code = $request->string('reference')->toString();

        $attribution = DiscountAttribution::firstOrCreate(
            ['code' => $code],
            [
                'source_page' => $request->headers->get('referer', url('/')),
                'ip_address' => $request->ip(),
                'status' => 'generated',
                'discount_amount' => 0,
            ]
        );

        return response()->json([
            'saved' => $attribution->wasRecentlyCreated,
            'already_exists' => ! $attribution->wasRecentlyCreated,
        ]);
    }
}
