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


# Requiero la conexion de mi servidor
require('../configuracion/conexion.php');



# Clase principal de mi modelo
class GestionProductos extends Conexion{

    # Variables Globales para usar en diferente funcion
    public $sql;
    public $codigo;
    public $nombre;
    public $tamaño;
    public $precio;
    public $oferta;
    public $tipo_producto;
    public $activo;
    public $imagen;
    public $cantidad;


    # Funcion de crear producto
    function Crear(
    $codigo, 
    $nombre, 
    $tamaño, 
    $precio, 
    $oferta, 
    $tipo_producto, 
    $activo,
    $imagen,
    $cantidad){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->tamaño = $tamaño;
        $this->precio = $precio;
        $this->oferta = $oferta;
        $this->tipo_producto = $tipo_producto;
        $this->activo = $activo;
        $this->imagen = $imagen;
        $this->cantidad = $cantidad;

        # Sql con los datos recibidos 
        $this->sql = "INSERT INTO productos(id, codigo, nombre, tamano, precio, oferta, tipo_producto, activo, imagen, cantidad) VALUES(''
        , '". $this->codigo ."'
        , '".$this->nombre."'
        , '".$this->tamaño."'
        , ". $this->precio."
        , ". $this->oferta . "
        , '".$this->tipo_producto."'
        , ". $this->activo."
        , '". $this->imagen ."'
        , ". $this->cantidad .")"; 

        
        # Insertar los datos y validar si insertó
        if($this->conn->query($this->sql)){

            return 1;

        }else{

            return 0;
        }

    

    }

    # Funcion de actualizar producto
    function Actualizar(
    $codigo, 
    $nombre, 
    $tamaño, 
    $precio, 
    $oferta, 
    $tipo_producto, 
    $activo){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->tamaño = $tamaño;
        $this->precio = $precio;
        $this->oferta = $oferta;
        $this->tipo_producto = $tipo_producto;
        $this->activo = $activo;
        

        # Sql con los datos recibidos
        $this->sql = "UPDATE productos SET(''
        , '".$this->codigo."'
        , '".$this->nombre."'
        , '".$this->tamaño."'
        , ". $this->precio."
        , ". $this->oferta . "
        , '".$this->tipo_producto."'
        , ". $this->activo.")";

        # Verificar si actualizo los datos del producto
        if($this->conn->query($this->sql)){
            return 1;
        }else{

            return 0;
        }


    }

    # Funcion de eliminar producto
    function Eliminar($codigo){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->codigo = $codigo;

        # Sql con los datos recibidos
        $this->sql = "DELETE FROM productos WHERE codigo = ". $this->codigo ."";

        # Verificar si elimino el producto
        if($this->conn->query($this->sql)){

            return 1;
        }else {
            
            return 0;
        }



    }

    # Funcion de leer producto
    function Leer($codigo){

        # Guardar los datos que llego por parametro a mis variables globales
        $this->codigo = $codigo;
        
        # Sql con los datos recibidos
        $this->sql = "SELECT * FROM productos WHERE codigo LIKE '%".$this->codigo."%'";

        # Tomar el resultado del sql
        $resultado = $this->conn->query($this->sql);

        # Crear arreglo para llenar los datos de el ciclo
        $array = [];

        # Validar si encontro el producto
        if($resultado->num_rows > 0){

            # Mostrar el resultado usando el ciclo while
            while($fila = $resultado->fetch_assoc()){

                $array[] = $fila;
               

            }

            # Imprimo como arreglo para poder recibirlo en el index
            return $array;

        }else{

            # Retorno 0 si no encuentra algun dato
            return 0;
        }

        


    }

    public function MostrarProductos(){

                # Sql con los datos recibidos
                $this->sql = "SELECT * FROM productos";

                # Tomar el resultado del sql
                $resultado = $this->conn->query($this->sql);
        
                # Crear arreglo para llenar los datos de el ciclo
                $array = [];
        
                 # Mostrar el resultado usando el ciclo while
                 while($fila = $resultado->fetch_assoc()){
        
                   $array[] = $fila;

                }

                return $array;

    }




};



?>