<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServicePrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServicePriceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ServicePrice::query()
            ->with(['service:id,title,slug,icon_name'])
            ->orderBy('service_id')
            ->orderBy('sort_order')
            ->orderBy('id');

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->integer('service_id'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhereHas('service', fn ($s) => $s->where('title', 'like', "%{$q}%"));
            });
        }

        return response()->json([
            'prices' => $query->get()->map(fn (ServicePrice $price) => $this->formatPrice($price)),
            'services' => Service::query()->orderBy('title')->get(['id', 'title', 'slug', 'icon_name']),
            'price_types' => $this->priceTypeOptions(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatePrice($request);

        $price = ServicePrice::create($data);
        $price->load(['service:id,title,slug,icon_name']);

        return response()->json([
            'message' => 'เพิ่มราคาเรียบร้อย',
            'price' => $this->formatPrice($price),
        ], 201);
    }

    public function update(Request $request, ServicePrice $servicePrice): JsonResponse
    {
        $data = $this->validatePrice($request);

        $servicePrice->update($data);
        $servicePrice->load(['service:id,title,slug,icon_name']);

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'price' => $this->formatPrice($servicePrice),
        ]);
    }

    public function destroy(ServicePrice $servicePrice): JsonResponse
    {
        $servicePrice->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validatePrice(Request $request): array
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_type' => ['required', Rule::in(array_keys($this->priceTypeOptions()))],
            'price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        if ($data['price_type'] === 'call_to_ask') {
            $data['price'] = null;
            $data['max_price'] = null;
        }

        if ($data['price_type'] !== 'range') {
            $data['max_price'] = null;
        }

        return $data;
    }

    private function formatPrice(ServicePrice $price): array
    {
        $types = $this->priceTypeOptions();

        return [
            'id' => $price->id,
            'service_id' => $price->service_id,
            'service_name' => $price->service?->title,
            'service_slug' => $price->service?->slug,
            'service_icon' => $price->service?->icon_name ?? 'bi-bricks',
            'name' => $price->name,
            'sku' => $price->sku,
            'description' => $price->description,
            'price_type' => $price->price_type,
            'price_type_label' => $types[$price->price_type] ?? $price->price_type,
            'price' => $price->price !== null ? (float) $price->price : null,
            'max_price' => $price->max_price !== null ? (float) $price->max_price : null,
            'price_label' => $this->formatPriceLabel($price),
            'unit' => $price->unit,
            'sort_order' => $price->sort_order,
            'status' => $price->is_active ? 'active' : 'inactive',
        ];
    }

    private function formatPriceLabel(ServicePrice $price): string
    {
        if ($price->price_type === 'call_to_ask' || $price->price === null) {
            return 'สอบถาม';
        }

        $formatted = number_format((float) $price->price, 0);

        if ($price->max_price) {
            $formatted .= ' – '.number_format((float) $price->max_price, 0);
        }

        return $formatted;
    }

    private function priceTypeOptions(): array
    {
        return [
            'fixed' => 'ราคาคงที่',
            'starting_at' => 'ราคาเริ่มต้น',
            'range' => 'ช่วงราคา',
            'call_to_ask' => 'สอบถาม',
            'variable' => 'ตามหน้างาน',
        ];
    }
}
