<?php

namespace Tests\Feature;

use App\Models\ImageUpload;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('s3');
    }

    public function test_guest_cannot_access_image_api(): void
    {
        $this->getJson('/admin/api/images')->assertUnauthorized();
        $this->postJson('/admin/api/images', [])->assertUnauthorized();
        $this->putJson('/admin/api/images/locations', [
            'from' => 'a',
            'to' => 'b',
        ])->assertUnauthorized();
    }

    public function test_admin_page_includes_images_nav(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk()
            ->assertSee('firstFilledList', false)
            ->assertSee("id:'images'", false)
            ->assertSee('/admin/api/images', false)
            ->assertSee('openImageGroup', false)
            ->assertSee('imageGroups', false);
    }

    public function test_index_returns_empty_images_and_services(): void
    {
        $service = $this->service();

        $this->actingAs($this->admin())
            ->getJson('/admin/api/images')
            ->assertOk()
            ->assertJsonPath('images', [])
            ->assertJsonFragment(['id' => $service->id, 'slug' => 'retaining-wall']);
    }

    public function test_store_uploads_multiple_images_under_four_megabytes(): void
    {
        $service = $this->service();

        $response = $this->actingAs($this->admin())->post('/admin/api/images', [
            'service_id' => $service->id,
            'location' => 'กำแพงกันดิน ไทรม้า 19',
            'worked_date' => '2026-08-18',
            'files' => [
                UploadedFile::fake()->image('one.jpg', 80, 60)->size(1024),
                UploadedFile::fake()->image('two.png', 80, 60)->size(2048),
                UploadedFile::fake()->image('three.webp', 80, 60)->size(4096),
            ],
        ], ['Accept' => 'application/json']);

        $response->assertCreated()
            ->assertJsonPath('message', 'อัปโหลด 3 รูปเรียบร้อย')
            ->assertJsonCount(3, 'images');

        $this->assertDatabaseCount('image_uploads', 3);

        $paths = ImageUpload::query()->pluck('img_url');

        $this->assertCount(3, $paths);
        $paths->each(function (string $path) {
            $this->assertMatchesRegularExpression(
                '#^images/galleries/retaining-wall-[0-9a-f-]{36}-\d+\.(jpg|png|webp)$#',
                $path
            );
            Storage::disk('s3')->assertExists($path);
        });

        $this->assertEquals(
            ['กำแพงกันดิน ไทรม้า 19'],
            ImageUpload::query()->pluck('location')->unique()->values()->all()
        );
    }

    public function test_store_rejects_file_over_four_megabytes(): void
    {
        $service = $this->service();

        $this->actingAs($this->admin())
            ->post('/admin/api/images', [
                'service_id' => $service->id,
                'location' => 'ไทรม้า 19',
                'files' => [
                    UploadedFile::fake()->image('ok.jpg')->size(1024),
                    UploadedFile::fake()->image('too-big.jpg')->size(4097),
                ],
            ], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['files.1']);

        $this->assertDatabaseCount('image_uploads', 0);
        $this->assertSame([], Storage::disk('s3')->allFiles());
    }

    public function test_store_requires_files_location_and_service(): void
    {
        $this->actingAs($this->admin())
            ->postJson('/admin/api/images', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['service_id', 'location', 'files']);
    }

    public function test_store_rejects_non_image_file(): void
    {
        $service = $this->service();

        $this->actingAs($this->admin())
            ->post('/admin/api/images', [
                'service_id' => $service->id,
                'location' => 'ไทรม้า 19',
                'files' => [
                    UploadedFile::fake()->create('notes.pdf', 200, 'application/pdf'),
                ],
            ], ['Accept' => 'application/json'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['files.0']);
    }

    public function test_index_can_filter_by_location(): void
    {
        $service = $this->service();
        $this->upload($service, 'ไทรม้า 19');
        $this->upload($service, 'บางบัวทอง');

        $this->actingAs($this->admin())
            ->getJson('/admin/api/images?q='.urlencode('ไทรม้า'))
            ->assertOk()
            ->assertJsonCount(1, 'images')
            ->assertJsonPath('images.0.location', 'ไทรม้า 19');
    }

    public function test_index_handles_null_worked_date(): void
    {
        $service = $this->service();

        $service->images()->create([
            'img_url' => 'images/galleries/legacy.jpg',
            'location' => 'งานเก่า',
            'worked_date' => null,
        ]);

        $this->actingAs($this->admin())
            ->getJson('/admin/api/images')
            ->assertOk()
            ->assertJsonPath('images.0.location', 'งานเก่า')
            ->assertJsonPath('images.0.worked_date', '');
    }

    public function test_update_can_change_metadata_without_new_file(): void
    {
        $service = $this->service();
        $other = $this->service('รั้วบ้าน', 'fence');
        $image = $this->upload($service, 'เก่า');
        $originalPath = $image->img_url;

        $this->actingAs($this->admin())
            ->put('/admin/api/images/'.$image->id, [
                'service_id' => $other->id,
                'location' => 'รั้วบ้าน ราชพฤกษ์',
                'worked_date' => '2026-01-15',
            ], ['Accept' => 'application/json'])
            ->assertOk()
            ->assertJsonPath('image.location', 'รั้วบ้าน ราชพฤกษ์')
            ->assertJsonPath('image.service_id', $other->id)
            ->assertJsonPath('image.img_url', $originalPath);

        Storage::disk('s3')->assertExists($originalPath);
        $this->assertDatabaseHas('image_uploads', [
            'id' => $image->id,
            'imageable_id' => $other->id,
            'imageable_type' => Service::class,
            'location' => 'รั้วบ้าน ราชพฤกษ์',
        ]);
    }

    public function test_update_replaces_file_and_deletes_old_object(): void
    {
        $service = $this->service();
        $image = $this->upload($service, 'ไทรม้า 19');
        $oldPath = $image->img_url;

        $this->actingAs($this->admin())
            ->put('/admin/api/images/'.$image->id, [
                'service_id' => $service->id,
                'location' => 'ไทรม้า 19',
                'file' => UploadedFile::fake()->image('replacement.jpg')->size(512),
            ], ['Accept' => 'application/json'])
            ->assertOk();

        $image->refresh();
        $this->assertNotSame($oldPath, $image->img_url);
        Storage::disk('s3')->assertMissing($oldPath);
        Storage::disk('s3')->assertExists($image->img_url);
    }

    public function test_destroy_deletes_row_and_storage_object(): void
    {
        $image = $this->upload($this->service(), 'ไทรม้า 19');
        $path = $image->img_url;

        $this->actingAs($this->admin())
            ->deleteJson('/admin/api/images/'.$image->id)
            ->assertOk()
            ->assertJsonPath('message', 'ลบรายการเรียบร้อย');

        $this->assertDatabaseMissing('image_uploads', ['id' => $image->id]);
        Storage::disk('s3')->assertMissing($path);
    }

    public function test_rename_location_updates_all_images_in_the_group(): void
    {
        $service = $this->service();
        $this->upload($service, 'ไทรม้า 19');
        $this->upload($service, 'ไทรม้า 19');
        $this->upload($service, 'บางบัวทอง');

        $this->actingAs($this->admin())
            ->putJson('/admin/api/images/locations', [
                'from' => 'ไทรม้า 19',
                'to' => 'กำแพงกันดิน ไทรม้า 19',
            ])
            ->assertOk()
            ->assertJsonPath('count', 2)
            ->assertJsonPath('location', 'กำแพงกันดิน ไทรม้า 19');

        $this->assertSame(2, ImageUpload::query()->where('location', 'กำแพงกันดิน ไทรม้า 19')->count());
        $this->assertSame(1, ImageUpload::query()->where('location', 'บางบัวทอง')->count());
    }

    public function test_rename_empty_location_group(): void
    {
        $service = $this->service();
        $service->images()->create([
            'img_url' => 'images/galleries/legacy.jpg',
            'location' => '',
            'worked_date' => null,
        ]);

        $this->actingAs($this->admin())
            ->putJson('/admin/api/images/locations', [
                'from' => '',
                'to' => 'งานเก่า ไม่ระบุสถานที่',
            ])
            ->assertOk()
            ->assertJsonPath('count', 1);

        $this->assertDatabaseHas('image_uploads', [
            'location' => 'งานเก่า ไม่ระบุสถานที่',
        ]);
    }

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    private function service(string $title = 'กำแพงกันดิน', string $slug = 'retaining-wall'): Service
    {
        $category = ServiceCategory::query()->firstOrCreate(
            ['slug' => 'structure'],
            ['name' => 'งานโครงสร้าง']
        );

        return Service::query()->create([
            'service_category_id' => $category->id,
            'title' => $title,
            'slug' => $slug,
        ]);
    }

    private function upload(Service $service, string $location): ImageUpload
    {
        $this->actingAs($this->admin())->post('/admin/api/images', [
            'service_id' => $service->id,
            'location' => $location,
            'files' => [
                UploadedFile::fake()->image('shot.jpg')->size(200),
            ],
        ], ['Accept' => 'application/json'])->assertCreated();

        return ImageUpload::query()->latest('id')->firstOrFail();
    }
}
