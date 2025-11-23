document.addEventListener('DOMContentLoaded', function () {

    const formClientes = document.getElementById('formClientes');
    const formClientesEditar = document.getElementById('formClientesEditar');
    const formClientesEliminar = document.getElementById('formClientesEliminar');

    formClientes.addEventListener('submit', function (e) {
        e.preventDefault();
        const nombre = document.getElementById('nombre').value;
        const apellido = document.getElementById('apellido').value;
        const estado = document.getElementById('estado').value;

    });
    formClientesEditar.addEventListener('submit', function (e) {
        e.preventDefault();
        const nombre = document.getElementById('editarnombre').value;
        const apellido = document.getElementById('editarapellido').value;
        const estado = document.getElementById('editarestado').value;

    });
    formClientesEliminar.addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('eliminarid').value;

    });

});
