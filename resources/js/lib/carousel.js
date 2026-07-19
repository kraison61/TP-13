/**
 * Shared horizontal carousel (finance + testimonials).
 */
export function initCarousel({
    viewportId,
    trackId,
    navId,
    prevId,
    nextId,
    slideClass,
    interval = 5500,
}) {
    const viewport = document.getElementById(viewportId);
    const track = document.getElementById(trackId);
    const nav = document.getElementById(navId);
    const prevBtn = document.getElementById(prevId);
    const nextBtn = document.getElementById(nextId);

    if (!viewport || !track) return;

    const slides = [...track.querySelectorAll(`.${slideClass}`)];
    const total = slides.length;
    if (total === 0) return;

    const mqTablet = window.matchMedia('(min-width: 768px)');
    const mqDesktop = window.matchMedia('(min-width: 1024px)');

    let index = 0;
    let timer = null;
    let slidesPerView = 1;
    let maxIndex = 0;

    const getSlidesPerView = () => {
        if (mqDesktop.matches) return 3;
        if (mqTablet.matches) return 2;
        return 1;
    };

    const offsetFor = (i) => slides[i]?.offsetLeft ?? 0;

    const updateNav = () => {
        const scrollable = total > slidesPerView;
        prevBtn?.toggleAttribute('disabled', !scrollable || index === 0);
        nextBtn?.toggleAttribute('disabled', !scrollable || index >= maxIndex);
    };

    const go = (n) => {
        index = Math.max(0, Math.min(n, maxIndex));
        track.style.transform = `translateX(-${offsetFor(index)}px)`;
        updateNav();
    };

    const play = () => {
        clearInterval(timer);
        if (total <= slidesPerView) return;
        timer = setInterval(() => go(index >= maxIndex ? 0 : index + 1), interval);
    };

    const layout = () => {
        slidesPerView = getSlidesPerView();
        maxIndex = Math.max(0, total - slidesPerView);
        index = Math.min(index, maxIndex);

        track.style.transform = `translateX(-${offsetFor(index)}px)`;

        const scrollable = total > slidesPerView;
        nav?.classList.toggle('hidden', !scrollable);

        updateNav();

        if (!scrollable) clearInterval(timer);
        else if (!timer) play();
    };

    prevBtn?.addEventListener('click', () => { go(index - 1); play(); });
    nextBtn?.addEventListener('click', () => { go(index + 1); play(); });

    viewport.addEventListener('mouseenter', () => clearInterval(timer));
    viewport.addEventListener('mouseleave', play);

    let touchStartX = null;
    viewport.addEventListener('touchstart', (e) => { touchStartX = e.touches[0].clientX; }, { passive: true });
    viewport.addEventListener('touchend', (e) => {
        if (touchStartX === null) return;
        const dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
        touchStartX = null;
        play();
    }, { passive: true });

    mqTablet.addEventListener('change', layout);
    mqDesktop.addEventListener('change', layout);
    window.addEventListener('resize', layout, { passive: true });

    layout();
    play();
}
