document.addEventListener('DOMContentLoaded', function () {
    const tasaDia = document.getElementById('tasaDia');
    if (tasaDia) {
        fetch('https://ve.dolarapi.com/v1/dolares/oficial')
            .then((response) => response.json())
            .then((data) => {
                if (data && data.promedio) {
                    tasaDia.textContent = `Bs. ${data.promedio}`;
                } else {
                    tasaDia.textContent = 'Bs. 0.00';
                }
            })
            .catch((error) => {
                console.error('Error al obtener la tasa:', error);
                tasaDia.textContent = 'Error';
            });
    }
});
