$(document).ready(() => {
    $.fn.dataTable.ext.errMode = 'none';
    let table = new DataTable('#myTable', {
        language: {
            url: '//cdn.datatables.net/plug-ins/2.3.5/i18n/es-ES.json'
        },
        columnDefs: [
            {
                targets: '.no-ordenar',
                orderable: false
            }
        ]
    });
});
