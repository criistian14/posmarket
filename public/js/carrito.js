'use stric'
const rutaApp = '/posmarket';

document.addEventListener('DOMContentLoaded', () => {

    const contadorCarritoElement = document.getElementById("contador_productos");
    contadorCarritoElement.innerText = (!localStorage.getItem('carrito')) ? 0 : JSON.parse(localStorage.getItem('carrito')).length;

    // Constante del boton de añadir al carrito
    const getproductoElement = document.getElementById('productos-oferta');

    if(getproductoElement){

       getproductoElement.addEventListener('click', (event) => {

        let boton;

        if(event.target.tagName == "I"){

            boton = event.target.parentElement;

        }else if(event.target.tagName == "BUTTON"){

            boton = event.target;
        }

        if(!!boton){

            if(boton.innerText == "add"){

                agregarProducto(boton);

            }

        }

       });



    }


    // Tabla de carrito de compras
    const tablaCarritoElement = document.getElementById('tablaCarrito');
     // Variable del precio total para sumarlo y restarlo
    let precio_total = 0;

    if(tablaCarritoElement){

        // Recibir el elemento de precio total
        const precioTotalElement = document.getElementById('total_precio');
        //--- Ulta necesario para almacenar los datos ---//
        let formData = new FormData();


        if (localStorage.getItem('carrito') != null) {
            JSON.parse(localStorage.getItem('carrito')).map( (producto) => {
                formData.append(producto.producto, producto.producto);
            });
        }




        fetch('/posmarket/controladores/ProductosControlador?action=respuesta', {
            method: 'POST',
            body: formData
        })
        .then(data => data.json())

        .then(responseJson => {


            Array.prototype.forEach.call(responseJson, (val, index, array) => {

                // Inner de los productos en el carrito

               if(val.oferta > 0){
                   // Sumar el total
                   precio_total += parseInt(val.oferta);

                tablaCarritoElement.innerHTML +=
                    "<tr id='"+val.id+"' data-valor='"+ val.oferta +"' >"
                        +"<td>"
                        + "<img src='"+val.imagen+"' style='width: 30vh; height: 20vh'>"
                        +"</td>"
                        +"<td>"
                        +   val.nombre
                        +"</td>"

                        +"<td>"
                           + val.oferta
                         +"</td>"
                       + "<td>"
                            +"<div class='input-field' >"
                            + "<select style='display: block' id='"+ val.codigo+"'>"
                            + "</select>"
                            +"</div>"
                       + "</td>"
                        + "<td>"
                        + "<button class='waves-effect waves-light btn-flat'><i class='material-icons' style='color: #ff5722;'>delete</i></button>"
                        +"</td>"
                    +"</tr>"
                ;
               }else{

                    precio_total += parseInt(val.precio);

                   tablaCarritoElement.innerHTML +=
                       "<tr id='"+val.id+"' data-valor='"+ val.precio +"' >"
                       + "<td>"
                       + "<img src='" + val.imagen + "' style='width: 30vh; height: 20vh'>"
                       + "</td>"
                       + "<td>"
                       + val.nombre
                       + "</td>"

                       + "<td>"
                       + val.precio
                       + "</td>"
                       + "<td>"
                          +"<div class='input-field' >"
                          + "<select style='display: block' id='"+ val.codigo+"'>"
                          + "</select>"
                          +"</div>"
                       + "</td>"
                       + "<td>"
                       + "<button class='waves-effect waves-light btn-flat'><i class='material-icons' style='color: #ff5722;'>delete</i></button>"
                       + "</td>"
                       + "</tr>"
                       ;



               }

               // Sirve para recorrer todo el select y poder agregarle las opciones de cantidad


                let cantidadElement = document.getElementById(val.codigo);

                for(let i = 1; i <= val.cantidad; i++){

                    if(cantidadElement != null) {

                        cantidadElement.innerHTML +=
                        "<option>"
                        + i
                        +"</option>";
                    }

                }

            });


            precioTotalElement.innerHTML = `${new Intl.NumberFormat({ style: 'currency' }).format(precio_total)}`;
        })
        .catch((error) => {
            console.dir(error);
        });

        // Recibir el boton eliminar
        tablaCarritoElement.addEventListener('click', (event) => {

            let boton;

           

            if(event.target.tagName == "I"){
                boton = event.target.parentElement;
            } else if (event.target.tagName == 'BUTTON'){

                boton = event.target;

            }


            if(!!boton){
                if(boton.innerText == 'delete'){

                    eliminarProductos(boton);

                }
            }



        });


        //////////////////// Suma de los productos ///////////////////


        tablaCarritoElement.addEventListener('change', (event) => {


            let data = event.target.parentElement;

            let arreglo = [...data.parentElement.parentElement.children];



            let tableProductsElement = [...document.getElementById('tablaCarrito').children];

            let valor_total = 0;

            tableProductsElement.map( (product) => {

                let price = product.dataset.valor;
                let quantity = product.children[3].firstChild.firstChild.value;

                valor_total += price * quantity;

            });


            precioTotalElement.innerHTML = `${new Intl.NumberFormat({ style: 'currency' }).format(valor_total)}`;
        });


        const filaCompraElement = document.querySelector("#filaCompra");

        filaCompraElement.addEventListener("click", (event) => {

            let formData = new FormData();
            let tableProductsElement = [...document.getElementById('tablaCarrito').children];



            if (event.target.tagName == "I" && event.target.textContent == "send") {

                for (let i = 0; i < tableProductsElement.length; i++) {

                    formData.append("id", tableProductsElement[i].id);
                    formData.append("total_producto", tableProductsElement[i].childNodes[3].firstChild.firstChild.value);



                    fetch('/posmarket/controladores/VentasControlador?action=registrar', {
                        method: 'POST',
                        body: formData
                    })
                        .then(data => data.json())

                        .then(responseJson => {

                            console.dir(responseJson);

                        })
                        .catch((error) => {
                            console.dir(error);
                        });

                }

                


            


            }

        });




    }





    function agregarProducto(boton){

        let productoElement = boton.parentElement.parentElement;
        const contadorCarritoElement = document.getElementById("contador_productos");


        let productos = JSON.parse(localStorage.getItem('carrito'));

        if (!productos) {

            productos = [{producto: productoElement.id}];

            M.toast({html: 'Producto agregado satisfactoriamente', classes: 'bg-green-dark'});


        } else {

            if ( JSON.parse(localStorage.getItem('carrito')).find((producto) => producto.producto == productoElement.id) ) {

                M.toast({html: 'Ya agregaste este producto', classes: 'bg-red'});

            } else {

                productos.push({producto: productoElement.id});

                M.toast({html: 'Producto agregado satisfactoriamente', classes: 'bg-green-dark'});
            }


        }

        localStorage.setItem('carrito', JSON.stringify(productos));


        contadorCarritoElement.innerText = productos.length;


        // let respuesta = window.confirm(`Quieres seguir comprando?`);
        //
        // if(!respuesta){
        //     location.href = `${rutaApp}/carrito`;
        // }

    }



    function eliminarProductos(boton){

            let elementosFila = boton.parentElement.parentElement;


            let respuesta = window.confirm(`Quieres eliminar este producto?`);

            if(respuesta){

                let productos = JSON.parse(localStorage.getItem('carrito'));

                productos.map( (producto) => {

                    if (producto.producto == elementosFila.id) {

                        let posicion = productos.map((productTemp) => productTemp.producto).indexOf(producto.producto);

                        productos.splice(posicion, 1);

                    }

                });

                localStorage.setItem('carrito', JSON.stringify(productos));

                location.reload();


            }


    }

    // function sumarProductos(boton){

    //     console.dir(boton);
    // }


});
