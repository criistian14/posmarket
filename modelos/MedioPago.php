<?php

require_once '../configuracion/conexion_db.php';

/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Tipo Reportes)
 * Conexion mysqli
 *
 */
class MedioPago
{
    protected static $tablaConsulta = 'medios_pago';

	// Variables, campos de referencia con la tabla roles
	public $id;
	public $medio;


	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Para especificar una consulta select
	public static $consultaSelect = "SELECT * FROM medios_pago ";


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los roles de la bd en forma de un arreglo de objetos
	/* Trae todos los roles en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $medio[0]->reporte
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los roles
		$lista_medios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ". static::$tablaConsulta );


		// Recorrer todos los roles que llegaron de la bd
		while ( $medio = $resultado->fetch_assoc() ) {

			// Crear un reporte temporal en cada vuelta
			$medioTemporal = new MedioPago;

			// Añadir los campos al rol
			$medioTemporal->id 	     = $medio['id'];
			$medioTemporal->medio 	 = $medio['medio'];

			// Guarda el objeto rol en el arreglo
			$lista_medios[] = $medioTemporal;
		}

		// Devolver todos los roles
		return $lista_medios;

	}


	// Funcion para encontrar un rol por id y devolverlo como objeto
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1");

		// Guardar el rol encontrado por id en la variable
		$medioEncontrado = $resultado->fetch_assoc();


		// Crear un tipo de rol
		$medio = new MedioPago;

		// Añadir los campos al tipo de rol
		$medio->id 	     = $medioEncontrado['id'];
		$medio->medio 	 = $medioEncontrado['medio'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$medio->update = true;

		// Devolver el rol solicitado
		return $medio;
	}


	// Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los roles que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $medio[0]->medio
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
		// Arreglo que va a contener todos los tipos de roles
		$lista_medios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultasDonde . static::$consultaOrdenar . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los tipos de roles que llegaron de la bd
		while ( $medio = $resultado->fetch_assoc() ) {

			// Crear un tipo de rol temporal en cada vuelta
			$medioTemporal = new MedioPago;

			// Añadir los campos al tipo de rol
			$medioTemporal->id 	     = ( isset($medio['id']) ? $medio['id'] : '');
			$medioTemporal->medio 	 = ( isset($medio['medio']) ? $medio['medio'] : '');


			// Guarda el objeto tipo de rol en el arreglo
			$lista_medios[] = $medioTemporal;
		}

		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaSelect = 'SELECT * FROM medios_pago ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los tipos de roles
		return $lista_medios;

	}






	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los roles
		$lista_medios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los roles que llegaron de la bd
		while ( $medio = $resultado->fetch_assoc() ) {

			// Crear un rol temporal en cada vuelta
			$medioTemporal = new Reporte();

			// Añadir los campos al tipo de rol
			$medioTemporal->id 	 	 = $medio['id'];
			$medioTemporal->medio 	 = $medio['medio'];

			// Guarda el objeto rol en el arreglo
			$lista_medios[] = $medioTemporal;
		}

		// Devolver todos los roles
		return $lista_medios;
	}






	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el tipo de rol en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta . " VALUES (null, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				's',
				$datos['medio']
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

			// Preparar la sentencia para actualizar el tipo de rol en la bd
			$sentencia = $conexion->conn->prepare("UPDATE ". static::$tablaConsulta . " SET medio= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'si',
					$this->medio,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el tipo de rol en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO ". static::$tablaConsulta . " VALUES (null, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					's',
					$this->medio
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





	// Funcion para eliminar el tipo de rol pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al rol de la bd encontrado por id
		$conexion->conn->query("DELETE FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un tipo de rol y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del rol actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al rol de la bd encontrado por id
		if($conexion->conn->query("DELETE FROM ". static::$tablaConsulta . " WHERE id = $id LIMIT 1")) {

			// Devolver un uno si fue un exito
			return 1;

		} else {

			// Devolver un 0 si ocurrio un error
			return 0;
		}
	}


}
