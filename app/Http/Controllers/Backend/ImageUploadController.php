<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ImageUpload;
use App\Models\Service;
use App\Support\UploadedImageStorage;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ImageUploadController extends Controller
{
    private const MAX_FILE_KILOBYTES = 4096;

    private const MAX_FILES = 20;

    private const DIRECTORY = 'images/galleries';

    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        $images = $this->withImageable(ImageUpload::query())
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('location', 'like', "%{$q}%")
                        ->orWhere('img_url', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get()
            ->map(fn (ImageUpload $image) => $this->format($image));

        return response()->json([
            'images' => $images,
            'services' => Service::query()->orderBy('title')->get(['id', 'title', 'slug']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateImage($request, requireFiles: true);
        $service = Service::query()->with('category')->findOrFail($data['service_id']);
        $files = $this->uploadedFiles($request, 'files');

        $images = DB::transaction(function () use ($data, $service, $files) {
            $created = [];

            foreach ($files as $index => $file) {
                $this->assertValidUpload($file, "files.{$index}");

                $image = $service->images()->create([
                    'img_url' => UploadedImageStorage::store($file, $service->slug, self::DIRECTORY),
                    'location' => $data['location'],
                    'worked_date' => $data['worked_date'] ?? now(),
                ]);
                $image->setRelation('imageable', $service);
                $created[] = $this->format($image);
            }

            return $created;
        });

        $count = count($images);

        return response()->json([
            'message' => $count === 1 ? 'อัปโหลดรูปเรียบร้อย' : "อัปโหลด {$count} รูปเรียบร้อย",
            'images' => $images,
        ], 201);
    }

    public function update(Request $request, ImageUpload $imageUpload): JsonResponse
    {
        $data = $this->validateImage($request, requireFiles: false);
        $service = Service::query()->with('category')->findOrFail($data['service_id']);
        $previousPath = $imageUpload->img_url;

        $payload = [
            'location' => $data['location'],
            'worked_date' => $data['worked_date'] ?? $imageUpload->worked_date,
        ];

        $file = $request->file('file');

        if ($file) {
            $this->assertValidUpload($file, 'file');
            $payload['img_url'] = UploadedImageStorage::store($file, $service->slug, self::DIRECTORY);
        }

        $imageUpload->imageable()->associate($service);
        $imageUpload->fill($payload)->save();
        $imageUpload->setRelation('imageable', $service);

        if (isset($payload['img_url']) && $payload['img_url'] !== $previousPath) {
            UploadedImageStorage::delete($previousPath);
        }

        return response()->json([
            'message' => 'บันทึกเรียบร้อย',
            'image' => $this->format($imageUpload),
        ]);
    }

    public function destroy(ImageUpload $imageUpload): JsonResponse
    {
        $path = $imageUpload->img_url;
        $imageUpload->delete();
        UploadedImageStorage::delete($path);

        return response()->json(['message' => 'ลบรายการเรียบร้อย']);
    }

    public function renameLocation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'from' => ['nullable', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],
        ]);

        $from = trim((string) ($data['from'] ?? ''));
        $to = trim($data['to']);

        $query = ImageUpload::query();

        if ($from === '') {
            $query->where(function ($inner) {
                $inner->whereNull('location')->orWhere('location', '');
            });
        } else {
            $query->where('location', $from);
        }

        $count = $query->update(['location' => $to]);

        return response()->json([
            'message' => $count === 0
                ? 'ไม่พบรูปในโครงการนี้'
                : "เปลี่ยนชื่อโครงการ {$count} รูปเรียบร้อย",
            'count' => $count,
            'location' => $to,
        ]);
    }

    private function validateImage(Request $request, bool $requireFiles): array
    {
        $fileRules = ['image', 'max:'.self::MAX_FILE_KILOBYTES];

        return $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'location' => ['required', 'string', 'max:255'],
            'worked_date' => ['nullable', 'date'],
            'files' => $requireFiles
                ? ['required', 'array', 'min:1', 'max:'.self::MAX_FILES]
                : ['prohibited'],
            'files.*' => $requireFiles
                ? ['required', ...$fileRules]
                : ['prohibited'],
            'file' => $requireFiles
                ? ['prohibited']
                : ['nullable', ...$fileRules],
        ]);
    }

    /**
     * @return list<UploadedFile>
     */
    private function uploadedFiles(Request $request, string $key): array
    {
        $files = $request->file($key, []);

        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        return array_values(array_filter(
            is_array($files) ? $files : [],
            fn ($file) => $file instanceof UploadedFile
        ));
    }

    private function assertValidUpload(UploadedFile $uploaded, string $key): void
    {
        if ($uploaded->isValid()) {
            return;
        }

        $maxKb = (int) round(UploadedFile::getMaxFilesize() / 1024);

        throw ValidationException::withMessages([
            $key => "อัปโหลดรูปไม่สำเร็จ (รหัส {$uploaded->getError()}) — ขนาดสูงสุดประมาณ {$maxKb} KB",
        ]);
    }

    private function withImageable($query)
    {
        return $query->with(['imageable' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Service::class => ['category'],
            ]);
        }]);
    }

    private function format(ImageUpload $image): array
    {
        $imageable = $image->imageable;

        return [
            'id' => $image->id,
            'img_url' => $image->img_url,
            'location' => $image->location ?? '',
            'worked_date' => $image->worked_date
                ?->timezone(config('app.timezone'))
                ?->format('Y-m-d') ?? '',
            'service_id' => $imageable instanceof Service ? $imageable->id : null,
            'service_name' => $imageable instanceof Service ? ($imageable->title ?? '') : '',
            'category_name' => $imageable instanceof Service
                ? ($imageable->category?->name ?? 'อื่นๆ')
                : 'อื่นๆ',
            'created_at' => $image->created_at?->format('Y-m-d') ?? '',
        ];
    }
}
