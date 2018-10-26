const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {


    // Limpiar formulario de registro de Usuario
    const LimpiarFormularioRegistroUsuarioElement = document.getElementById('limpiarFormularioRegistroUsuario');

    if (LimpiarFormularioRegistroUsuarioElement) {

        limpiarFormularioRegistroUsuario.addEventListener('click', (event) => {
            event.preventDefault();

            let formularioElement = [...LimpiarFormularioRegistroUsuarioElement.offsetParent];

            formularioElement.map( (input) => {
                input.value = '';
                input.classList.remove('valid', 'invalid');

                if(!!input.nextElementSibling) {
                    input.nextElementSibling.classList.remove('active');
                }
            });


        });

    }


    // Saber si dio click al boton de eliminar Usuario
    const tablaUsuariosElement = document.getElementById('tablaUsuarios');

    if (tablaUsuariosElement) {

        tablaUsuariosElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if(boton.innerText == 'delete') {

                    eliminarUsuario(boton);

                }
            }


        });
    }

    // Eliminar Usuario
    function eliminarUsuario(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            nombre,
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            } else {
                if (!!columna.dataset.nombreUsuario){
                    nombre = columna.dataset.nombreUsuario;
                }
            }
        });

        let respuesta = window.confirm(`Estas seguro que deseas eliminar al usuario ${nombre}`);

        if (respuesta) {
            location.href = `${url}/UsuariosControlador.php?action=eliminar&id=${id}`;
        }

    }



    // Inicializar selects de materialize
    const selectsMaterializeElements = document.querySelectorAll('select');
    if (selectsMaterializeElements) {
        let intancesSelectsElement = M.FormSelect.init(selectsMaterializeElements);
    }


    // Inicializar textarea de Materialize
    const textareaDescripcionReporteElement = [...document.querySelectorAll('#textareaDescripcionReporte')];
    if (textareaDescripcionReporteElement) {
        textareaDescripcionReporteElement.map( (textarea) => {
            M.textareaAutoResize(textarea);
        });
    }

    // Modal para crear nuevo tipo de reporte
    const crearReporteElement = document.getElementById('crearReporte');
    if (crearReporteElement) {

        let selectElement = crearReporteElement[1];

        selectElement.addEventListener('change', (event) => {

            let opcion = event.target.value;

            if (opcion == 'crearNuevoTipo') {

                let modalCrearTipoReporteElement = document.getElementById('modalCrearTipoReporte');

                M.Modal.init(modalCrearTipoReporteElement).open();

            }
        });
    }





});
