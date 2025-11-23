document.addEventListener('DOMContentLoaded', function () {
    let editarModal = document.getElementById('modalClientesEditar')
    let eliminarModal = document.getElementById('modalClientesEliminar')

    if (editarModal) {
        editarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let nombre = button.getAttribute('data-bs-nombre')
            let apellido = button.getAttribute('data-bs-apellido')
            let estado = button.getAttribute('data-bs-estado')

            // IDs matching modal.php
            let inputId = document.getElementById('id_edit')
            let inputNombre = document.getElementById('editarnombre')
            let inputApellido = document.getElementById('editarapellido')
            let inputEstado = document.getElementById('editarestado')
            let formEditar = document.getElementById('formClientesEditar')

            if (inputId) inputId.value = id
            if (inputNombre) inputNombre.value = nombre
            if (inputApellido) inputApellido.value = apellido
            if (inputEstado) inputEstado.value = estado

            if (formEditar) {
                formEditar.action = `/SFT/clientes/editar/${id}`
            }
        })
    }

    if (eliminarModal) {
        eliminarModal.addEventListener('shown.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            let inputIdEliminar = document.getElementById('id_eliminar')
            let formEliminar = document.getElementById('formClientesEliminar')

            if (inputIdEliminar) inputIdEliminar.value = id
            if (formEliminar) formEliminar.action = `/SFT/clientes/eliminar/${id}`
        })
    }
})