<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\SitemapBuilder;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        return response(SitemapBuilder::toXml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
