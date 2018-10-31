<?php

require_once '../configuracion/conexion_db.php';

// Modelos
require_once '../modelos/Usuario.php';
require_once '../modelos/TipoReporte.php';


/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Reportes)
 * Conexion mysqli
 *
 */
class Reporte
{

	// Variables, campos de referencia con la tabla reportes
	public $id;
	public $descripcion;
	public $fecha;
	public $producto_id;
	public $tipo_reporte_id;
	public $usuario_id;

	public $tipo_reporte;
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
	public static $consultaSelect = 'SELECT * FROM usuarios ';


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los reportes de la bd en forma de un arreglo de objetos
	/* Trae todos los reportes en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $reportes[0]->descripcion
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los reportes
		$lista_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query('SELECT * FROM reportes');


		// Recorrer todos los reportes que llegaron de la bd
		while ( $reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$reporteTemporal = new Reporte();

			// Añadir los campos al reporte
			$reporteTemporal->id 	 	 	 	 = $reporte['id'];
			$reporteTemporal->descripcion 	 	 = $reporte['descripcion'];
			$reporteTemporal->fecha 	 	 	 = $reporte['fecha'];
			$reporteTemporal->producto_id 	 	 = $reporte['producto_id'];
			$reporteTemporal->tipo_reporte_id	 = $reporte['tipo_reporte_id'];
			$reporteTemporal->usuario_id	 	 = $reporte['usuario_id'];

			// Guarda el objeto reporte en el arreglo
			$lista_reportes[] = $reporteTemporal;
		}

		// Devolver todos los reportes
		return $lista_reportes;

	}


	// Funcion para encontrar un reporte por id y devolverlo como objeto
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM reportes where id = $id LIMIT 1");

		// Guardar el reporte encontrado por id en la variable
		$reporteEncontrado = $resultado->fetch_assoc();


		// Crear un reporte
		$reporte = new Reporte();

		// Añadir los campos al reporte
		$reporte->id 	 	 	 = $reporteEncontrado['id'];
		$reporte->descripcion 	 = $reporteEncontrado['descripcion'];
		$reporte->fecha 	 	 = $reporteEncontrado['fecha'];
		$reporte->producto_id 	 = $reporteEncontrado['producto_id'];
		$reporte->tipo_reporte_id	 = $reporteEncontrado['tipo_reporte_id'];
		$reporte->usuario_id	 = $reporteEncontrado['usuario_id'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$reporte->update = true;

		// Devolver el reporte solicitado
		return $reporte;
	}


	// Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los reportes que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $reportes[0]->nombre
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
		static::$consultaSelect = "SELECT $campos FROM reportes";

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
		// Arreglo que va a contener todos los reportes
		$lista_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultasDonde . static::$consultaJoin . static::$consultaOrdenar . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los reportes que llegaron de la bd
		while ( $reporte = $resultado->fetch_assoc() ) {


			// Crear un reporte temporal en cada vuelta
			$reporteTemporal = new Reporte();

			// Añadir los campos al reporte
			$reporteTemporal->id 	 	 	 	 = ( isset($reporte['id']) ? $reporte['id'] : '');
			$reporteTemporal->descripcion 		 = ( isset($reporte['descripcion']) ? $reporte['descripcion'] : '');
			$reporteTemporal->fecha 	 	 	 = ( isset($reporte['fecha']) ? $reporte['fecha'] : '');
			$reporteTemporal->producto_id 	 	 = ( isset($reporte['producto_id']) ? $reporte['producto_id'] : '');
			$reporteTemporal->tipo_reporte_id	 = ( isset($reporte['tipo_reporte_id']) ? $reporte['tipo_reporte_id'] : '');
			$reporteTemporal->usuario_id	 	 = ( isset($reporte['usuario_id']) ? $reporte['usuario_id'] : '');


			if( isset($reporte['rol_id']) ) {

				// Crear un usuario temporal en cada vuelta
				$usuarioTemporal = new Usuario;

				// Añadir los campos al usuario
				$usuarioTemporal->apellido 	 = ( isset($reporte['apellido']) ? $reporte['apellido'] : '');
				$usuarioTemporal->cedula	 = ( isset($reporte['cedula']) ? $reporte['cedula'] : '');
				$usuarioTemporal->celular 	 = ( isset($reporte['celular']) ? $reporte['celular'] : '');
				$usuarioTemporal->ciudad 	 = ( isset($reporte['ciudad']) ? $reporte['ciudad'] : '');
				$usuarioTemporal->correo 	 = ( isset($reporte['correo']) ? $reporte['correo'] : '');
				$usuarioTemporal->direccion	 = ( isset($reporte['direccion']) ? $reporte['direccion'] : '');
				$usuarioTemporal->nombre 	 = ( isset($reporte['nombre']) ? $reporte['nombre'] : '');
				$usuarioTemporal->rol_id 	 = ( isset($reporte['rol_id']) ? $reporte['rol_id'] : '');
				$usuarioTemporal->rol 	 	 = ( isset($reporte['rol']) ? $reporte['rol'] : '');

				// Añadir el usuario
				$reporteTemporal->usuario = $usuarioTemporal;

			}

			if( isset($reporte['reporte']) ) {

				// Crear un tipo de reporte temporal en cada vuelta
				$tipoReporteTemporal = new TipoReporte();

				// Añadir los campos al tipo de reporte
				$tipoReporteTemporal->reporte 	 = ( isset($reporte['reporte']) ? $reporte['reporte'] : '');

				// Añadir el tipo de reporte
				$reporteTemporal->tipo_reporte = $tipoReporteTemporal;
			}


			// Guarda el objeto reporte en el arreglo
			$lista_reportes[] = $reporteTemporal;
		}

		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaJoin = '';
		static::$numeroConsultasJoin = 0;
		static::$consultaSelect = 'SELECT * FROM reportes ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los reportes
		return $lista_reportes;

	}






	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los reportes
		$lista_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los reportes que llegaron de la bd
		while ( $reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$reporteTemporal = new Reporte();

			// Añadir los campos al reporte
			$reporteTemporal->id 	 	 	 = $reporte['id'];
			$reporteTemporal->descripcion 	 = $reporte['descripcion'];
			$reporteTemporal->fecha 	 	 = $reporte['fecha'];
			$reporteTemporal->producto_id 	 = $reporte['producto_id'];
			$reporteTemporal->tipo_reporte_id	 = $reporte['tipo_reporte_id'];
			$reporteTemporal->usuario_id	 = $reporte['usuario_id'];

			// Guarda el objeto reporte en el arreglo
			$lista_reportes[] = $reporteTemporal;
		}

		// Devolver todos los reportes
		return $lista_reportes;
	}






	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el usuario en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO reportes VALUES (null, ?, ?, ?, ?, ?)");

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


	// Funcion para guardar los datos del objecto actual (Reporte), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE reportes SET descripcion= ?, fecha= ?, producto_id= ?, tipo_reporte_id= ?, usuario_id= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'ssisii',
					$this->descripcion,
					$this->fecha,
					$this->producto_id,
					$this->tipo_reporte_id,
					$this->usuario_id,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO reportes VALUES (null, ?, ?, ?, ?, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'ssisi',
					$this->descripcion,
					$this->fecha,
					$this->producto_id,
					$this->tipo_reporte_id,
					$this->usuario_id
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
		$conexion->conn->query("DELETE FROM reportes WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un reporte y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del reporte actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		$conexion->conn->query("DELETE FROM reportes WHERE id = $id LIMIT 1");
	}


}
