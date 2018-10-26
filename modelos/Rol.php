<?php

require_once '../configuracion/conexion_db.php';

/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Roles)
 * Conexion mysqli
 *
 */
class Rol
{

	// Variables, campos de referencia con la tabla usuarios
	public $id;
	public $rol;


	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los usuarios de la bd en forma de un arreglo de objetos
	/* Trae todos los usuarios en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $rol[0]->nombre
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los usuarios
		$lista_roles = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query('SELECT * FROM roles');


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $rol = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$rolTemporal = new Rol();

			// Añadir los campos al usuario
			$rolTemporal->id 	 = $rol['id'];
			$rolTemporal->rol 	 = $rol['rol'];

			// Guarda el objeto usuario en el arreglo
			$lista_roles[] = $rolTemporal;
		}

		// Devolver todos los usuarios
		return $lista_roles;

	}


	// Funcion para encontrar un usario por id y devolverlo como objeto
	/* Trae un solo usuario en forma de objeto
	 * Para acceder a los campos, es de la siguiente manera $rol->nombre
	*/
	public static function encontrarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query("SELECT * FROM roles where id = $id LIMIT 1");

		// Guardar el usuario encontrado por id en la variable
		$rolEncontrado = $resultado->fetch_assoc();


		// Crear un usario
		$rol = new Rol;

		// Añadir los campos al usuario
		$rol->id 	 = $rolEncontrado['id'];
		$rol->rol 	 = $rol['rol'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$rol->update = true;

		// Devolver el usuario solicitado
		return $rol;
	}


	// Funcion para hacer una consulta pero con condicion, retorna en forma de un arreglo de objetos
	/* Trae todos los usuarios que cumplan con la condicion en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $rols[0]->nombre
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


	// Funcion para devolver el resultado de toda la consulta que se haya hecho
	public static function resultado()
	{
		// Arreglo que va a contener todos los reportes
		$lista_roles = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = "SELECT * FROM roles " . static::$consultasDonde . static::$consultaOrdenar;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $rol = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$rolTemporal = new Rol();

			// Añadir los campos al usuario
			$rolTemporal->id 	 = $rol['id'];
			$rolTemporal->rol 	 = $rol['rol'];

			// Guarda el objeto usuario en el arreglo
			$lista_roles[] = $rolTemporal;
		}

		// Devolver todos los usuarios
		return $lista_roles;

	}




	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los reportes
		$lista_roles = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $rol = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$rolTemporal = new Rol();

			// Añadir los campos al usuario
			$rolTemporal->id 	 = $rol['id'];
			$rolTemporal->rol 	 = $rol['rol'];

			// Guarda el objeto usuario en el arreglo
			$lista_roles[] = $rolTemporal;
		}

		// Devolver todos los usuarios
		return $lista_roles;
	}




	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el usuario en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO roles VALUES (null, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				's',
				$datos['rol']
		);



		// Ejecutar la sentencia
		$sentencia->execute();
	}


	// Funcion para guardar los datos del objecto actual (Rol), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE roles SET rol= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'si',
					$this->rol,
                    $this->id
			);

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO roles VALUES (null, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					's',
					$this->rol
			);
		}


		// Ejecutar la sentencia
		$sentencia->execute();
	}





	// Funcion para eliminar usuario pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al usuario de la bd encontrado por id
		$conexion->conn->query("DELETE FROM roles WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un usuario y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del usuario actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al usuario de la bd encontrado por id
		$conexion->conn->query("DELETE FROM roles WHERE id = $id LIMIT 1");
	}


}
