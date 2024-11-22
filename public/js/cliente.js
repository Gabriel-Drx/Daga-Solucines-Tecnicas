document.addEventListener('DOMContentLoaded', function() {
    // Validación para el formulario de creación
    const tipoDocumentoCrear = document.getElementById('tipoDocumento');
    const documentoInputCrear = document.getElementById('documento');

    tipoDocumentoCrear.addEventListener('change', function() {
        if (this.value === 'dni') {
            documentoInputCrear.setAttribute('maxlength', '8');
            documentoInputCrear.setAttribute('minlength', '8');
        } else if (this.value === 'ruc') {
            documentoInputCrear.setAttribute('maxlength', '11');
            documentoInputCrear.setAttribute('minlength', '11');
        }
    });

    // Validar el contenido del campo para asegurarse de que solo contenga números
    documentoInputCrear.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, ''); // Eliminar cualquier carácter que no sea número
    });

    // Validar antes de enviar el formulario de creación
    document.getElementById('registroForm').addEventListener('submit', function(event) {
        const tipoDocumento = tipoDocumentoCrear.value;
        const documento = documentoInputCrear.value.trim();

        if (tipoDocumento === 'dni' && documento.length !== 8) {
            event.preventDefault();
            alert('El DNI debe tener exactamente 8 dígitos.');
        } else if (tipoDocumento === 'ruc' && documento.length !== 11) {
            event.preventDefault();
            alert('El RUC debe tener exactamente 11 dígitos.');
        }
    });

    // Validación para todos los formularios de edición
    document.querySelectorAll('[id^=modalEditar]').forEach(function(modal) {
        const tipoDocumentoEditar = modal.querySelector('#tipoDocumentoEditar');
        const documentoInputEditar = modal.querySelector('#documentoEditar');

        tipoDocumentoEditar.addEventListener('change', function() {
            if (this.value === 'dni') {
                documentoInputEditar.setAttribute('maxlength', '8');
                documentoInputEditar.setAttribute('minlength', '8');
            } else if (this.value === 'ruc') {
                documentoInputEditar.setAttribute('maxlength', '11');
                documentoInputEditar.setAttribute('minlength', '11');
            }
        });

        documentoInputEditar.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Asegurarse de que solo ingrese números
        });

        // Validar antes de enviar el formulario de edición
        modal.querySelector('form').addEventListener('submit', function(event) {
            const tipoDocumento = tipoDocumentoEditar.value;
            const documento = documentoInputEditar.value.trim();

            if (tipoDocumento === 'dni' && documento.length !== 8) {
                event.preventDefault();
                alert('El DNI debe tener exactamente 8 dígitos.');
            } else if (tipoDocumento === 'ruc' && documento.length !== 11) {
                event.preventDefault();
                alert('El RUC debe tener exactamente 11 dígitos.');
            }
        });
    });
});



// -----------------------------------------------------------------------

document.getElementById('registroForm').addEventListener('submit', function(event) {
    const nombre = document.getElementById('exampleInputEmail1').value.trim();
    const direccion = document.getElementsByName('txtDireccion')[0].value.trim();
    const entidad = document.getElementsByName('txtentidad')[0].value.trim();
    const tipoDocumento = document.getElementById('tipoDocumento').value;
    const documento = document.getElementById('documento').value.trim();

    if (!nombre || !direccion || !entidad || !tipoDocumento || !documento) {
        event.preventDefault(); // Evita que el formulario se envíe
        alert("Por favor, complete todos los Datos requeridos.");
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('input[name="search"]');
    const tableBody = document.querySelector('tbody');

    // Función para crear las filas de la tabla
    function renderClientes(clientes) {
        tableBody.innerHTML = ''; // Limpiamos el contenido de la tabla
        if (clientes.length > 0) {
            clientes.forEach(cliente => {
                const row = `
                    <tr>
                        <td>${cliente.idCliente}</td>
                        <td>${cliente.Nombre}</td>
                        <td>${cliente.Direccion}</td>
                        <td>${cliente.entidad}</td>
                        <td>${cliente.RUC_DNI}</td>
                        <td>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditar${cliente.idCliente}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <a href="/eliminar-cliente-${cliente.idCliente}" onclick="return res()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm"><i class="fa fa-print"></i></button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            tableBody.innerHTML = '<tr><td colspan="8" class="text-center">No se encontraron clientes</td></tr>';
        }
    }

    // Evento para hacer la búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const query = this.value;

        // Hacer la solicitud AJAX
        fetch(`/cliente/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                renderClientes(data); // Renderizar los clientes en la tabla
            })
            .catch(error => console.error('Error:', error));
    });

    // Cuando la página carga, mostrar todos los clientes
    fetch('/cliente/search')
        .then(response => response.json())
        .then(data => {
            renderClientes(data); // Mostrar todos los clientes al cargar la página
        })
        .catch(error => console.error('Error:', error));
});

// --------------------------------
document.addEventListener('DOMContentLoaded', function () {
    // Seleccionamos el mensaje de alerta
    const alertSuccess = document.querySelector('.alert-success');
    const alertDanger = document.querySelector('.alert-danger');

    // Si existe el mensaje de éxito, lo ocultamos después de 5 segundos
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.display = 'none';
        }, 5000); // 5000 milisegundos = 5 segundos
    }

    // Si existe el mensaje de error, también lo ocultamos después de 5 segundos
    if (alertDanger) {
        setTimeout(() => {
            alertDanger.style.display = 'none';
        }, 5000);
    }
});

