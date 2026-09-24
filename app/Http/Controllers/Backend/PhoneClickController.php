<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PhoneClickLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhoneClickController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = PhoneClickLog::query()->orderByDesc('created_at');

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('phone', 'like', "%{$q}%")
                    ->orWhere('page_url', 'like', "%{$q}%")
                    ->orWhere('placement', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'logs' => $query->limit(500)->get()->map(fn (PhoneClickLog $log) => $this->format($log)),
            'total' => PhoneClickLog::query()->count(),
        ]);
    }

    public function destroy(PhoneClickLog $phoneClickLog): JsonResponse
    {
        $phoneClickLog->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function format(PhoneClickLog $log): array
    {
        return [
            'id' => $log->id,
            'phone' => $log->phone,
            'page_url' => $log->page_url,
            'placement' => $log->placement,
            'ip_address' => $log->ip_address,
            'created_at' => optional($log->created_at)?->format('Y-m-d H:i'),
        ];
    }
}
