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
require_once '../configuracion/conexion_db.php';

# Clase principal de mi modelo
class Producto {

    # Variables Globales para usar en diferente funcion
    public $codigo;
    public $nombre;
    public $tamano;
    public $precio;
    public $oferta;
    public $tipo_producto;
    public $activo;
    public $imagen;
    public $cantidad;

    protected static $tablaConsulta = 'productos';


	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Variable para aplicar Join
	public static $consultaJoin = '';


	// Para especificar una consulta select
	public static $consultaSelect = 'SELECT * FROM productos ';


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



    // Funcion para enviar todos los usuarios de la bd en forma de un arreglo de objetos
    /* Trae todos los usuarios en forma de arreglo
     * Para acceder a los campos, es de la siguiente manera $productos[0]->nombre
    */
    public static function todos()
    {
        // Arreglo que va a contener todos los productos
        $lista_productos = [];


        // Crear una instancia de la conexion
        $conexion = new Conexion;


        // Consulta para la base de datos y despues lo guarda en la variable
        $resultado = $conexion->conn->query('SELECT * FROM ' . static::$tablaConsulta);


        // Recorrer todos los productos que llegaron de la bd
        while ( $producto = $resultado->fetch_assoc() ) {

            // Crear un usario temporal en cada vuelta
            $productoTemporal = new Producto();

            // Añadir los campos al producto
            $productoTemporal->id 	 	      = $producto['id'];
            $productoTemporal->activo 	      = $producto['activo'];
            $productoTemporal->codigo	      = $producto['codigo'];
            $productoTemporal->imagen 	      = $producto['imagen'];
            $productoTemporal->nombre 	      = $producto['nombre'];
            $productoTemporal->oferta         = $producto['oferta'];
            $productoTemporal->precio 	      = $producto['precio'];
            $productoTemporal->tamano	      = $producto['tamano'];
            $productoTemporal->tipo_producto  = $producto['tipo_producto'];
            $productoTemporal->cantidad	      = $producto['cantidad'];



            // Guarda el objeto producto en el arreglo
            $lista_productos[] = $productoTemporal;
        }

        // Devolver todos los usuarios
        return $lista_productos;

    }



	// Funcion para encontrar un usario por id y devolverlo como objeto
	/* Trae un solo usuario en forma de objeto
	 * Para acceder a los campos, es de la siguiente manera $usuario->nombre
	*/
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM " . static::$tablaConsulta . " where id = $id LIMIT 1");

		// Guardar el usuario encontrado por id en la variable
		$productoEncontrado = $resultado->fetch_assoc();


		// Crear un producto
		$producto = new Producto;

        // Añadir los campos al producto
        $producto->id 	 	      = $productoEncontrado['id'];
        $producto->activo 	      = $productoEncontrado['activo'];
        $producto->codigo	      = $productoEncontrado['codigo'];
        $producto->imagen 	      = $productoEncontrado['imagen'];
        $producto->nombre 	      = $productoEncontrado['nombre'];
        $producto->oferta         = $productoEncontrado['oferta'];
        $producto->precio 	      = $productoEncontrado['precio'];
        $producto->tamano	      = $productoEncontrado['tamano'];
        $producto->tipo_producto  = $productoEncontrado['tipo_producto'];
        $producto->cantidad	      = $productoEncontrado['cantidad'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$producto->update = true;

		// Devolver el producto solicitado
		return $producto;
	}



    // ----------------- Consultas --------------

    // Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los usuarios que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $usuarios[0]->nombre
	 * La funcion recive 3 parametros, dos obligatorios y el otro opcional, por defecto sera '='.
	 * - el primer parametro es el campo en que va a estar la condicion
	 * - el segundo parametro puede ser el operador de la condicion o puede ser el comparador (lo que quiere que coincida)
	 * - el tercer parametro, si se puso un operador en el segundo parametro, aca se tendra que poner el valor de la condicion
	 * ademas para traer los datos se debe encadenar la funcion resultado() a lo ultimo
	*/
	public static function donde($campo, $comparador, $operador = null)
	{

		// Si no puso que tipo de operador es, entonces se pone por defecto el igual '='
		if ($operador == null) {
			$operador = '=';
		} else {
			$cambioVariable = $operador;
			$operador = $comparador;
			$comparador = $cambioVariable;
		}


		// Para comprobar si es la primera vez que se usa la funcion donde()
		if (static::$numeroConsultasDonde == 0) {

			// A la variable global se le asigna la condicion para la consulta
			static::$consultasDonde = ' WHERE ' . $campo . ' ' . $operador . ' "' . $comparador . '" ';
			// Se le aumenta el valor a la variable para que no vuelva a entrar por acá
			static::$numeroConsultasDonde++;
		} else {

			// A la variable global se le concatena la condicion para la consulta
			static::$consultasDonde .= ' AND ' . $campo . ' ' . $operador . ' "' . $comparador . '" ';
		}

		// Se devuelve el objeto
		return new static;
	}



    // Funcion para devolver el resultado de toda la consulta que se haya hecho
    public static function resultado()
    {
        // Arreglo que va a contener todos los reportes
        $lista_productos = [];


        // Crear una instancia de la conexion
        $conexion = new Conexion;

        // Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
        $sql = static::$consultaSelect . static::$consultasDonde . static::$consultaJoin . static::$consultaOrdenar . static::$consultaLimite;


        // Consulta para la base de datos y despues lo guarda en la variable
        $resultado = $conexion->conn->query($sql);


        // Recorrer todos los usuarios que llegaron de la bd
        while ( $producto = $resultado->fetch_assoc() ) {

            // Crear un usario temporal en cada vuelta
            $productoTemporal = new Producto();

            // Añadir los campos al usuario
            $productoTemporal->id 	 	         = ( isset($producto['id']) ? $producto['id'] : '');
            $productoTemporal->activo 	         = ( isset($producto['activo']) ? $producto['activo'] : '');
            $productoTemporal->cantidad	         = ( isset($producto['cantidad']) ? $producto['cantidad'] : '');
            $productoTemporal->codigo 	         = ( isset($producto['codigo']) ? $producto['codigo'] : '');
            $productoTemporal->imagen 	         = ( isset($producto['imagen']) ? $producto['imagen'] : '');
            $productoTemporal->nombre            = ( isset($producto['nombre']) ? $producto['nombre'] : '');
            $productoTemporal->oferta 	         = ( isset($producto['oferta']) ? $producto['oferta'] : '');
            $productoTemporal->precio	         = ( isset($producto['precio']) ? $producto['precio'] : '');
            $productoTemporal->tamano 	         = ( isset($producto['tamano']) ? $producto['tamano'] : '');
            $productoTemporal->tipo_producto 	 = ( isset($producto['tipo_producto']) ? $producto['tipo_producto'] : '');


            // Guarda el objeto usuario en el arreglo
            $lista_productos[] = $productoTemporal;
        }



        // Restaurar las variables estaticas
        static::$consultasDonde = '';
        static::$numeroConsultasDonde = 0;
        static::$consultaJoin = '';
        static::$consultaSelect = 'SELECT * FROM ' . static::$tablaConsulta;
        static::$consultaOrdenar = '';
        static::$consultaLimite = '';


        // Devolver todos los productos
        return $lista_productos;

    }






    // --------------------- Eliminar ---------------


	// Funcion para eliminar usuario pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

        

		// Elimina al usuario de la bd encontrado por id
        $conexion->conn->query("DELETE FROM " . static::$tablaConsulta . " WHERE id = $id LIMIT 1");
        
	}


	// Funcion para eliminar despues de que se haya buscado un usuario y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del usuario actual
		$id = $this->id;


		// Crear una instancia de la conexion
        $conexion = new Conexion;
        
        
		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM " . static::$tablaConsulta . " where id = $id LIMIT 1");

		// Guardar el usuario encontrado por id en la variable
        $productoEncontrado = $resultado->fetch_assoc();
        
        // Eliminar imagen de la carpeta
        unlink($productoEncontrado['imagen']);


		// Elimina al producto de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ". static::$tablaConsulta ." WHERE id = $id LIMIT 1");
    
    }
    

    // ---------------- Actualizar --------------------
	// Funcion para guardar los datos del objecto actual (Producto), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
        $conexion = new Conexion;
        


		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {
            
            // Consulta para la base de datos y despues lo guarda en la variable
		    $resultado = $conexion->conn->query("SELECT * FROM " . static::$tablaConsulta . " where id = $this->id LIMIT 1");

            // Guardar el usuario encontrado por id en la variable
            $productoEncontrado = $resultado->fetch_assoc();
            
            // Eliminar imagen de la carpeta
            unlink($productoEncontrado['imagen']);
            


			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE productos SET codigo= ?, nombre= ?, precio= ?, cantidad= ?, oferta= ?, tamano= ?, tipo_producto= ?, imagen= ?, activo = ? WHERE id= ?");
            
			 // Pasar los campos del objecto a la sentencia
             $sentencia->bind_param(
                'isiiisssii',
                $this->codigo,
                $this->nombre,
                $this->precio,
                $this->cantidad,
                $this->oferta,
                $this->tamano,
                $this->tipo_producto,
                $this->imagen,
                $this->activo,
                $this->id
                
             );

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO productos VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		    // Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
                    'isiiisssi',
					$this->codigo,
					$this->nombre,
					$this->precio,
					$this->cantidad,
					$this->oferta,
					$this->tamano,
					$this->tipo_producto,
                    $this->imagen,
                    $this->activo
					
			);
		}


		// Ejecutar la sentencia
		if ( $sentencia->execute() ) {

			// Devolver un uno si fue un exito
			return 1;
		} else {

			// Devolver un 0 si ocurrio un error
			return 0;
		}

	}






};



?>
