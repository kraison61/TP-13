(function () {
    const root = document.getElementById('soil-calc');
    if (!root) return;

    const raiInput = document.getElementById('soil-rai');
    const nganInput = document.getElementById('soil-ngan');
    const waInput = document.getElementById('soil-wa');
    const heightInput = document.getElementById('soil-height');
    const bufferInputs = [...root.querySelectorAll('input[name="soil-buffer"]')];
    const bufferLabels = [...root.querySelectorAll('[data-soil-buffer]')];

    const fmt = (n) => n.toLocaleString('th-TH', { maximumFractionDigits: 2, minimumFractionDigits: 2 });
    const fmtInt = (n) => Math.ceil(n).toLocaleString('th-TH');
    const fmtMoney = (n) => Math.round(n).toLocaleString('th-TH');

    const presets = {
        1: { rai: '0', ngan: '1', wa: '0', height: '1', buffer: '0.2' },
        2: { rai: '1', ngan: '0', wa: '0', height: '1', buffer: '0.2' },
        3: { rai: '2', ngan: '0', wa: '0', height: '1.5', buffer: '0.3' },
    };

    const setBufferUI = (buffer) => {
        bufferLabels.forEach((label) => {
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
        const checked = bufferInputs.find((input) => input.checked);
        return checked?.value ?? '0.2';
    };

    const setBuffer = (buffer) => {
        bufferInputs.forEach((input) => {
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

    [raiInput, nganInput, waInput, heightInput].forEach((input) => {
        input.addEventListener('input', render);
    });

    bufferInputs.forEach((input) => {
        input.addEventListener('change', () => {
            setBufferUI(getBuffer());
            render();
        });
    });

    bufferLabels.forEach((label) => {
        label.addEventListener('click', () => {
            setBuffer(label.dataset.soilBuffer);
            render();
        });
    });

    root.querySelectorAll('[data-soil-preset]').forEach((btn) => {
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
