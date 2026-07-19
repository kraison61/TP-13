// ── Critical path: nav + scroll-to-top ──────────────────────────────────────

const activateDeferredImages = (root = document) => {
    root.querySelectorAll('img.defer-img[data-src]').forEach((img) => {
        const src = img.dataset.src;
        if (!src) {
            return;
        }

        const load = () => {
            img.src = src;
            img.removeAttribute('data-src');
            img.classList.remove('defer-img');
        };

        if (!('IntersectionObserver' in window)) {
            load();
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                observer.disconnect();
                load();
            }
        }, { rootMargin: '0px 0px 120px 0px' });

        observer.observe(img);
    });
};

activateDeferredImages();

const toTopBtn = document.getElementById('toTopBtn');

window.addEventListener('scroll', () => {
    const show = window.scrollY > 400;
    toTopBtn?.classList.toggle('opacity-0', !show);
    toTopBtn?.classList.toggle('pointer-events-none', !show);
    toTopBtn?.classList.toggle('translate-y-2', !show);
}, { passive: true });

toTopBtn?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

const menuBtn = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');

const closeMobileMenu = () => {
    mobileMenu?.classList.add('hidden');
    mobileMenuBackdrop?.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

const openMobileMenu = () => {
    mobileMenu?.classList.remove('hidden');
    mobileMenuBackdrop?.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

menuBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    const open = mobileMenu?.classList.contains('hidden');
    open ? openMobileMenu() : closeMobileMenu();
    menuBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
    menuBtn?.setAttribute('aria-label', open ? 'ปิดเมนู' : 'เปิดเมนู');
});

mobileMenuBackdrop?.addEventListener('click', () => {
    closeMobileMenu();
    menuBtn?.setAttribute('aria-expanded', 'false');
    menuBtn?.setAttribute('aria-label', 'เปิดเมนู');
});

mobileMenu?.addEventListener('click', (e) => {
    if (e.target.closest('a')) {
        closeMobileMenu();
        menuBtn?.setAttribute('aria-expanded', 'false');
        menuBtn?.setAttribute('aria-label', 'เปิดเมนู');
    }
});

// ── Below-fold / page-specific modules (dynamic import) ─────────────────────

const lazyWhenElement = (el, importer) => {
    if (!el) return;

    const run = () => importer();

    if (!('IntersectionObserver' in window)) {
        run();
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            if (entries.some((entry) => entry.isIntersecting)) {
                observer.disconnect();
                run();
            }
        },
        { rootMargin: '320px' },
    );

    observer.observe(el);
};

const lazyWhenVisible = (selector, importer) => {
    lazyWhenElement(document.querySelector(selector), importer);
};

const lazyWhenAnyPresent = (selectors, importer) => {
    const el = selectors.map((selector) => document.querySelector(selector)).find(Boolean);
    lazyWhenElement(el, importer);
};

lazyWhenAnyPresent(['#gallery-filters', '#gallery-lb'], () => import('./gallery.js'));
lazyWhenVisible('#contact', () => import('./contact-form.js'));
lazyWhenVisible('#testiViewport', () => import('./testimonials.js'));
lazyWhenVisible('#finViewport', () => import('./finance.js'));
lazyWhenElement(document.getElementById('soil-calc'), () => import('./soil-calc.js'));
lazyWhenAnyPresent(['#faqItems', '#faqListCalc'], () => import('./faq.js'));
