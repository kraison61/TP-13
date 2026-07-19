// Copy discount reference code + record once in database
document.getElementById('copyRefBtn')?.addEventListener('click', async (e) => {
    const btn = e.currentTarget;
    const code = btn.dataset.copy;

    try {
        await navigator.clipboard.writeText(code);
    } catch {
        return;
    }

    const iconWrap = document.getElementById('copyRefIcon');
    const label = document.getElementById('copyRefLabel');
    const defaultIcon = iconWrap?.querySelector('.copy-default');
    const doneIcon = iconWrap?.querySelector('.copy-done');
    defaultIcon?.classList.add('hidden');
    doneIcon?.classList.remove('hidden');
    label.textContent = 'คัดลอกแล้ว';
    setTimeout(() => {
        doneIcon?.classList.add('hidden');
        defaultIcon?.classList.remove('hidden');
        label.textContent = 'คัดลอก';
    }, 2000);

    if (btn.dataset.recorded === '1' || !btn.dataset.saveUrl) return;

    const quoteForm = document.getElementById('quoteForm');

    try {
        const response = await fetch(btn.dataset.saveUrl, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
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
    const tierMap = Object.fromEntries(voucherTiers.map((t) => [t.budget, t]));

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

    quoteForm.addEventListener('submit', async (e) => {
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
                    Accept: 'application/json',
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
