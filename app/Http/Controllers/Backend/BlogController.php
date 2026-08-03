<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Service;
use App\Support\BlogContentTransformer;
use App\Support\UploadedImageStorage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        $blogs = Blog::query()
            ->with('service:id,title,slug')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('title', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('author', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get()
            ->map(fn (Blog $blog) => $this->formatBlog($blog));

        return response()->json([
            'blogs' => $blogs,
            'services' => Service::query()->orderBy('title')->get(['id', 'title', 'slug']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateBlog($request);
        $slug = $data['slug'];

        $blog = Blog::create([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? '',
            'content' => isset($data['content'])
                ? BlogContentTransformer::transform($data['content'])
                : null,
            'cover_image' => $this->resolveCoverImage($request, $slug),
            'service_id' => $data['service_id'] ?? null,
            'author' => $data['author'] ?? 'ทีมงาน',
            'geo' => $data['geo'] ?? Blog::DEFAULT_GEO,
        ]);

        $blog->load('service:id,title,slug');

        return response()->json([
            'message' => 'เพิ่มบทความเรียบร้อย',
            'blog' => $this->formatBlog($blog),
        ], 201);
    }

    public function update(Request $request, Blog $blog): JsonResponse
    {
        $data = $this->validateBlog($request, $blog->id);
        $slug = $data['slug'];

        $blog->update([
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? '',
            'content' => isset($data['content'])
                ? BlogContentTransformer::transform($data['content'])
                : null,
            'cover_image' => $this->resolveCoverImage($request, $slug, $blog->cover_image),
            'service_id' => $data['service_id'] ?? null,
            'author' => $data['author'] ?? 'ทีมงาน',
            'geo' => $data['geo'] ?? Blog::DEFAULT_GEO,
        ]);

        $blog->load('service:id,title,slug');

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'blog' => $this->formatBlog($blog),
        ]);
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    private function validateBlog(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'cover_image_file' => ['nullable', 'image', 'max:2048'],
            'service_id' => ['nullable', 'exists:services,id'],
            'author' => ['nullable', 'string', 'max:255'],
            'geo' => ['nullable', 'string', 'max:100'],
        ]);
    }

    private function resolveCoverImage(Request $request, string $slug, ?string $current = null): ?string
    {
        $uploaded = $request->file('cover_image_file');

        if ($uploaded) {
            if (! $uploaded->isValid()) {
                $maxKb = (int) round(UploadedFile::getMaxFilesize() / 1024);
                throw ValidationException::withMessages([
                    'cover_image_file' => "อัปโหลดรูปไม่สำเร็จ (รหัส {$uploaded->getError()}) — ขนาดสูงสุดประมาณ {$maxKb} KB",
                ]);
            }

            return UploadedImageStorage::store(
                $uploaded,
                $slug,
                'images/blogs'
            );
        }

        $path = $request->input('cover_image');

        if (filled($path)) {
            return $path;
        }

        return $current;
    }

    private function formatBlog(Blog $blog): array
    {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'description' => $blog->description ?? '',
            'content' => $blog->content ?? '',
            'cover_image' => $blog->cover_image ?? '',
            'service_id' => $blog->service_id,
            'service_name' => $blog->service?->title ?? '',
            'author' => $blog->author ?? 'ทีมงาน',
            'geo' => $blog->geo ?? Blog::DEFAULT_GEO,
            'has_content' => filled($blog->content),
            'date' => optional($blog->created_at)->timezone(config('app.timezone'))->format('Y-m-d') ?? '',
            'created_at' => optional($blog->created_at)?->toIso8601String(),
            'updated_at' => optional($blog->updated_at)?->toIso8601String(),
        ];
    }
}
