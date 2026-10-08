<?php

namespace Tests\Unit;

use App\Models\Service;
use App\Support\CompanyPhone;
use Illuminate\Http\Request;
use Tests\TestCase;

class CompanyPhoneTest extends TestCase
{
    public function test_default_phone_is_department_number(): void
    {
        $phone = CompanyPhone::default();

        $this->assertSame('0615639228', $phone['phone']);
        $this->assertSame('061-563-9228', $phone['phone_formatted']);
    }

    public function test_legacy_service_slugs_keep_old_number(): void
    {
        foreach (['retaining-wall', 'fence', 'pour-concrete', 'dam'] as $slug) {
            $service = new Service(['slug' => $slug]);
            $phone = CompanyPhone::forService($service);

            $this->assertSame('0627188847', $phone['phone'], $slug);
            $this->assertSame('062-718-8847', $phone['phone_formatted'], $slug);
        }
    }

    public function test_other_service_slugs_use_default_number(): void
    {
        $service = new Service(['slug' => 'cctv-installation']);
        $phone = CompanyPhone::forService($service);

        $this->assertSame('0615639228', $phone['phone']);
        $this->assertSame('061-563-9228', $phone['phone_formatted']);
    }

    public function test_home_route_uses_legacy_number(): void
    {
        $request = Request::create('/');
        $request->setRouteResolver(function () {
            $route = new \Illuminate\Routing\Route(['GET'], '/', fn () => null);
            $route->name('home');

            return $route;
        });

        $this->app->instance('request', $request);

        $phone = CompanyPhone::forCurrentRequest();

        $this->assertSame('0627188847', $phone['phone']);
        $this->assertSame('062-718-8847', $phone['phone_formatted']);
    }
}
