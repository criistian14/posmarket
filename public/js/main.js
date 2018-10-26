// Funcionando

// Probando la funcion
function productos(){
    // Pille el ajax sirve para pedir desde javascript a otro archivo datos
    $.ajax({
        url: "controladores/TodosProductos.php",
        type: "POST",
        // Esto es un json
        data: {
            "op" : "1",
        },
        dataType: "json",
        success: function(data){
            $.each(data, function(index, val){
                $("#productos").append("<div class='col s12 m4'>"
                    +"<div class='card'>"
                        +"<div class='card-image'>"
                            +"<img src='https://picsum.photos/300/300/?random'>"
                            +"<span class='card-title'>"
                                + val.nombre
                            +"</span>"
                            
                        +"</div>"
                        +"<div class='card-content'>"
                            +"<p>"
                                +"$ "+val.precio
                            +"</p>"
                        +"</div>"
                        +"<div class='card-action'>"
                            +"<button class='btn-floating btn-large waves-effect waves-light red' onclick='agregar_producto()'>"
                                +"<i class='material-icons'>add</i>"
                            +"</button>"
                        +"</div>"
                    +"</div>"
                +"</div>");
            });

        }
        });


}



function agregar_producto(){
    
   let valor = parseInt($("#contador_productos").text());

   valor++;


   $("#contador_productos").text(valor);
   

   


}

