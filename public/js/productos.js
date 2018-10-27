const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {



    // Saber si dio click al boton de eliminar Usuario
    const tablaUsuariosElement = document.getElementById('tablaProductos');

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

                    eliminarProducto(boton);

                }
            }


        });
    }

    // Eliminar Usuario
    function eliminarProducto(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            nombre,
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            } else {
                if (!!columna.dataset.nombreProducto){
                    nombre = columna.dataset.nombreProducto;
                }
            }
        });

        let respuesta = window.confirm(`Estas seguro que deseas eliminar el producto ${nombre}`);

        if (respuesta) {
            location.href = `${url}/ProductosControlador.php?action=eliminar&id=${id}`;
        }

    }




});
