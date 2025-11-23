document.addEventListener('DOMContentLoaded', function () {
    let editarModal = document.getElementById('modalEditar')
    let eliminarModal = document.getElementById('modalEliminar')
    editarModal.addEventListener('shown.bs.modal', function (event) {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let nombre = button.getAttribute('data-bs-nombre')
        let precio = button.getAttribute('data-bs-precio')
        let estado = button.getAttribute('data-bs-estado')
        let img = button.getAttribute('data-bs-img')
        let inputId = editarModal.querySelector('.modal-body #id_edit')
        let inputNombre = editarModal.querySelector('.modal-body #editarnombre')
        let inputPrecio = editarModal.querySelector('.modal-body #editarprecio')
        let inputEstado = editarModal.querySelector('.modal-body #editarestado')
        let inputImagen = editarModal.querySelector('.modal-body #editarimagen')
        inputId.value = id
        inputNombre.value = nombre
        inputPrecio.value = precio
        inputEstado.value = estado
        inputImagen.value = img
        let formEditar = document.getElementById('formTortaseditar')
        formEditar.action = `/SFT/tortas/editar/${id}`
    })
    let inputIdEliminar = eliminarModal.querySelector('.modal-body #id_eliminar')
    eliminarModal.addEventListener('shown.bs.modal', function (event) {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        inputIdEliminar.value = id
        let formEliminar = document.getElementById('formTortaseliminar')
        formEliminar.action = `/SFT/tortas/eliminar/${id}`
    })
})                          