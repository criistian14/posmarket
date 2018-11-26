<?php

require_once '../configuracion/conexion_db.php';

// Modelos
require_once '../modelos/Usuario.php';
require_once '../modelos/Producto.php';
require_once '../modelos/MedioPago.php';


/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Reportes)
 * Conexion mysqli
 *
 */
class Compra
{

    public static $tablaConsulta = 'compras';

	// Variables, campos de referencia con la tabla ventas
	public $id;
	public $cantidad;
    public $fecha;
    public $medio_pago_id;
	public $producto_id;
	public $usuario_id;
    public $valor_total;

    // Llamadas de instancias foraneas
	public $medio_pago;
	public $usuario;
	public $producto;


	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Variable para aplicar Join
	public static $consultaJoin = '';
	// Variable para comprobar si solo paso una sentencia Join de sql o mas de una
	public static $numeroConsultasJoin = 0;

	// Para especificar una consulta select
	public static $consultaSelect = 'SELECT * FROM compras ';


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los ventas de la bd en forma de un arreglo de objetos
	/* Trae todos los ventas en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $ventas[0]->descripcion
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los ventas
		$lista_compras = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query('SELECT * FROM ' . static::$tablaConsulta);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $compras = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$comprasTemporal = new Compra;

			// Añadir los campos al reporte
			$comprasTemporal->id 	 	 	 	 = $compras['id'];
            $comprasTemporal->cantidad 	 	 	 = $compras['cantidad'];
			$comprasTemporal->fecha 	 	 	 = $compras['fecha'];
			$comprasTemporal->producto_id 	 	 = $compras['producto_id'];
			$comprasTemporal->medio_pago_id	     = $compras['medio_pago_id'];
			$comprasTemporal->usuario_id	 	 = $compras['usuario_id'];
            $comprasTemporal->valor_total        = $compras['valor_total'];

			// Guarda el objeto reporte en el arreglo
			$lista_compras[] = $comprasTemporal;
		}

		// Devolver todos los ventas
		return $lista_compras;

	}


	// Funcion para encontrar un reporte por id y devolverlo como objeto
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ". static::$tablaConsulta ." where id = $id LIMIT 1");

		// Guardar el reporte encontrado por id en la variable
		$compraEncontrado = $resultado->fetch_assoc();


		// Crear una venta
		$compra = new Compra;

		// Añadir los campos a las ventas
		$compra->id 	 	 	     = $compraEncontrado['id'];
        $compra->cantidad 	         = $compraEncontrado['cantidad'];
		$compra->fecha 	             = $compraEncontrado['fecha'];
		$compra->medio_pago_id 	 	 = $compraEncontrado['medio_pago_id'];
		$compra->producto_id 	     = $compraEncontrado['producto_id'];
		$compra->usuario_id	         = $compraEncontrado['usuario_id'];
        $compra->valor_total	     = $compraEncontrado['valor_total'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$compra->update = true;

		// Devolver el reporte solicitado
		return $compra;
	}


	// Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los ventas que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $ventas[0]->nombre
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



	// Funcion para escoger los campos para la consulta
	public static function seleccionar($campos)
	{
		// A la variable global se le asigna que campos va a traer para la consulta
		static::$consultaSelect = "SELECT $campos FROM ". static::$tablaConsulta;

		// Se devuelve el objeto
		return new static;
	}


	// Funcion para unir la tablas que se requieran
	public static function unir($tablaOrigen, $tablaUnir, $campoReferencia, $campoOriginal)
	{

		if (static::$numeroConsultasJoin == 0) {

			// A la variable global se le asigna traer los datos de la tabla roles para la consulta
			static::$consultaJoin = " INNER JOIN $tablaUnir ON $tablaOrigen.$campoReferencia = $tablaUnir.$campoOriginal ";
			// Se le aumenta el valor a la variable para que no vuelva a entrar por acá
			static::$numeroConsultasJoin++;

		} else {

			// A la variable global se le concatena la condicion para la consulta
			static::$consultaJoin .= " INNER JOIN $tablaUnir ON $tablaOrigen.$campoReferencia = $tablaUnir.$campoOriginal ";
		}


		// Se devuelve el objeto
		return new static;
	}




	// Funcion para que los datos de la consulta se ordenen como se desee
	/* Tambien se pueden ordenar los datos que llegar con la funcion ordenar(), esta recive dos parametros
	 * - el primer parametro es el campo en el que va a ordenar,
	 * - el segundo parametro es la forma en la que va a ordenarlo, Descendiente ('desc') o Ascendiente ('asc')
	*/
	public static function ordenar($campo, $forma)
	{
		// A la variable global se le asigna la forma de ordenar para la consulta
		static::$consultaOrdenar = ' ORDER BY ' . $campo . ' ' . $forma;

		// Se devuelve el objeto
		return new static;
	}


	// Funcion para establecer un limite
	public static function limite($inicio = 0, $limite)
	{
		// A la variable global se le asigna el limite para la consulta
		static::$consultaLimite = " LIMIT $inicio, $limite";

		// Se devuelve el objeto
		return new static;
	}


	// Funcion para devolver el resultado de toda la consulta que se haya hecho
	public static function resultado()
	{
		// Arreglo que va a contener todos los ventas
		$lista_compras = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultaJoin . static::$consultaOrdenar . static::$consultasDonde . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $compra = $resultado->fetch_assoc() ) {



			// Crear un reporte temporal en cada vuelta
			$compraTemporal = new Compra();

			// Añadir los campos al reporte
            $compraTemporal->id 	 	 	 = ( isset($compra['id']) ? $compra['id'] : '');
			$compraTemporal->cantidad 	 	 = ( isset($compra['cantidad']) ? $compra['cantidad'] : '');
			$compraTemporal->fecha 	 	 	 = ( isset($compra['fecha']) ? $compra['fecha'] : '');
            $compraTemporal->medio_pago_id 	 = ( isset($compra['medio_pago_id']) ? $compra['medio_pago_id'] : '');
			$compraTemporal->producto_id	 = ( isset($compra['producto_id']) ? $compra['producto_id'] : '');
			$compraTemporal->usuario_id	 	 = ( isset($compra['usuario_id']) ? $compra['usuario_id'] : '');
			$compraTemporal->valor_total	 = ( isset($compra['valor_total']) ? $compra['valor_total'] : '');


			if( isset($compra['nombreUsuario']) ) {

				// Crear un usuario temporal en cada vuelta
				$usuarioTemporal = new Usuario;

				// Añadir los campos al usuario
				$usuarioTemporal->apellido 	 = ( isset($compra['apellido']) ? $compra['apellido'] : '');
				$usuarioTemporal->cedula	 = ( isset($compra['cedula']) ? $compra['cedula'] : '');
				$usuarioTemporal->celular 	 = ( isset($compra['celular']) ? $compra['celular'] : '');
				$usuarioTemporal->ciudad 	 = ( isset($compra['ciudad']) ? $compra['ciudad'] : '');
				$usuarioTemporal->correo 	 = ( isset($compra['correo']) ? $compra['correo'] : '');
				$usuarioTemporal->direccion	 = ( isset($compra['direccion']) ? $compra['direccion'] : '');
				$usuarioTemporal->nombre 	 = ( isset($compra['nombreUsuario']) ? $compra['nombreUsuario'] : '');
				$usuarioTemporal->rol_id 	 = ( isset($compra['rol_id']) ? $compra['rol_id'] : '');
				$usuarioTemporal->rol 	 	 = ( isset($compra['rol']) ? $compra['rol'] : '');

				// Añadir el usuario
				$compraTemporal->usuario = $usuarioTemporal;
			}



			if( isset($compra['nombreProducto']) ) {

                // Crear un usario temporal en cada vuelta
                $productoTemporal = new Producto;

                // Añadir los campos al producto
                $productoTemporal->id 	 	      = ( isset($compra['id']) ? $compra['id'] : '');
                $productoTemporal->activo 	      = ( isset($compra['activo']) ? $compra['activo'] : '');
                $productoTemporal->codigo	      = ( isset($compra['codigo']) ? $compra['codigo'] : '');
                $productoTemporal->imagen 	      = ( isset($compra['imagen']) ? $compra['imagen'] : '');
                $productoTemporal->nombre 	      = ( isset($compra['nombreProducto']) ? $compra['nombreProducto'] : '');
                $productoTemporal->oferta         = ( isset($compra['oferta']) ? $compra['oferta'] : '');
                $productoTemporal->precio 	      = ( isset($compra['precio']) ? $compra['precio'] : '');
                $productoTemporal->tamano	      = ( isset($compra['tamano']) ? $compra['tamano'] : '');
                $productoTemporal->tipo_producto  = ( isset($compra['tipo_producto']) ? $compra['tipo_producto'] : '');
                $productoTemporal->cantidad	      = ( isset($compra['cantidad']) ? $compra['cantidad'] : '');


				// Añadir el tipo de reporte
				$compraTemporal->producto = $productoTemporal;
			}



            if( isset($compra['medio']) ) {

                // Crear un medio de pago temporal en cada vuelta
    			$medioTemporal = new MedioPago;

    			// Añadir los campos al tipo de rol
    			$medioTemporal->id 	     = ( isset($compra['id']) ? $compra['id'] : '');
    			$medioTemporal->medio 	 = ( isset($compra['medio']) ? $compra['medio'] : '');


				// Añadir el tipo de reporte
				$compraTemporal->medio_pago = $medioTemporal;
			}


			// Guarda el objeto reporte en el arreglo
			$lista_compras[] = $compraTemporal;
		}





		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaJoin = '';
		static::$numeroConsultasJoin = 0;
		static::$consultaSelect = 'SELECT * FROM compras ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los ventas
		return $lista_compras;

	}






	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los ventas
		$lista_compras = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$ventasTemporal = new Compra();

			// Añadir los campos al reporte
			$ventasTemporal->id 	 	 	 = $reporte['id'];
			$ventasTemporal->descripcion 	 = $reporte['descripcion'];
			$ventasTemporal->fecha 	 	 = $reporte['fecha'];
			$ventasTemporal->producto_id 	 = $reporte['producto_id'];
			$ventasTemporal->tipo_reporte_id	 = $reporte['tipo_reporte_id'];
			$ventasTemporal->usuario_id	 = $reporte['usuario_id'];

			// Guarda el objeto reporte en el arreglo
			$lista_compras[] = $ventasTemporal;
		}

		// Devolver todos los ventas
		return $lista_compras;
	}






	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el usuario en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta ." VALUES (null, ?, ?, ?, ?, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				'ssisi',
				$datos['descripcion'],
				$datos['fecha'],
				$datos['producto_id'],
				$datos['tipo_reporte_id'],
				$datos['usuario_id']
		);

		// Ejecutar la sentencia
		$sentencia->execute();
	}


	// Funcion para guardar los datos del objecto actual (Compra), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE ". static::$tablaConsulta ." SET valor_total= ?, fecha= ?, producto_id= ?, medio_pago_id= ?, usuario_id= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'isiiii',
					$this->valor_total,
					$this->fecha,
					$this->producto_id,
					$this->medio_pago_id,
					$this->usuario_id,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta ." VALUES (null, ?, ?, ?, ?, ?, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'isiiii',
                    $this->cantidad,
                    $this->fecha,
					$this->medio_pago_id,
					$this->producto_id,
					$this->usuario_id,
					$this->valor_total
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





	// Funcion para eliminar reporte pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ". static::$tablaConsulta ." WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un reporte y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del reporte actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ". static::$tablaConsulta ." WHERE id = $id LIMIT 1");
	}


}
