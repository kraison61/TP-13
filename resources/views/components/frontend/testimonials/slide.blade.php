@props(['testimonial'])

<figure class="testi-slide w-[100cqw] max-w-full shrink-0 @md:w-[calc((100cqw-1.25rem)/2)] @lg:w-[calc((100cqw-2.5rem)/3)] min-h-[18rem] rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
    <div class="text-hivis text-[15px] mb-4">
        @for ($i = 0; $i < max(0, (int) ($testimonial['rating'] ?? 5)); $i++)
            <x-icon name="star-fill" class="inline-block" />
        @endfor
    </div>
    <blockquote class="text-ink leading-relaxed flex-1 line-clamp-4">{{ $testimonial['quote'] }}</blockquote>
    <figcaption class="mt-5 flex items-center gap-3">
        <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">{{ $testimonial['i'] }}</span>
        <span class="min-w-0">
            <span class="block font-semibold text-navy-900 text-[15px] truncate">{{ $testimonial['name'] }}</span>
            <span class="block text-[13px] text-muted truncate">{{ $testimonial['project'] }}</span>
        </span>
    </figcaption>
</figure>
