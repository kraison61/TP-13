/**
 * Infinite horizontal marquee (auto-scroll).
 */
export function initMarquee({
    viewportId,
    trackId,
    speed = 0.45,
}) {
    const viewport = document.getElementById(viewportId);
    const track = document.getElementById(trackId);

    if (!viewport || !track || track.dataset.marqueeInit === 'true') {
        return;
    }

    track.dataset.marqueeInit = 'true';

    const originals = [...track.children];
    if (originals.length === 0) {
        return;
    }

    const cloneItems = () => originals.map((item) => item.cloneNode(true));

    while (track.scrollWidth < viewport.offsetWidth * 2) {
        cloneItems().forEach((clone) => track.appendChild(clone));
    }

    cloneItems().forEach((clone) => track.appendChild(clone));

    const segmentWidth = track.scrollWidth / 2;
    let offset = 0;
    let paused = false;
    let frame = null;

    const step = () => {
        if (!paused) {
            offset += speed;
            if (offset >= segmentWidth) {
                offset -= segmentWidth;
            }
            track.style.transform = `translate3d(-${offset}px,0,0)`;
        }

        frame = requestAnimationFrame(step);
    };

    const pause = () => { paused = true; };
    const resume = () => { paused = false; };

    viewport.addEventListener('mouseenter', pause);
    viewport.addEventListener('mouseleave', resume);
    viewport.addEventListener('focusin', pause);
    viewport.addEventListener('focusout', resume);

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    const applyMotion = () => {
        if (reducedMotion.matches) {
            paused = true;
            if (frame) {
                cancelAnimationFrame(frame);
                frame = null;
            }
            track.style.transform = '';
            return;
        }

        if (!frame) {
            paused = false;
            frame = requestAnimationFrame(step);
        }
    };

    reducedMotion.addEventListener('change', applyMotion);
    applyMotion();
}
