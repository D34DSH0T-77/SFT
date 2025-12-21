document.addEventListener('DOMContentLoaded', function () {
    const ingresosUsdEl = document.getElementById('ingresosUsd');
    const ingresosBsEl = document.getElementById('ingresosBs');
    const egresosUsdEl = document.getElementById('egresosUsd');
    const egresosBsEl = document.getElementById('egresosBs');
    const capitalNetoUsdEl = document.getElementById('capitalNetoUsd');
    const capitalNetoBsEl = document.getElementById('capitalNetoBs');

    fetchTasaBCV();

    async function fetchTasaBCV() {
        try {
            const response = await fetch('https://ve.dolarapi.com/v1/dolares/oficial');
            const data = await response.json();

            if (data && data.promedio) {
                const tasa = parseFloat(data.promedio);
                updateAmounts(tasa);
            }
        } catch (error) {
            console.warn('No se pudo obtener la tasa automática.', error);
        }
    }

    function updateAmounts(tasa) {
        if (ingresosUsdEl && ingresosBsEl) {
            const usd = parseFloat(ingresosUsdEl.dataset.amount) || 0;
            const bs = usd * tasa;
            ingresosBsEl.innerText = formatCurrency(bs);
        }

        if (egresosUsdEl && egresosBsEl) {
            const usd = parseFloat(egresosUsdEl.dataset.amount) || 0;
            const bs = usd * tasa;
            egresosBsEl.innerText = formatCurrency(bs);
        }

        if (capitalNetoUsdEl && capitalNetoBsEl) {
            const usd = parseFloat(capitalNetoUsdEl.dataset.amount) || 0;
            const bs = usd * tasa;
            capitalNetoBsEl.innerText = formatCurrency(bs);
        }
    }

    function formatCurrency(amount) {
        return 'Bs ' + amount.toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
});
