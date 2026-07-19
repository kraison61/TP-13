// Gallery page — category filter
const galleryFilters = document.getElementById('gallery-filters');
const galleryGrid = document.getElementById('gallery-grid');
const galleryEmpty = document.getElementById('gallery-empty');
const galleryCount = document.getElementById('gallery-count');

let activeGalleryFilter = 'all';

const setGalleryFilterButtonState = (activeBtn) => {
    galleryFilters?.querySelectorAll('[data-filter]').forEach((btn) => {
        const on = btn === activeBtn;
        btn.classList.toggle('bg-navy-900', on);
        btn.classList.toggle('border-navy-900', on);
        btn.classList.toggle('text-white', on);
        btn.classList.toggle('bg-white', !on);
        btn.classList.toggle('text-navy-900', !on);
        btn.setAttribute('aria-selected', on ? 'true' : 'false');
    });
};

const applyGalleryFilters = () => {
    let visible = 0;

    galleryGrid?.querySelectorAll('[data-gallery-card]').forEach((card) => {
        const matches = activeGalleryFilter === 'all' || card.dataset.cat === activeGalleryFilter;
        card.classList.toggle('hidden', !matches);
        if (matches) visible++;
    });

    if (galleryCount) galleryCount.textContent = String(visible);
    galleryEmpty?.classList.toggle('hidden', visible > 0);
    galleryGrid?.classList.toggle('hidden', visible === 0);
};

galleryFilters?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-filter]');
    if (!btn) return;

    activeGalleryFilter = btn.dataset.filter;
    setGalleryFilterButtonState(btn);
    applyGalleryFilters();
});

// Gallery detail — lightbox (native dialog)
(function () {
    const lb = document.getElementById('gallery-lb');
    if (!lb) return;

    const main = document.getElementById('gallery-lb-main');
    const caption = document.getElementById('gallery-lb-caption');
    const counter = document.getElementById('gallery-lb-counter');
    const prevBtn = document.getElementById('gallery-lb-prev');
    const nextBtn = document.getElementById('gallery-lb-next');
    const photos = [...document.querySelectorAll('[data-gallery-photo]')];
    const thumbs = [...document.querySelectorAll('[data-gallery-thumb]')];
    let idx = 0;

    const show = (i) => {
        idx = (i + photos.length) % photos.length;
        const el = photos[idx];
        main.src = el.dataset.src;
        main.alt = el.dataset.caption;
        caption.textContent = el.dataset.caption;
        counter.textContent = `${idx + 1} / ${photos.length}`;
        thumbs.forEach((t, n) => {
            t.classList.toggle('opacity-100', n === idx);
            t.classList.toggle('ring-2', n === idx);
            t.classList.toggle('opacity-45', n !== idx);
        });
    };

    photos.forEach((el) => el.addEventListener('click', () => {
        show(Number(el.dataset.index));
        lb.showModal();
    }));

    thumbs.forEach((el) => el.addEventListener('click', () => show(Number(el.dataset.index))));
    prevBtn?.addEventListener('click', () => show(idx - 1));
    nextBtn?.addEventListener('click', () => show(idx + 1));

    lb.addEventListener('click', (e) => {
        if (e.target === lb) lb.close();
    });

    document.addEventListener('keydown', (e) => {
        if (!lb.open) return;
        if (e.key === 'ArrowLeft') show(idx - 1);
        if (e.key === 'ArrowRight') show(idx + 1);
    });
})();
