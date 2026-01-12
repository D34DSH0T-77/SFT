document.addEventListener('DOMContentLoaded', function () {
    let editarModal = document.getElementById('modalEditar');
    let eliminarModal = document.getElementById('modalEliminar');

    if (editarModal) {
        editarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let nombre = button.getAttribute('data-bs-nombre');
            let apellido = button.getAttribute('data-bs-apellido');
            let estado = button.getAttribute('data-bs-estado');
            let usuario = button.getAttribute('data-bs-usuario');
            let rol = button.getAttribute('data-bs-rol');
            let cedula = button.getAttribute('data-bs-cedula');

            // IDs matching modal.php
            let inputId = document.getElementById('idEditar');
            let inputNombre = document.getElementById('nombreEditar');
            let inputApellido = document.getElementById('apellidoEditar');
            let inputEstado = document.getElementById('editarestado');
            let inputUsuario = document.getElementById('usuarioEditar');
            let inputRol = document.getElementById('rolEditar');
            let inputCedula = document.getElementById('cedulaEditar');
            let formEditar = document.getElementById('formUsuariosEditar');

            if (inputId) inputId.value = id;
            if (inputNombre) inputNombre.value = nombre;
            if (inputApellido) inputApellido.value = apellido;
            if (inputEstado) inputEstado.value = estado;
            if (inputUsuario) inputUsuario.value = usuario;
            if (inputRol) inputRol.value = rol;
            if (inputCedula) inputCedula.value = cedula;

            if (formEditar) {
                formEditar.action = `/SFT/usuarios/editar/${id}`;
            }
        });
    }

    if (eliminarModal) {
        eliminarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');

            let inputIdEliminar = document.getElementById('idEliminar');
            let formEliminar = document.getElementById('formUsuariosEliminar');

            if (inputIdEliminar) inputIdEliminar.value = id;
            if (formEliminar) formEliminar.action = `/SFT/usuarios/eliminar/${id}`;
        });
    }

    // Loader Logic
    const forms = [
        { id: 'formUsuarios', title: 'Guardando usuario...', text: 'Por favor espere mientras se guarda el usuario' },
        { id: 'formUsuariosEditar', title: 'Actualizando usuario...', text: 'Por favor espere mientras se actualiza el usuario' },
        { id: 'formUsuariosEliminar', title: 'Eliminando usuario...', text: 'Por favor espere mientras se elimina el usuario' }
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
