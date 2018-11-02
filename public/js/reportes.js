const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {

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

    // Eliminar reporte
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
