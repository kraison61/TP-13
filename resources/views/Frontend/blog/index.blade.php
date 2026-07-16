@extends('layouts.frontend')

@section('content')
<x-frontend.page-hero
    :current="$hero['current'] ?? null"
    :eyebrow="$hero['eyebrow'] ?? ''"
    :title="$hero['title'] ?? ''"
    :description="$hero['description'] ?? ''"
    :badges="$hero['badges'] ?? []"
/>

<main class="mx-auto max-w-7xl px-4 sm:px-6 py-16 lg:py-24">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($blogs as $blog)
            <a href="{{ route('blog.show', $blog->slug) }}"
               class="group block rounded-2xl overflow-hidden ring-1 ring-line bg-white hover:shadow-lg transition">
                @if ($blog->cover_image)
                    @if (str_starts_with($blog->cover_image, 'http'))
                        <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" loading="lazy" class="aspect-4/3 w-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <img src="{{ Storage::disk('s3')->url($blog->cover_image) }}?width=600&format=webp&fit=cover"
                             alt="{{ $blog->title }}" loading="lazy" class="aspect-4/3 w-full object-cover group-hover:scale-105 transition duration-500">
                    @endif
                @endif
                <div class="p-5">
                    @if ($blog->service)
                        <span class="text-[12px] font-semibold uppercase tracking-wide text-accent">{{ $blog->service->title }}</span>
                    @endif
                    <h2 class="mt-2 text-lg font-bold text-navy-900 group-hover:text-accent transition">{{ $blog->title }}</h2>
                    <p class="mt-2 text-[15px] text-ink2 line-clamp-2">{{ $blog->description }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $blogs->links() }}
    </div>
</main>
@endsection
