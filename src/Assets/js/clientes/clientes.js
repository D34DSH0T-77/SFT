document.addEventListener('DOMContentLoaded', function () {
    let editarModal = document.getElementById('modalClientesEditar');
    let eliminarModal = document.getElementById('modalClientesEliminar');

    if (editarModal) {
        editarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let nombre = button.getAttribute('data-bs-nombre');
            let apellido = button.getAttribute('data-bs-apellido');
            let estado = button.getAttribute('data-bs-estado');

            // IDs matching modal.php
            let inputId = document.getElementById('id_edit');
            let inputNombre = document.getElementById('editarnombre');
            let inputApellido = document.getElementById('editarapellido');
            let inputEstado = document.getElementById('editarestado');
            let formEditar = document.getElementById('formClientesEditar');

            if (inputId) inputId.value = id;
            if (inputNombre) inputNombre.value = nombre;
            if (inputApellido) inputApellido.value = apellido;
            if (inputEstado) inputEstado.value = estado;

            if (formEditar) {
                formEditar.action = `/SFT/clientes/editar/${id}`;
            }
        });
    }

    if (eliminarModal) {
        eliminarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');

            let inputIdEliminar = document.getElementById('id_eliminar');
            let formEliminar = document.getElementById('formClientesEliminar');

            if (inputIdEliminar) inputIdEliminar.value = id;
            if (formEliminar) formEliminar.action = `/SFT/clientes/eliminar/${id}`;
        });
    }

    // Loader Logic
    const forms = [
        { id: 'formClientes', title: 'Guardando cliente...', text: 'Por favor espere mientras se guarda el cliente' },
        { id: 'formClientesEditar', title: 'Actualizando cliente...', text: 'Por favor espere mientras se actualiza el cliente' },
        { id: 'formClientesEliminar', title: 'Eliminando cliente...', text: 'Por favor espere mientras se elimina el cliente' }
    ];

    forms.forEach((item) => {
        const form = document.getElementById(item.id);
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: item.title,
                    text: item.text,
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    background: '#252525',
                    color: '#fff',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                this.submit();
            });
        }
    });
});
