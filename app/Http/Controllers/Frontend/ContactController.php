<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ContactController extends Controller
{
    public function index()
    {
        $serviceOptions = Service::query()
            ->where('is_active', true)
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('frontend.contact-us', compact('serviceOptions'));
    }
}
