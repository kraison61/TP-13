document.getElementById('faqItems')?.addEventListener('toggle', (e) => {
    if (e.target.tagName !== 'DETAILS' || !e.target.open) return;
    e.currentTarget.querySelectorAll('details[open]').forEach((d) => {
        if (d !== e.target) d.open = false;
    });
});

document.getElementById('faqListCalc')?.addEventListener('toggle', (e) => {
    if (e.target.tagName !== 'DETAILS' || !e.target.open) return;
    e.currentTarget.querySelectorAll('details[open]').forEach((d) => {
        if (d !== e.target) d.open = false;
    });
});
