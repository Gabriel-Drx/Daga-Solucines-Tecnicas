// Inicializar la fecha actual en el campo de fecha
document.addEventListener('DOMContentLoaded', function () {
    const fechaInput = document.getElementById('fechaInfo');
    const date = new Date().toLocaleDateString('en-CA', {
        timeZone: 'America/Lima',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
    fechaInput.value = date;
});

document.addEventListener('DOMContentLoaded', function () {
    const quills = {};

    function initializeQuillEditor(idInforme, content) {
        if (!quills[idInforme]) {
            quills[idInforme] = new Quill(`#editorEdit-${idInforme}`, {
                theme: 'snow',
                placeholder: 'Escribe la descripción del informe...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']  // remove formatting
                    ]
                }
            });
        }
        // Asigna el contenido de la descripción al editor Quill
        quills[idInforme].root.innerHTML = content || '';
    }

    // Escuchar el evento de apertura del modal y cargar el contenido en el editor
    document.querySelectorAll('.btn[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function () {
            const idInforme = this.getAttribute('data-id');
            const content = document.querySelector(`#editorEdit-${idInforme}`).dataset.content;
            initializeQuillEditor(idInforme, content);
        });
    });

    // Función para asignar el contenido del editor Quill al campo oculto del formulario
    window.submitEditForm = function (id) {
        document.getElementById('descripcionEdit-' + id).value = quills[id].root.innerHTML;
        return true;
    };

    // Inicializar el editor Quill para el modal de creación de nuevo informe
    const quillCreate = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Escribe la descripción del informe...',
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']  // remove formatting
            ]
        }
    });
    quillCreate.root.innerHTML = "<p>Estimados señores:</p><p></p><p>Es grato dirigirnos .....</p>";

    // Al enviar el formulario de creación, asigna el contenido de Quill al textarea oculto
    window.submitForm = function () {
        document.getElementById('descripcionInforme').value = quillCreate.root.innerHTML;
        return true;
    };
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

// -----------------------------------------------------------



