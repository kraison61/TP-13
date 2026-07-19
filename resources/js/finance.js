import { initCarousel } from './lib/carousel.js';

const icon = (name, className = 'icon') =>
    `<svg class="${className}" viewBox="0 0 16 16" aria-hidden="true"><use href="#icon-${name}"/></svg>`;

const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;');

const renderPartnerSlide = (partner) => {
    const features = (partner.features ?? [])
        .map((feature) => `
            <li class="flex items-start gap-2 text-white/75">
                <span style="color:#ffc83a">${icon('check-circle-fill', 'icon mt-0.5 shrink-0 text-[13px]')}</span>
                <span>${escapeHtml(feature)}</span>
            </li>`)
        .join('');

    return `
        <div class="fin-slide w-[100cqw] max-w-full shrink-0 @md:w-[calc((100cqw-1rem)/2)] @lg:w-[calc((100cqw-2rem)/3)] min-h-[22rem]">
            <div class="relative flex h-full flex-col overflow-hidden rounded-xl bg-navy-900 text-white">
                <div class="h-1 shrink-0" style="background:${escapeHtml(partner.color)}"></div>
                <div class="pointer-events-none absolute -right-10 -top-10 size-40 rounded-full opacity-10" style="background:${escapeHtml(partner.color)};filter:blur(40px)"></div>
                <div class="relative px-4 pt-4">
                    <a href="${escapeHtml(partner.link)}" target="_blank" rel="noopener" class="block overflow-hidden rounded-lg transition hover:opacity-90">
                        <div class="aspect-[3/1] overflow-hidden">
                            <img src="${escapeHtml(partner.img)}" alt="${escapeHtml(partner.name)}" width="600" height="200" loading="lazy" fetchpriority="low" decoding="async" class="block h-full w-full object-cover" />
                        </div>
                    </a>
                </div>
                <div class="flex flex-1 flex-col gap-3 p-4 pt-3">
                    <div class="flex items-center gap-2.5">
                        <span class="grid size-9 shrink-0 place-items-center rounded-lg text-lg text-navy-900" style="background:#ffc83a">
                            ${icon(partner.icon, 'icon')}
                        </span>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold leading-tight text-white">${escapeHtml(partner.name)}</div>
                            <div class="mt-0.5 text-[11px] text-white/50">${escapeHtml(partner.type)}</div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 text-[10px] font-semibold uppercase tracking-widest text-white/40">วงเงินกู้สูงสุด</div>
                        <div class="font-bold tabular-nums text-white">${escapeHtml(partner.max_amount)}</div>
                        <div class="mt-1.5 inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[11px] font-semibold" style="background:${escapeHtml(partner.rgba_color)};color:#ffc83a">
                            ${icon('percent', 'icon')} ${escapeHtml(partner.rate)}
                        </div>
                    </div>
                    <ul class="flex flex-1 flex-col gap-1.5 text-[13px]">${features}</ul>
                    <a href="${escapeHtml(partner.link)}" target="_blank" rel="noopener"
                       class="mt-auto inline-flex items-center justify-center gap-2 rounded-lg py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
                       style="background:${escapeHtml(partner.color)}">
                        สมัครเลย ${icon('arrow-right', 'icon')}
                    </a>
                </div>
            </div>
        </div>`;
};

const hydrateFinanceTrack = () => {
    const track = document.getElementById('finTrack');
    const dataEl = document.getElementById('finPartnersData');

    if (!track || !dataEl || track.dataset.hydrated === 'true') {
        return;
    }

    const partners = JSON.parse(dataEl.textContent || '[]');
    track.innerHTML = partners.map(renderPartnerSlide).join('');
    track.dataset.hydrated = 'true';
    track.removeAttribute('aria-busy');
    dataEl.remove();

    initCarousel({
        viewportId: 'finViewport',
        trackId: 'finTrack',
        navId: 'finNav',
        prevId: 'finPrev',
        nextId: 'finNext',
        slideClass: 'fin-slide',
    });
};

hydrateFinanceTrack();
