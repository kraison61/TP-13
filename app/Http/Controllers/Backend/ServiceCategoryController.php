<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceCategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ServiceCategory::query()
            ->withCount('services')
            ->orderBy('id');

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'categories' => $query->get()->map(fn (ServiceCategory $category) => $this->formatCategory($category)),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateCategory($request);

        $category = ServiceCategory::create($data);
        $category->loadCount('services');

        return response()->json([
            'message' => 'เพิ่มหมวดหมู่เรียบร้อย',
            'category' => $this->formatCategory($category),
        ], 201);
    }

    public function update(Request $request, ServiceCategory $serviceCategory): JsonResponse
    {
        $data = $this->validateCategory($request, $serviceCategory->id);

        $serviceCategory->update($data);
        $serviceCategory->loadCount('services');

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'category' => $this->formatCategory($serviceCategory),
        ]);
    }

    public function destroy(ServiceCategory $serviceCategory): JsonResponse
    {
        if ($serviceCategory->services()->exists()) {
            return response()->json([
                'message' => 'ไม่สามารถลบได้ เพราะมีบริการอยู่ในหมวดหมู่นี้',
            ], 422);
        }

        $serviceCategory->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validateCategory(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories', 'slug')->ignore($ignoreId),
            ],
        ]);
    }

    private function formatCategory(ServiceCategory $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'services_count' => (int) ($category->services_count ?? 0),
        ];
    }
}
