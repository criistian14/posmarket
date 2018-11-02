const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {


    // |---------- TIPOS REPORTE ----------|


    // Mostrar modal crear tipo de reporte
    const agregarTiposReporteElement = document.getElementById('agregarTiposReporte');
    if (agregarTiposReporteElement) {

        agregarTiposReporteElement.addEventListener('click', () => {

            let modalCrearTipoReporteElement = document.getElementById('modalCrearTipoReporte');

            M.Modal.init(modalCrearTipoReporteElement).open();
        });

    }



    // Saber a cual boton le dio click en tabla tipo de reporte
    const tablaTiposReporteElement = document.getElementById('tablaTiposReporte');

    if (tablaTiposReporteElement) {

        tablaTiposReporteElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if( boton.innerText == 'delete' ) {

                    eliminarTipoReporte(boton);

                } else if( boton.innerText == 'create' ) {

                    mostrarModalEditarTipoReporte(boton);

                }
            }


        });
    }

    // Eliminar el tipo de reporte
    function eliminarTipoReporte(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            }
        });

        let respuesta = window.confirm('Estas seguro que deseas eliminar el tipo de reporte');

        if (respuesta) {
            location.href = `${url}/TiposReporteControlador.php?action=eliminar&id=${id}`;
        }

    }


    // Mostrar modal de editar el tipo de reporte
    function mostrarModalEditarTipoReporte(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id,
            tipoReporte;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            } else {
                if (!!columna.dataset.nombreTipoReporte){
                    tipoReporte = columna.dataset.nombreTipoReporte;
                }
            }
        });

        let modalActualizarTipoReporteElement = document.getElementById('modalActualizarTipoReporte');

        let txtTipoReporteElement = document.getElementById('txtTipoReporte');
        let idActualizarTipoReporteElement = document.getElementById('idActualizarTipoReporte');


        idActualizarTipoReporteElement.value = id;
        txtTipoReporteElement.value = tipoReporte;


        M.Modal.init(modalActualizarTipoReporte).open();

    }


    // Editar tipo de reporte
    const btnActualizarTipoReporteElement = document.getElementById('btnActualizarTipoReporte');
    if (btnActualizarTipoReporteElement) {
        btnActualizarTipoReporteElement.addEventListener('click', async (e) => {

            e.preventDefault();

            let txtTipoReporte = document.getElementById('txtTipoReporte').value;
            let id = document.getElementById('idActualizarTipoReporte').value;

            let response = await fetch(`${url}/TiposReporteControlador.php?action=actualizar&id=${id}`, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({tipoReporte: txtTipoReporte}),
                            });

            let dataJson = await response.json();

            dataJson.then( (response) => {
                console.log(response);
            });

        });
    }





});
