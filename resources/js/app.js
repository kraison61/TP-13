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
    const open = mobileMenu?.classList.contains('hidden');
    open ? openMobileMenu() : closeMobileMenu();
    menuBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
});

mobileMenuBackdrop?.addEventListener('click', () => {
    closeMobileMenu();
    menuBtn?.setAttribute('aria-expanded', 'false');
});

mobileMenu?.addEventListener('click', e => {
    if (e.target.closest('a')) {
        closeMobileMenu();
        menuBtn?.setAttribute('aria-expanded', 'false');
    }
});

// Gallery page — category filter
const galleryFilters = document.getElementById('gallery-filters');
const galleryGrid = document.getElementById('gallery-grid');
const galleryEmpty = document.getElementById('gallery-empty');
const galleryCount = document.getElementById('gallery-count');

let activeGalleryFilter = 'all';

const setGalleryFilterButtonState = (activeBtn) => {
    galleryFilters?.querySelectorAll('[data-filter]').forEach(btn => {
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

    galleryGrid?.querySelectorAll('[data-gallery-card]').forEach(card => {
        const matches = activeGalleryFilter === 'all' || card.dataset.cat === activeGalleryFilter;
        card.classList.toggle('hidden', !matches);
        if (matches) visible++;
    });

    galleryCount && (galleryCount.textContent = String(visible));
    galleryEmpty?.classList.toggle('hidden', visible > 0);
    galleryGrid?.classList.toggle('hidden', visible === 0);
};

galleryFilters?.addEventListener('click', e => {
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

    photos.forEach(el => el.addEventListener('click', () => {
        show(Number(el.dataset.index));
        lb.showModal();
    }));

    thumbs.forEach(el => el.addEventListener('click', () => show(Number(el.dataset.index))));
    prevBtn?.addEventListener('click', () => show(idx - 1));
    nextBtn?.addEventListener('click', () => show(idx + 1));

    lb.addEventListener('click', e => {
        if (e.target === lb) lb.close();
    });

    document.addEventListener('keydown', e => {
        if (!lb.open) return;
        if (e.key === 'ArrowLeft') show(idx - 1);
        if (e.key === 'ArrowRight') show(idx + 1);
    });
})();

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

// Testimonials carousel — mobile 1 / tablet 2 / desktop 3
(function () {
    const viewport = document.getElementById('testiViewport');
    const track = document.getElementById('testiTrack');
    const nav = document.getElementById('testiNav');
    const prevBtn = document.getElementById('testiPrev');
    const nextBtn = document.getElementById('testiNext');

    if (!viewport || !track) return;

    const slides = [...track.querySelectorAll('.testi-slide')];
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

// FAQ accordion — one item open at a time
document.getElementById('faqItems')?.addEventListener('toggle', e => {
    if (e.target.tagName !== 'DETAILS' || !e.target.open) return;
    e.currentTarget.querySelectorAll('details[open]').forEach(d => {
        if (d !== e.target) d.open = false;
    });
});

document.getElementById('faqListCalc')?.addEventListener('toggle', e => {
    if (e.target.tagName !== 'DETAILS' || !e.target.open) return;
    e.currentTarget.querySelectorAll('details[open]').forEach(d => {
        if (d !== e.target) d.open = false;
    });
});

// Soil fill calculator
(function () {
    const root = document.getElementById('soil-calc');
    if (!root) return;

    const raiInput = document.getElementById('soil-rai');
    const nganInput = document.getElementById('soil-ngan');
    const waInput = document.getElementById('soil-wa');
    const heightInput = document.getElementById('soil-height');
    const bufferInputs = [...root.querySelectorAll('input[name="soil-buffer"]')];
    const bufferLabels = [...root.querySelectorAll('[data-soil-buffer]')];

    const fmt = n => n.toLocaleString('th-TH', { maximumFractionDigits: 2, minimumFractionDigits: 2 });
    const fmtInt = n => Math.ceil(n).toLocaleString('th-TH');
    const fmtMoney = n => Math.round(n).toLocaleString('th-TH');

    const presets = {
        1: { rai: '0', ngan: '1', wa: '0', height: '1', buffer: '0.2' },
        2: { rai: '1', ngan: '0', wa: '0', height: '1', buffer: '0.2' },
        3: { rai: '2', ngan: '0', wa: '0', height: '1.5', buffer: '0.3' },
    };

    const setBufferUI = (buffer) => {
        bufferLabels.forEach(label => {
            const active = label.dataset.soilBuffer === buffer;
            label.classList.toggle('border-accent', active);
            label.classList.toggle('bg-accent/5', active);
            label.classList.toggle('text-accent', active);
            label.classList.toggle('border-line', !active);
            label.classList.toggle('bg-white', !active);
            label.classList.toggle('text-muted', !active);
        });
    };

    const getBuffer = () => {
        const checked = bufferInputs.find(input => input.checked);
        return checked?.value ?? '0.2';
    };

    const setBuffer = (buffer) => {
        bufferInputs.forEach(input => {
            input.checked = input.value === buffer;
        });
        setBufferUI(buffer);
    };

    const render = () => {
        const rai = parseFloat(raiInput.value) || 0;
        const ngan = parseFloat(nganInput.value) || 0;
        const wa = parseFloat(waInput.value) || 0;
        const height = parseFloat(heightInput.value) || 0;
        const bufVal = parseFloat(getBuffer()) || 0;

        const area = rai * 1600 + ngan * 400 + wa * 4;
        const rawVol = area * height;
        const volume = rawVol * (1 + bufVal);

        const trucks6 = volume > 0 ? Math.ceil(volume / 6) : 0;
        const trucks10 = volume > 0 ? Math.ceil(volume / 12) : 0;

        const soilLow = volume * 150;
        const soilHigh = volume * 220;
        const laborLow = Math.max(15000, volume * 35);
        const laborHigh = Math.max(30000, volume * 65);
        const costLow = soilLow + laborLow;
        const costHigh = soilHigh + laborHigh;
        const tpCost = volume * 220 + Math.max(20000, volume * 45);

        const bufferLabelNote = bufVal === 0
            ? '(ไม่เผื่อดินยุบตัว)'
            : `(รวมเผื่อดินยุบตัว ${bufVal * 100}%)`;

        document.getElementById('soil-area-fmt').textContent = fmt(area);
        document.getElementById('soil-area-fmt-card').textContent = fmt(area);
        document.getElementById('soil-volume-fmt').textContent = fmt(volume);
        document.getElementById('soil-raw-vol-fmt').textContent = fmt(rawVol);
        document.getElementById('soil-buffer-note').textContent = `(ลูกบาศก์เมตร) ${bufferLabelNote}`;
        document.getElementById('soil-trucks6-fmt').textContent = fmtInt(trucks6);
        document.getElementById('soil-trucks10-fmt').textContent = fmtInt(trucks10);
        document.getElementById('soil-soil-low').textContent = fmtMoney(soilLow);
        document.getElementById('soil-soil-high').textContent = fmtMoney(soilHigh);
        document.getElementById('soil-labor-low').textContent = fmtMoney(laborLow);
        document.getElementById('soil-labor-high').textContent = fmtMoney(laborHigh);
        document.getElementById('soil-cost-low').textContent = fmtMoney(costLow);
        document.getElementById('soil-cost-high').textContent = fmtMoney(costHigh);
        document.getElementById('soil-tp-cost').textContent = fmtMoney(tpCost);

        const resultCard = document.getElementById('soil-result-volume');
        resultCard?.classList.remove('result-fade');
        void resultCard?.offsetWidth;
        resultCard?.classList.add('result-fade');
    };

    const applyPreset = (preset) => {
        raiInput.value = preset.rai;
        nganInput.value = preset.ngan;
        waInput.value = preset.wa;
        heightInput.value = preset.height;
        setBuffer(preset.buffer);
        render();
    };

    [raiInput, nganInput, waInput, heightInput].forEach(input => {
        input.addEventListener('input', render);
    });

    bufferInputs.forEach(input => {
        input.addEventListener('change', () => {
            setBufferUI(getBuffer());
            render();
        });
    });

    bufferLabels.forEach(label => {
        label.addEventListener('click', () => {
            setBuffer(label.dataset.soilBuffer);
            render();
        });
    });

    root.querySelectorAll('[data-soil-preset]').forEach(btn => {
        btn.addEventListener('click', () => applyPreset(presets[btn.dataset.soilPreset]));
    });

    root.querySelector('[data-soil-reset]')?.addEventListener('click', () => {
        raiInput.value = '';
        nganInput.value = '';
        waInput.value = '';
        heightInput.value = '';
        setBuffer('0.2');
        render();
    });

    render();
})();

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
