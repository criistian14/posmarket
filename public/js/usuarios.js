const url = '/posmarket/controladores';

document.addEventListener('DOMContentLoaded', () => {

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






});
