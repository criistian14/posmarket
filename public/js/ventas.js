const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {


    // |---------- MEDIO DE PAGO ----------|





    // Saber a cual boton le dio click en tabla tipo de reporte
    const tablaVentasElement = document.getElementById('tablaVentas');

    if (tablaVentasElement) {

        tablaVentasElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if (boton.innerText == 'delete') {

                    eliminarVenta(boton);

                }
            }


        });
    }

    // Eliminar el medio de pago
    function eliminarVenta(boton) {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id;

        elementosFila.map((columna) => {
            if (columna.tagName == 'INPUT') {
                id = columna.value;
            }
        });

        let respuesta = window.confirm('Estas seguro que deseas eliminar la venta');

        if (respuesta) {
            location.href = `${url}/VentasControlador.php?action=eliminar&id=${id}`;
        }

    }



});
