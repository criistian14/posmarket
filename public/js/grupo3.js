const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {

    // |---------- Materialize ----------|

    // Inicializar selects de materialize
    const selectsMaterializeElements = document.querySelectorAll('select');
    if (selectsMaterializeElements) {
        let intancesSelectsElement = M.FormSelect.init(selectsMaterializeElements);
    }


    // Inicializar Tabs de materialize
    const tabsMaterializeElements = document.querySelectorAll('.tabs');
    if (tabsMaterializeElements) {
        let intancesSelectsElement = M.Tabs.init(tabsMaterializeElements, { swipeable: false });
    }


    // Inicializar textarea de Materialize
    const textareaDescripcionReporteElement = [...document.querySelectorAll('#textareaDescripcionReporte')];
    if (textareaDescripcionReporteElement) {
        textareaDescripcionReporteElement.map( (textarea) => {
            M.textareaAutoResize(textarea);
        });
    }


    // Inicializar Date Pickers de materialize
    const datepickerMaterializeElements = document.querySelectorAll('.datepicker');
    if (datepickerMaterializeElements) {
        let intancesSelectsElement = M.Datepicker.init(datepickerMaterializeElements, { format: 'yyyy-mm-dd' });
    }




    // |---------- USUARIOS ----------|


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



    // Mostrar formulario para cambiar contraseña
    const cambiarContrasenaElement = document.getElementById('cambiarContrasena');
    if (cambiarContrasenaElement) {

        cambiarContrasenaElement.addEventListener('change', () => {

            let contrasenaElement = document.getElementById('mostrarCambiarContrasena');

            if (cambiarContrasenaElement.checked) {
                contrasenaElement.classList.remove('bounceOutLeft', 'ocultar');
                contrasenaElement.classList.add('bounceInLeft');

                [...contrasenaElement.children].map( (element) => {
                    element.firstElementChild.required = true;
                });

            } else {
                contrasenaElement.classList.remove('bounceInLeft');
                contrasenaElement.classList.add('bounceOutLeft');

                [...contrasenaElement.children].map( (element) => {
                    element.firstElementChild.required = false;
                });

                setTimeout(() => {
                    contrasenaElement.classList.add('ocultar');
                }, 750);
            }

        });
    }









    // |---------- REPORTES ----------|


    // Saber si dio click al boton de eliminar Reporte
    const tablaReportesElement = document.getElementById('tablaReportes');

    if (tablaReportesElement) {

        tablaReportesElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if(boton.innerText == 'delete') {

                    eliminarReporte(boton);

                }
            }


        });
    }

    // Eliminar Usuario
    function eliminarReporte(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            }
        });

        let respuesta = window.confirm('Estas seguro que deseas eliminar el reporte');

        if (respuesta) {
            location.href = `${url}/ReportesControlador.php?action=eliminar&id=${id}`;
        }

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



    // Mostrar formulario para ingresar un producto en el reporte
    const mostrarListaProductosElement = document.getElementById('mostrarListaProductos');
    if (mostrarListaProductosElement) {

        mostrarListaProductosElement.addEventListener('change', () => {

            let listaProductosElement = document.getElementById('listaProductos');

            if (mostrarListaProductosElement.checked) {
                listaProductosElement.classList.remove('bounceOutRight', 'ocultar');
                listaProductosElement.classList.add('bounceInLeft');

                [...listaProductosElement.children].map( (element) => {
                    element.lastElementChild.children[3].required = true;
                });

            } else {
                listaProductosElement.classList.remove('bounceInLeft');
                listaProductosElement.classList.add('bounceOutRight');


                [...listaProductosElement.children].map( (element) => {
                    element.lastElementChild.children[3].required = false;
                });

                setTimeout(() => {
                    listaProductosElement.classList.add('ocultar');
                }, 750);
            }

        });
    }


    // Mensaje de error por parte de html5 en el select
    const selectTipoReporteElement = document.querySelector('#crearReporte select[required]');
    if (selectTipoReporteElement) {
        selectTipoReporteElement.setAttribute('style', 'display: inline; height: 0; padding: 0; width: 0;');
    }



});
