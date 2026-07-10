<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('activePrice')
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        $blogs = Blog::with('service')
            ->whereNotNull('service_id')
            ->whereHas('service', fn ($q) => $q->where('is_active', true))
            ->latest()
            ->get();

        $filterServices = Service::query()
            ->where('is_active', true)
            ->whereHas('blogs', fn ($q) => $q->whereNotNull('service_id'))
            ->withCount(['blogs' => fn ($q) => $q->whereNotNull('service_id')])
            ->orderBy('title')
            ->get();

        return view('Frontend.index', compact('services', 'blogs', 'filterServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
