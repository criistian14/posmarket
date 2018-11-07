const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {


    // |---------- MEDIO DE PAGO ----------|


    // Mostrar modal crear tipo de reporte
    const agregarMedioPagoElement = document.getElementById('agregarMedioPago');
    if (agregarMedioPagoElement) {

        agregarMedioPagoElement.addEventListener('click', () => {

            let modalCrearMedioPagoElement = document.getElementById('modalCrearMedioPago');

            M.Modal.init(modalCrearMedioPagoElement).open();
        });

    }



    // Saber a cual boton le dio click en tabla tipo de reporte
    const tablaMediosPagoElement = document.getElementById('tablaMediosPago');

    if (tablaMediosPagoElement) {

        tablaMediosPagoElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if( boton.innerText == 'delete' ) {

                    eliminarMedioPago(boton);

                } else if( boton.innerText == 'create' ) {

                    mostrarModalEditarMedioPago(boton);

                }
            }


        });
    }

    // Eliminar el medio de pago
    function eliminarMedioPago(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            }
        });

        let respuesta = window.confirm('Estas seguro que deseas eliminar el medio de pago');

        if (respuesta) {
            location.href = `${url}/MediosPagoControlador.php?action=eliminar&id=${id}`;
        }

    }


    // Mostrar modal de editar el medio de pago
    function mostrarModalEditarMedioPago(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id,
            medioPago;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            } else {
                if (!!columna.dataset.nombreMedioPago){
                    medioPago = columna.dataset.nombreMedioPago;
                }
            }
        });

        let modalActualizarMedioPagoElement = document.getElementById('modalActualizarMedioPago');

        let txtMedioPagoElement = document.getElementById('txtMedioPago');
        let idActualizarMedioPagoElement = document.getElementById('idActualizarMedioPago');


        idActualizarMedioPagoElement.value = id;
        txtMedioPagoElement.value = medioPago;


        M.Modal.init(modalActualizarMedioPago).open();

    }






});
