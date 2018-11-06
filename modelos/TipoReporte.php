<?php

require_once '../configuracion/conexion_db.php';

/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Tipo Reportes)
 * Conexion mysqli
 *
 */
class TipoReporte
{
    protected static $tablaConsulta = 'tipo_reportes';

	// Variables, campos de referencia con la tabla reportes
	public $id;
	public $reporte;


	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Para especificar una consulta select
	public static $consultaSelect = "SELECT * FROM tipo_reportes ";


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los reportes de la bd en forma de un arreglo de objetos
	/* Trae todos los reportes en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $tipoReportes[0]->reporte
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los reportes
		$lista_tipo_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ". static::$tablaConsulta . "");


		// Recorrer todos los reportes que llegaron de la bd
		while ( $tipo_reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$tipoReporteTemporal = new TipoReporte;

			// Añadir los campos al reporte
			$tipoReporteTemporal->id 	 	 = $tipo_reporte['id'];
			$tipoReporteTemporal->reporte 	 = $tipo_reporte['reporte'];

			// Guarda el objeto reporte en el arreglo
			$lista_tipo_reportes[] = $tipoReporteTemporal;
		}

		// Devolver todos los reportes
		return $lista_tipo_reportes;

	}


	// Funcion para encontrar un reporte por id y devolverlo como objeto
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1");

		// Guardar el reporte encontrado por id en la variable
		$tipoReporteEncontrado = $resultado->fetch_assoc();


		// Crear un tipo de reporte
		$tipoReporte = new TipoReporte();

		// Añadir los campos al tipo de reporte
		$tipoReporte->id 	 	 = $tipoReporteEncontrado['id'];
		$tipoReporte->reporte 	 = $tipoReporteEncontrado['reporte'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$tipoReporte->update = true;

		// Devolver el reporte solicitado
		return $tipoReporte;
	}


	// Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los reportes que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $tipoReportes[0]->reporte
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
		static::$consultaSelect = "SELECT $campos FROM ". static::$tablaConsulta . "";

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
		// Arreglo que va a contener todos los tipos de reportes
		$lista_tipo_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultasDonde . static::$consultaOrdenar . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los tipos de reportes que llegaron de la bd
		while ( $tipo_reporte = $resultado->fetch_assoc() ) {

			// Crear un tipo de reporte temporal en cada vuelta
			$tipoReporteTemporal = new TipoReporte;

			// Añadir los campos al tipo de reporte
			$tipoReporteTemporal->id 	 	 = ( isset($tipo_reporte['id']) ? $tipo_reporte['id'] : '');
			$tipoReporteTemporal->reporte 	 = ( isset($tipo_reporte['reporte']) ? $tipo_reporte['reporte'] : '');


			// Guarda el objeto tipo de reporte en el arreglo
			$lista_tipo_reportes[] = $tipoReporteTemporal;
		}

		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaSelect = 'SELECT * FROM reportes ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los tipos de reportes
		return $lista_tipo_reportes;

	}






	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los reportes
		$lista_tipo_reportes = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los reportes que llegaron de la bd
		while ( $tipo_reporte = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$tipoReporteTemporal = new Reporte();

			// Añadir los campos al tipo de reporte
			$tipoReporteTemporal->id 	 	 = $tipo_reporte['id'];
			$tipoReporteTemporal->reporte 	 = $tipo_reporte['reporte'];

			// Guarda el objeto reporte en el arreglo
			$lista_tipo_reportes[] = $tipoReporteTemporal;
		}

		// Devolver todos los reportes
		return $lista_tipo_reportes;
	}






	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el tipo de reporte en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta . " VALUES (null, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				's',
				$datos['reporte']
		);

		// Ejecutar la sentencia
		$sentencia->execute();
	}


	// Funcion para guardar los datos del objecto actual (Tipo Reporte), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el tipo de reporte en la bd
			$sentencia = $conexion->conn->prepare("UPDATE ". static::$tablaConsulta . " SET reporte= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'si',
					$this->reporte,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el tipo de reporte en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta . " VALUES (null, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					's',
					$this->reporte
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





	// Funcion para eliminar el tipo de reporte pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un tipo de reporte y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del reporte actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al reporte de la bd encontrado por id
		if($conexion->conn->query("DELETE FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1")) {
            return 1;
        } else {
            return 0;
        }
	}


}
