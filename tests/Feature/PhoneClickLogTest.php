<?php

namespace Tests\Feature;

use App\Models\PhoneClickLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneClickLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_phone_click_log(): void
    {
        $response = $this->post('/phone-clicks', [
            'phone' => '062-718-8847',
            'page_url' => '/retaining-wall',
            'placement' => 'footer',
        ]);

        $response->assertOk()->assertJson(['saved' => true]);

        $this->assertDatabaseHas('phone_click_logs', [
            'phone' => '0627188847',
            'page_url' => '/retaining-wall',
            'placement' => 'footer',
        ]);

        $this->assertSame(1, PhoneClickLog::query()->count());
    }

    public function test_rejects_missing_phone(): void
    {
        $response = $this->postJson('/phone-clicks', [
            'page_url' => '/',
        ]);

        $response->assertStatus(422);
        $this->assertSame(0, PhoneClickLog::query()->count());
    }
}
