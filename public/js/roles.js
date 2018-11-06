const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {


    // |---------- Roles ----------|


    // Mostrar modal crear rol
    const agregarRolElement = document.getElementById('agregarRol');
    if (agregarRolElement) {

        agregarRolElement.addEventListener('click', () => {

            let modalCrearRolElement = document.getElementById('modalCrearRol');

            M.Modal.init(modalCrearRolElement).open();
        });

    }



    // Saber a cual boton le dio click en tabla roles
    const tablaRolesElement = document.getElementById('tablaRoles');

    if (tablaRolesElement) {

        tablaRolesElement.addEventListener('click', (event) => {

            let boton;

            if (event.target.tagName == 'I') {
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON') {
                boton = event.target;
            }

            if (!!boton) {

                if( boton.innerText == 'delete' ) {

                    eliminarRol(boton);

                } else if( boton.innerText == 'create' ) {

                    mostrarModalEditarRol(boton);

                }
            }


        });
    }

    // Eliminar el rol
    function eliminarRol(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            }
        });

        let respuesta = window.confirm('Estas seguro que deseas eliminar el rol');

        if (respuesta) {
            location.href = `${url}/RolesControlador.php?action=eliminar&id=${id}`;
        }

    }


    // Mostrar modal de editar el rol
    function mostrarModalEditarRol(boton)
    {
        let elementosFila = [...boton.parentElement.parentElement.children],
            id,
            rol;

        elementosFila.map( (columna) => {
            if(columna.tagName == 'INPUT') {
                id = columna.value;
            } else {
                if (!!columna.dataset.nombreRol){
                    rol = columna.dataset.nombreRol;
                }
            }
        });

        let modalActualizarRolElement = document.getElementById('modalActualizarRol');

        let txtRolElement = document.getElementById('txtRol');
        let idActualizarRolElement = document.getElementById('idActualizarRol');


        idActualizarRolElement.value = id;
        txtRolElement.value = rol;


        M.Modal.init(modalActualizarRolElement).open();

    }






});
