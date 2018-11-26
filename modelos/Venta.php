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
class Venta
{

    public static $tablaConsulta = 'ventas';

	// Variables, campos de referencia con la tabla ventas
	public $id;
	public $fecha;
	public $medio_pago_id;
	public $datos;
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
	public static $consultaSelect = 'SELECT * FROM ventas ';


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
		$lista_ventas = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query('SELECT * FROM ' . static::$tablaConsulta);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $ventas = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$ventasTemporal = new Venta();

			// Añadir los campos al reporte
			$ventasTemporal->id 	 	 	 	 = $ventas['id'];
			$ventasTemporal->fecha 	 	 	     = $ventas['fecha'];
			$ventasTemporal->datos 	 	 = $ventas['datos'];
			$ventasTemporal->medio_pago_id	     = $ventas['medio_pago_id'];
			$ventasTemporal->usuario_id	 	     = $ventas['usuario_id'];
            $ventasTemporal->valor_total         = $ventas['valor_total'];

			// Guarda el objeto reporte en el arreglo
			$lista_ventas[] = $ventasTemporal;
		}

		// Devolver todos los ventas
		return $lista_ventas;

	}


	// Funcion para encontrar un reporte por id y devolverlo como objeto
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ventas where id = $id LIMIT 1");

		// Guardar el reporte encontrado por id en la variable
		$reporteEncontrado = $resultado->fetch_assoc();


		// Crear una venta
		$reporte = new Venta();

		// Añadir los campos a las ventas
		$reporte->id 	 	 	 = $reporteEncontrado['id'];
		$reporte->fecha 	 = $reporteEncontrado['fecha'];
		$reporte->medio_pago_id 	 	 = $reporteEncontrado['medio_pago_id'];
		$reporte->datos 	 = $reporteEncontrado['datos'];
		$reporte->usuario_id	 = $reporteEncontrado['usuario_id'];
        $reporte->valor_total	 = $reporteEncontrado['valor_total'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$reporte->update = true;

		// Devolver el reporte solicitado
		return $reporte;
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
		$lista_ventas = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultaJoin . static::$consultaOrdenar . static::$consultasDonde . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $venta = $resultado->fetch_assoc() ) {



			// Crear un reporte temporal en cada vuelta
			$ventasTemporal = new Venta();

			// Añadir los campos al reporte
			$ventasTemporal->id 	 	 	 = ( isset($venta['id']) ? $venta['id'] : '');
			$ventasTemporal->fecha 	 	 	 = ( isset($venta['fecha']) ? $venta['fecha'] : '');
            $ventasTemporal->medio_pago_id 	 = ( isset($venta['medio_pago_id']) ? $venta['medio_pago_id'] : '');
			$ventasTemporal->datos	         = ( isset($venta['datos']) ? $venta['datos'] : '');
			$ventasTemporal->usuario_id	 	 = ( isset($venta['usuario_id']) ? $venta['usuario_id'] : '');
			$ventasTemporal->valor_total	 = ( isset($venta['valor_total']) ? $venta['valor_total'] : '');


			if( isset($venta['nombreUsuario']) ) {

				// Crear un usuario temporal en cada vuelta
				$usuarioTemporal = new Usuario;

				// Añadir los campos al usuario
				$usuarioTemporal->apellido 	 = ( isset($venta['apellido']) ? $venta['apellido'] : '');
				$usuarioTemporal->cedula	 = ( isset($venta['cedula']) ? $venta['cedula'] : '');
				$usuarioTemporal->celular 	 = ( isset($venta['celular']) ? $venta['celular'] : '');
				$usuarioTemporal->ciudad 	 = ( isset($venta['ciudad']) ? $venta['ciudad'] : '');
				$usuarioTemporal->correo 	 = ( isset($venta['correo']) ? $venta['correo'] : '');
				$usuarioTemporal->direccion	 = ( isset($venta['direccion']) ? $venta['direccion'] : '');
				$usuarioTemporal->nombre 	 = ( isset($venta['nombreUsuario']) ? $venta['nombreUsuario'] : '');
				$usuarioTemporal->rol_id 	 = ( isset($venta['rol_id']) ? $venta['rol_id'] : '');
				$usuarioTemporal->rol 	 	 = ( isset($venta['rol']) ? $venta['rol'] : '');

				// Añadir el usuario
				$ventasTemporal->usuario = $usuarioTemporal;

			}

			if( isset($venta['nombreProducto']) ) {

                // Crear un usario temporal en cada vuelta
                $productoTemporal = new Producto();

                // Añadir los campos al producto
                $productoTemporal->id 	 	      = ( isset($venta['id']) ? $venta['id'] : '');
                $productoTemporal->activo 	      = ( isset($venta['activo']) ? $venta['activo'] : '');
                $productoTemporal->codigo	      = ( isset($venta['codigo']) ? $venta['codigo'] : '');
                $productoTemporal->imagen 	      = ( isset($venta['imagen']) ? $venta['imagen'] : '');
                $productoTemporal->nombre 	      = ( isset($venta['nombreProducto']) ? $venta['nombreProducto'] : '');
                $productoTemporal->oferta         = ( isset($venta['oferta']) ? $venta['oferta'] : '');
                $productoTemporal->precio 	      = ( isset($venta['precio']) ? $venta['precio'] : '');
                $productoTemporal->tamano	      = ( isset($venta['tamano']) ? $venta['tamano'] : '');
                $productoTemporal->tipo_producto  = ( isset($venta['tipo_producto']) ? $venta['tipo_producto'] : '');
                $productoTemporal->cantidad	      = ( isset($venta['cantidad']) ? $venta['cantidad'] : '');


				// Añadir el tipo de reporte
				$ventasTemporal->producto = $productoTemporal;
			}



            if( isset($venta['medio']) ) {

                // Crear un medio de pago temporal en cada vuelta
    			$medioTemporal = new MedioPago;

    			// Añadir los campos al tipo de rol
    			$medioTemporal->id 	     = ( isset($venta['id']) ? $venta['id'] : '');
    			$medioTemporal->medio 	 = ( isset($venta['medio']) ? $venta['medio'] : '');


				// Añadir el tipo de reporte
				$ventasTemporal->medio_pago = $medioTemporal;
			}





			// Guarda el objeto reporte en el arreglo
			$lista_ventas[] = $ventasTemporal;
		}






		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaJoin = '';
		static::$numeroConsultasJoin = 0;
		static::$consultaSelect = 'SELECT * FROM ventas ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los ventas
		return $lista_ventas;

	}






	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los ventas
		$lista_ventas = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los ventas que llegaron de la bd
		while ( $reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$ventasTemporal = new Venta();

			// Añadir los campos al reporte
			$ventasTemporal->id 	 	 	 = $reporte['id'];
			$ventasTemporal->descripcion 	 = $reporte['descripcion'];
			$ventasTemporal->fecha 	 	 = $reporte['fecha'];
			$ventasTemporal->datos 	 = $reporte['datos'];
			$ventasTemporal->tipo_reporte_id	 = $reporte['tipo_reporte_id'];
			$ventasTemporal->usuario_id	 = $reporte['usuario_id'];

			// Guarda el objeto reporte en el arreglo
			$lista_ventas[] = $ventasTemporal;
		}

		// Devolver todos los ventas
		return $lista_ventas;
	}






	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el usuario en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO ventas VALUES (null, ?, ?, ?, ?, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				'ssisi',
				$datos['descripcion'],
				$datos['fecha'],
				$datos['datos'],
				$datos['tipo_reporte_id'],
				$datos['usuario_id']
		);

		// Ejecutar la sentencia
		$sentencia->execute();
	}


	// Funcion para guardar los datos del objecto actual (Venta), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE ventas SET valor_total= ?, fecha= ?, datos= ?, medio_pago_id= ?, usuario_id= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'issiii',
					$this->valor_total,
					$this->fecha,
					$this->datos,
					$this->medio_pago_id,
					$this->usuario_id,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO ventas VALUES (null, ?, ?, ?, ?, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'sisii',
                    $this->fecha,
                    $this->medio_pago_id,
                    $this->datos,
                    $this->usuario_id,
					$this->valor_total
			);
		}


		// Ejecutar la sentencia
		if ( $sentencia->execute()) {

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
		$conexion->conn->query("DELETE FROM ventas WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un reporte y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del reporte actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ventas WHERE id = $id LIMIT 1");
	}


}
