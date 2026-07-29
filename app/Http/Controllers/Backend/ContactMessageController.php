<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactMessageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ContactMessage::query()->orderByDesc('created_at');

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('service', 'like', "%{$q}%")
                    ->orWhere('reference', 'like', "%{$q}%")
                    ->orWhere('detail', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json([
            'messages' => $query->get()->map(fn (ContactMessage $message) => $this->format($message)),
        ]);
    }

    public function update(Request $request, ContactMessage $contactMessage): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'contacted', 'quoted', 'won', 'closed'])],
        ]);

        $contactMessage->update(['status' => $data['status']]);

        return response()->json([
            'message' => 'อัปเดตสถานะเรียบร้อย',
            'contact_message' => $this->format($contactMessage->fresh()),
        ]);
    }

    public function destroy(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function format(ContactMessage $message): array
    {
        return [
            'id' => $message->id,
            'reference' => $message->reference,
            'name' => $message->name,
            'phone' => $message->phone,
            'service' => $message->service,
            'budget' => $message->expected_budget,
            'requested_discount' => (int) $message->requested_discount,
            'detail' => $message->detail,
            'status' => $message->status,
            'date' => optional($message->created_at)?->format('Y-m-d'),
            'created_at' => optional($message->created_at)?->format('Y-m-d H:i'),
        ];
    }
}
