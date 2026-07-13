// Scroll to top
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

// Mobile menu
const menuBtn            = document.getElementById('menuBtn');
const mobileMenu         = document.getElementById('mobileMenu');
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
    mobileMenu?.classList.contains('hidden') ? openMobileMenu() : closeMobileMenu();
});

mobileMenuBackdrop?.addEventListener('click', closeMobileMenu);

mobileMenu?.addEventListener('click', e => {
    if (e.target.closest('a')) closeMobileMenu();
});

// Project / portfolio filter
const projectFilters = document.getElementById('project-filters');
const projectGrid = document.getElementById('project-grid');
const projectSearch = document.getElementById('project-search');
const projectEmpty = document.getElementById('project-empty');

let activeProjectFilter = 'all';

const setProjectFilterButtonState = (activeBtn) => {
    projectFilters?.querySelectorAll('[data-filter]').forEach(btn => {
        const on = btn === activeBtn;
        btn.classList.toggle('bg-navy-900', on);
        btn.classList.toggle('text-white', on);
        btn.classList.toggle('border-navy-900', on);
        btn.classList.toggle('text-ink2', !on);
        btn.classList.toggle('border-line', !on);
        btn.classList.toggle('bg-transparent', !on);
        btn.setAttribute('aria-selected', on ? 'true' : 'false');
    });
};

const applyProjectFilters = () => {
    const query = (projectSearch?.value || '').trim().toLowerCase();
    let visible = 0;

    projectGrid?.querySelectorAll('[data-project-card]').forEach(card => {
        const matchesCategory = activeProjectFilter === 'all' || card.dataset.cat === activeProjectFilter;
        const matchesSearch = !query
            || (card.dataset.title || '').toLowerCase().includes(query)
            || (card.dataset.serviceTitle || '').toLowerCase().includes(query);
        const show = matchesCategory && matchesSearch;

        card.classList.toggle('hidden', !show);
        if (show) visible++;
    });

    projectEmpty?.classList.toggle('hidden', visible > 0);
};

projectFilters?.addEventListener('click', e => {
    const btn = e.target.closest('[data-filter]');
    if (!btn) return;

    activeProjectFilter = btn.dataset.filter;
    setProjectFilterButtonState(btn);
    applyProjectFilters();
});

projectSearch?.addEventListener('input', applyProjectFilters);

// Finance carousel — Tailwind breakpoints: mobile 1 / tablet 2 / desktop 3
(function () {
    const viewport = document.getElementById('finViewport');
    const track = document.getElementById('finTrack');
    const nav = document.getElementById('finNav');
    const prevBtn = document.getElementById('finPrev');
    const nextBtn = document.getElementById('finNext');

    if (!viewport || !track) return;

    const slides = [...track.querySelectorAll('.fin-slide')];
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

    const offsetFor = (i) => {
        const slide = slides[i];
        if (!slide) return 0;
        return slide.offsetLeft;
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
        timer = setInterval(() => go(index >= maxIndex ? 0 : index + 1), 5500);
    };

    prevBtn?.addEventListener('click', () => { go(index - 1); play(); });
    nextBtn?.addEventListener('click', () => { go(index + 1); play(); });

    viewport.addEventListener('mouseenter', () => clearInterval(timer));
    viewport.addEventListener('mouseleave', play);

    let touchStartX = null;
    viewport.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    viewport.addEventListener('touchend', e => {
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
})();

// Testimonial tabs
document.getElementById('testTabs')?.addEventListener('click', e => {
    const btn = e.target.closest('[data-tab]');
    if (!btn) return;
    const tab = btn.dataset.tab;

    document.querySelectorAll('[data-tab]').forEach(b => {
        const on = b === btn;
        b.classList.toggle('bg-navy-900', on);
        b.classList.toggle('text-white', on);
        b.classList.toggle('border', !on);
        b.classList.toggle('bg-white', !on);
        b.classList.toggle('text-ink2', !on);
        b.classList.toggle('border-line', !on);
    });

    document.querySelectorAll('[data-panel]').forEach(p => {
        p.classList.toggle('hidden', p.dataset.panel !== tab);
    });
});

// FAQ accordion — one item open at a time
document.getElementById('faqItems')?.addEventListener('toggle', e => {
    if (e.target.tagName !== 'DETAILS' || !e.target.open) return;
    e.currentTarget.querySelectorAll('details[open]').forEach(d => {
        if (d !== e.target) d.open = false;
    });
});

// Copy discount reference code + record once in database
document.getElementById('copyRefBtn')?.addEventListener('click', async e => {
    const btn = e.currentTarget;
    const code = btn.dataset.copy;

    try {
        await navigator.clipboard.writeText(code);
    } catch {
        return;
    }

    const icon  = document.getElementById('copyRefIcon');
    const label = document.getElementById('copyRefLabel');
    icon.classList.replace('bi-clipboard', 'bi-clipboard-check-fill');
    label.textContent = 'คัดลอกแล้ว';
    setTimeout(() => {
        icon.classList.replace('bi-clipboard-check-fill', 'bi-clipboard');
        label.textContent = 'คัดลอก';
    }, 2000);

    if (btn.dataset.recorded === '1' || !btn.dataset.saveUrl) return;

    const quoteForm = document.getElementById('quoteForm');

    try {
        const response = await fetch(btn.dataset.saveUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': quoteForm?.querySelector('input[name="_token"]')?.value || '',
            },
            body: JSON.stringify({ reference: code }),
        });

        if (response.ok) {
            btn.dataset.recorded = '1';
        }
    } catch {
        // copy succeeded; recording is best-effort
    }
});

// Quote form — dynamic E-Voucher + AJAX submit
const quoteForm = document.getElementById('quoteForm');
if (quoteForm) {
    const voucherTiers = JSON.parse(quoteForm.dataset.voucherTiers || '[]');
    const voucherDefault = JSON.parse(quoteForm.dataset.voucherDefault || '{}');
    const tierMap = Object.fromEntries(voucherTiers.map(t => [t.budget, t]));

    const budgetSelect = document.getElementById('budgetSelect');
    const voucherAmount = document.getElementById('voucherAmount');
    const voucherMessage = document.getElementById('voucherMessage');
    const voucherTerms = document.getElementById('voucherTerms');
    const requestedDiscount = document.getElementById('requestedDiscount');
    const voucherCard = document.getElementById('voucherCard');
    const quoteError = document.getElementById('quoteError');
    const quoteErrorText = document.getElementById('quoteErrorText');
    const quoteOK = document.getElementById('quoteOK');
    const quoteSubmitBtn = document.getElementById('quoteSubmitBtn');

    const setVoucherDefault = () => {
        voucherAmount.textContent = voucherDefault.amount_label || 'สูงสุด 20,000 บาท';
        voucherMessage.textContent = voucherDefault.message || '';
        voucherTerms.textContent = '';
        voucherTerms.classList.add('hidden');
        requestedDiscount.value = '';
        voucherCard?.classList.remove('ring-2', 'ring-hivis/50');
    };

    const setVoucherTier = (tier) => {
        voucherAmount.textContent = `${tier.amount_formatted} บาท`;
        voucherMessage.textContent = tier.message;
        voucherTerms.textContent = tier.terms;
        voucherTerms.classList.remove('hidden');
        requestedDiscount.value = tier.amount;
        voucherCard?.classList.add('ring-2', 'ring-hivis/50');
    };

    budgetSelect?.addEventListener('change', () => {
        const tier = tierMap[budgetSelect.value];
        if (tier) {
            setVoucherTier(tier);
        } else {
            setVoucherDefault();
        }
    });

    setVoucherDefault();

    // Terms modal
    const termsModal = document.getElementById('voucherTermsModal');
    const openTermsModal = () => {
        termsModal?.classList.remove('hidden');
        termsModal?.setAttribute('aria-hidden', 'false');
    };
    const closeTermsModal = () => {
        termsModal?.classList.add('hidden');
        termsModal?.setAttribute('aria-hidden', 'true');
    };

    document.getElementById('voucherTermsBtn')?.addEventListener('click', openTermsModal);
    document.getElementById('voucherTermsClose')?.addEventListener('click', closeTermsModal);
    document.getElementById('voucherTermsCloseBtn')?.addEventListener('click', closeTermsModal);
    document.getElementById('voucherTermsBackdrop')?.addEventListener('click', closeTermsModal);

    quoteForm.addEventListener('submit', async e => {
        e.preventDefault();
        quoteError?.classList.add('hidden');
        quoteOK?.classList.add('hidden');

        if (!quoteForm.checkValidity()) {
            quoteForm.reportValidity();
            return;
        }

        if (!requestedDiscount.value) {
            quoteErrorText.textContent = 'กรุณาเลือกช่วงงบประมาณเพื่อเช็คสิทธิ์ E-Voucher';
            quoteError.classList.remove('hidden');
            budgetSelect?.focus();
            return;
        }

        quoteSubmitBtn.disabled = true;

        try {
            const response = await fetch(quoteForm.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': quoteForm.querySelector('input[name="_token"]')?.value || '',
                },
                body: new FormData(quoteForm),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                const message = data.message
                    || Object.values(data.errors || {}).flat()[0]
                    || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง';
                quoteErrorText.textContent = message;
                quoteError.classList.remove('hidden');
                return;
            }

            document.getElementById('quoteRef').textContent = data.reference || '';
            quoteOK.classList.remove('hidden');
            quoteForm.reset();
            setVoucherDefault();
            budgetSelect.selectedIndex = 0;

            setTimeout(() => quoteOK.classList.add('hidden'), 8000);
        } catch {
            quoteErrorText.textContent = 'ไม่สามารถส่งข้อมูลได้ กรุณาตรวจสอบการเชื่อมต่อและลองใหม่';
            quoteError.classList.remove('hidden');
        } finally {
            quoteSubmitBtn.disabled = false;
        }
    });
}
