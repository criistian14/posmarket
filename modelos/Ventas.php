<?php
   
#########################################################
#   __      _   _     _____   ______   __    _______    #
#  /__\    ( ) ( )   / ___ \ / ___  \ /  \  (  __   )   #                  
# ( \/ )  _| |_| |_ ( (___) )\/   )  )\/) ) | (  )  |   #                 
#  \  /  (_   _   _) \     /     /  /   | | | | /   | _ #           This controller 
#  /  \/\ _| (_) |_  / ___ \    /  /    | | | (/ /) |(_)#             is made by 
# / /\  /(_   _   _)( (   ) )  /  /     | | |   / | |   #              &#8710;
#(  \/  \  | | | |  ( (___) ) /  /    __) (_|  (__) | _ #
# \___/\/  (_) (_)   \_____/  \_/     \____/(_______)( )#
#                                                    |/ #
#########################################################

require_once '../configuracion/conexion.php';


# Clase principal de ventas
class Ventas extends Conexion{

    # Variables globales de mi clase
    public $sql;
    public $id;
    public $usuario_id;
    public $producto_id;
    public $valor_total;
    public $fecha;


    # Funcion Crear venta
    function Crear($usuario_id, $producto_id, $valor_total, $fecha){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->usuario_id = $usuario_id;
        $this->producto_id = $producto_id;
        $this->valor_total = $valor_total;
        $this->fecha = $fecha;

        # Sql con los datos recibidos
        $this->sql = "INSERT INTO ventas VALUES(''
        ,'".$this->usuario_id."'
        ,'".$this->producto_id."'
        ,'".$this->valor_total."'
        ,'".$this->fecha."'
        )";

        # Insertar los datos y validar si insertó
        if($this->conn->query($this->sql)){

            return 1;

        }else{

            return 0;
        }

    }


    # Funcion Leer venta
    function Leer($id){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->id = $id;

        # Sql con los datos recibidos
        $this->sql = "SELECT * FROM ventas WHERE codigo LIKE '%".$this->id."%'";

        # Tomar el resultado del sql
        $resultado = $this->conn->query($this->sql);

        # Crear arreglo para llenar los datos de el ciclo
        $array = [];

        # Validar si encontro el producto
        if($resultado->num_rows > 0){

            # Mostrar el resultado usando el ciclo while
            while($fila = $resultado->fetch_assoc()){

                $array = $fila;

            }

            # Imprimo como arreglo para poder recibirlo en el index
            print_r($array);

        }else{

            # Retorno 0 si no encuentra algun dato
            return 0;
        }


    }


}

?>