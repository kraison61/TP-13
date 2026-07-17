<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Support\ServiceContentTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::query()
            ->with(['lowestPrice', 'category'])
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service) => $this->formatService($service));

        return response()->json([
            'services' => $services,
            'categories' => ServiceCategory::query()->orderBy('id')->get(['id', 'name', 'slug']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateService($request);

        $service = Service::create([
            'service_category_id' => $data['service_category_id'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'h1' => $data['h1'] ?? null,
            'icon_name' => $data['icon_name'] ?? null,
            'dur' => $data['dur'] ?? null,
            'description' => $data['description'] ?? null,
            'content' => isset($data['content'])
                ? ServiceContentTransformer::transform($data['content'])
                : null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_des' => $data['meta_des'] ?? null,
            'img_1' => $data['img_1'] ?? null,
            'img_2' => $data['img_2'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        $service->load(['lowestPrice', 'category']);

        return response()->json([
            'message' => 'เพิ่มบริการเรียบร้อย',
            'service' => $this->formatService($service),
        ], 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $data = $this->validateService($request, $service->id);

        $service->update([
            'service_category_id' => $data['service_category_id'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'h1' => $data['h1'] ?? null,
            'icon_name' => $data['icon_name'] ?? null,
            'dur' => $data['dur'] ?? null,
            'description' => $data['description'] ?? null,
            'content' => isset($data['content'])
                ? ServiceContentTransformer::transform($data['content'])
                : null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_des' => $data['meta_des'] ?? null,
            'img_1' => $data['img_1'] ?? null,
            'img_2' => $data['img_2'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        $service->load(['lowestPrice', 'category']);

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'service' => $this->formatService($service),
        ]);
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validateService(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($ignoreId),
            ],
            'icon_name' => ['nullable', 'string', 'max:255'],
            'h1' => ['nullable', 'string', 'max:255'],
            'dur' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_des' => ['nullable', 'string', 'max:500'],
            'img_1' => ['nullable', 'string', 'max:255'],
            'img_2' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function formatService(Service $service): array
    {
        $price = $service->lowestPrice;

        return [
            'id' => $service->id,
            'service_category_id' => $service->service_category_id,
            'category_name' => $service->category?->name,
            'name' => $service->title,
            'slug' => $service->slug,
            'h1' => $service->h1 ?? '',
            'icon' => $service->icon_name ?? 'bi-bricks',
            'desc' => $service->description ?? '',
            'content' => $service->content ?? '',
            'meta_title' => $service->meta_title ?? '',
            'meta_des' => $service->meta_des ?? '',
            'img_1' => $service->img_1 ?? '',
            'img_2' => $service->img_2 ?? '',
            'has_content' => filled($service->content),
            'dur' => $service->dur ?? '',
            'price' => $price ? $this->formatPriceLabel((float) $price->price, $price->unit) : '—',
            'status' => $service->is_active ? 'active' : 'inactive',
        ];
    }

    private function formatPriceLabel(float $price, ?string $unit): string
    {
        $formatted = number_format($price, 0).'.-';

        return $unit ? "{$formatted}/{$unit}" : $formatted;
    }
}
