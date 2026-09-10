<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ServiceProduct::query()
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
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('service', fn ($s) => $s->where('title', 'like', "%{$q}%"));
            });
        }

        return response()->json([
            'products' => $query->get()->map(fn (ServiceProduct $product) => $this->formatProduct($product)),
            'services' => Service::query()->orderBy('title')->get(['id', 'title', 'slug', 'icon_name']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateProduct($request);

        $product = ServiceProduct::create($data);
        $product->load(['service:id,title,slug,icon_name']);

        return response()->json([
            'message' => 'เพิ่มสินค้าเรียบร้อย',
            'product' => $this->formatProduct($product),
        ], 201);
    }

    public function update(Request $request, ServiceProduct $serviceProduct): JsonResponse
    {
        $data = $this->validateProduct($request);

        $serviceProduct->update($data);
        $serviceProduct->load(['service:id,title,slug,icon_name']);

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'product' => $this->formatProduct($serviceProduct),
        ]);
    }

    public function destroy(ServiceProduct $serviceProduct): JsonResponse
    {
        $serviceProduct->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validateProduct(Request $request): array
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:2048'],
            'affiliate_link' => ['required', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        return $data;
    }

    private function formatProduct(ServiceProduct $product): array
    {
        return [
            'id' => $product->id,
            'service_id' => $product->service_id,
            'service_name' => $product->service?->title,
            'service_slug' => $product->service?->slug,
            'service_icon' => $product->service?->icon_name ?? 'bi-bricks',
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->image,
            'affiliate_link' => $product->affiliate_link,
            'sort_order' => $product->sort_order,
            'status' => $product->is_active ? 'active' : 'inactive',
        ];
    }
}
