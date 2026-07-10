@extends('layouts.frontend')

@section('content')
<article class="mx-auto max-w-4xl px-6 py-16 lg:py-24">
    @if ($blog->service)
        <a href="{{ route('frontend.services.show', $blog->service->slug) }}"
           class="inline-flex items-center gap-2 text-accent font-semibold tracking-[0.18em] text-xs uppercase hover:text-navy-900 transition">
            <span class="w-7 h-px bg-accent"></span> {{ $blog->service->title }}
        </a>
    @endif

    <h1 class="mt-4 text-3xl lg:text-4xl font-bold tracking-tight text-navy-900">{{ $blog->title }}</h1>
    <p class="mt-4 text-lg text-ink2">{{ $blog->description }}</p>

    @if ($blog->cover_image)
        <div class="mt-8 rounded-2xl overflow-hidden ring-1 ring-line">
            @if (str_starts_with($blog->cover_image, 'http'))
                <img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" class="w-full object-cover">
            @else
                <img src="{{ Storage::disk('s3')->url($blog->cover_image) }}?width=1200&format=webp&fit=cover"
                     alt="{{ $blog->title }}" class="w-full object-cover">
            @endif
        </div>
    @endif

    <div class="mt-10 prose prose-lg max-w-none text-ink2">
        {!! $blog->content !!}
    </div>
</article>

@if ($relatedBlogs->isNotEmpty())
    <section class="bg-surface border-t border-line">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <h2 class="text-2xl font-bold text-navy-900 mb-8">บทความที่เกี่ยวข้อง</h2>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach ($relatedBlogs as $related)
                    <a href="{{ route('blog.show', $related->slug) }}" class="group block rounded-2xl bg-white ring-1 ring-line p-5 hover:shadow-lg transition">
                        <h3 class="font-bold text-navy-900 group-hover:text-accent transition">{{ $related->title }}</h3>
                        <p class="mt-2 text-[14px] text-ink2 line-clamp-2">{{ $related->description }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
