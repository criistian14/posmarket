const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {

    // |---------- COMPRAS ----------|


    // Saber si dio click al boton de eliminar Usuario
    const tablaComprasElement = document.getElementById('tablaCompras');

    if (tablaComprasElement) {

        tablaComprasElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if(boton.innerText == 'delete') {

                    eliminarCompra(boton);

                }
            }


        });
    }

    // Eliminar Compra
    function eliminarCompra(boton)
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

        let respuesta = window.confirm(`Estas seguro que deseas eliminar la compra del proveedor ${nombre}`);

        if (respuesta) {
            location.href = `${url}/ComprasControlador.php?action=eliminar&id=${id}`;
        }

    }





    // Mensaje de error por parte de html5 en el select
    const selectListasElement = [...document.querySelectorAll('#crearCompra select[required]')];
    if (selectListasElement) {

        selectListasElement.map( (select) => {
            select.setAttribute('style', 'display: inline; height: 0; padding: 0; width: 0;');
        });
    }

});
