<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceScope;
use Illuminate\Database\Seeder;

class ServiceScopeSeeder extends Seeder
{
    public function run(): void
    {
        $scopesBySlug = config('frontend.service_scopes', []);

        foreach ($scopesBySlug as $slug => $items) {
            $service = Service::query()->where('slug', $slug)->first();

            if (! $service) {
                continue;
            }

            ServiceScope::query()->where('service_id', $service->id)->delete();

            foreach ($items as $index => $item) {
                ServiceScope::query()->create([
                    'service_id' => $service->id,
                    'name' => $item['name'],
                    'description' => $item['description'] ?? null,
                    'group' => $item['group'] ?? 'included',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
