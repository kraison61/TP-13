import { initCarousel } from './lib/carousel.js';

const icon = (name) =>
    `<svg class="icon inline-block" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><use href="#icon-${name}"/></svg>`;

const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;');

const renderStars = (rating = 5) => icon('star-fill').repeat(Math.max(0, Number(rating) || 0));

const renderTestimonialSlide = (testimonial) => `
    <figure class="testi-slide w-[100cqw] max-w-full shrink-0 @md:w-[calc((100cqw-1.25rem)/2)] @lg:w-[calc((100cqw-2.5rem)/3)] min-h-[18rem] rounded-2xl bg-white ring-1 ring-line p-7 flex flex-col">
        <div class="text-hivis text-[15px] mb-4">${renderStars(testimonial.rating)}</div>
        <blockquote class="text-ink leading-relaxed flex-1 line-clamp-4">${escapeHtml(testimonial.quote)}</blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
            <span class="grid place-items-center w-10 h-10 rounded-full bg-surface text-navy-900 font-bold">${escapeHtml(testimonial.i)}</span>
            <span class="min-w-0">
                <span class="block font-semibold text-navy-900 text-[15px] truncate">${escapeHtml(testimonial.name)}</span>
                <span class="block text-[13px] text-muted truncate">${escapeHtml(testimonial.project)}</span>
            </span>
        </figcaption>
    </figure>`;

const hydrateTestimonialsTrack = () => {
    const track = document.getElementById('testiTrack');
    const dataEl = document.getElementById('testiData');

    if (!track || !dataEl || track.dataset.hydrated === 'true') {
        return;
    }

    const testimonials = JSON.parse(dataEl.textContent || '[]');
    track.innerHTML = testimonials.map(renderTestimonialSlide).join('');
    track.dataset.hydrated = 'true';
    track.removeAttribute('aria-busy');
    dataEl.remove();

    initCarousel({
        viewportId: 'testiViewport',
        trackId: 'testiTrack',
        navId: 'testiNav',
        prevId: 'testiPrev',
        nextId: 'testiNext',
        slideClass: 'testi-slide',
    });
};

hydrateTestimonialsTrack();
