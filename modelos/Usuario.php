<?php

require_once '../configuracion/conexion_db.php';

/**
 * Modelo para el acceso a la base de datos y funciones CRUD (Usuarios)
 * Conexion mysqli
 *
 */
class Usuario
{

	// Variables, campos de referencia con la tabla usuarios
	public $id;
	public $apellido;
	public $cedula;
	public $celular;
	public $ciudad;
	public $contrasena;
	public $correo;
	public $direccion;
	public $nombre;
	public $rol_id;
	public $rol;

	// Comprobar si es un nuevo registro o uno ya existente para hacerle update
	public $update = false;


	// Variable para acomular las sentencias WHERE de sql, que se desean efectuar
	public static $consultasDonde = '';
	// Variable para comprobar si solo paso una sentencia WHERE de sql o mas de una
	public static $numeroConsultasDonde = 0;


	// Variable para aplicar Join
	public static $consultaJoin = '';


	// Para especificar una consulta select
	public static $consultaSelect = 'SELECT * FROM usuarios ';


	// Para especificar un limite
	public static $consultaLimite = '';


	// Variable para comprobar si se desea ordenar, utilizando ORDER BY de sql
	public static $consultaOrdenar = '';



	// Funcion para enviar todos los usuarios de la bd en forma de un arreglo de objetos
	/* Trae todos los usuarios en forma de arreglo
	 * Para acceder a los campos, es de la siguiente manera $usuarios[0]->nombre
	*/
	public static function todos()
	{
		// Arreglo que va a contener todos los usuarios
		$lista_usuarios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query('SELECT * FROM usuarios');


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $usuario = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$usuarioTemporal = new Usuario();

			// Añadir los campos al usuario
			$usuarioTemporal->id 	 	 = $usuario['id'];
			$usuarioTemporal->apellido 	 = $usuario['apellido'];
			$usuarioTemporal->cedula	 = $usuario['cedula'];
			$usuarioTemporal->celular 	 = $usuario['celular'];
			$usuarioTemporal->ciudad 	 = $usuario['ciudad'];
			$usuarioTemporal->contrasena = $usuario['contrasena'];
			$usuarioTemporal->correo 	 = $usuario['correo'];
			$usuarioTemporal->direccion	 = $usuario['direccion'];
			$usuarioTemporal->nombre 	 = $usuario['nombre'];
			$usuarioTemporal->rol_id 	 = $usuario['rol_id'];

			// Guarda el objeto usuario en el arreglo
			$lista_usuarios[] = $usuarioTemporal;
		}

		// Devolver todos los usuarios
		return $lista_usuarios;

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
		$resultado = $conexion->conn->query("SELECT * FROM usuarios where id = $id LIMIT 1");

		// Guardar el usuario encontrado por id en la variable
		$usuarioEncontrado = $resultado->fetch_assoc();


		// Crear un usario
		$usuario = new Usuario;

		// Añadir los campos al usuario
		$usuario->id 	 	 = $usuarioEncontrado['id'];
		$usuario->apellido 	 = $usuarioEncontrado['apellido'];
		$usuario->cedula	 = $usuarioEncontrado['cedula'];
		$usuario->celular 	 = $usuarioEncontrado['celular'];
		$usuario->ciudad 	 = $usuarioEncontrado['ciudad'];
		$usuario->contrasena = $usuarioEncontrado['contrasena'];
		$usuario->correo 	 = $usuarioEncontrado['correo'];
		$usuario->direccion	 = $usuarioEncontrado['direccion'];
		$usuario->nombre 	 = $usuarioEncontrado['nombre'];
		$usuario->rol_id 	 = $usuarioEncontrado['rol_id'];

		// Si se llama este metodo cambiara la variable de update, ya que cuando se utilice la funcion guardar(), hara un update
		$usuario->update = true;

		// Devolver el usuario solicitado
		return $usuario;
	}


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


	// Funcion para escoger los campos para la consulta
	public static function seleccionar($campos)
	{
		// A la variable global se le asigna que campos va a traer para la consulta
		static::$consultaSelect = "SELECT $campos FROM usuarios";

		// Se devuelve el objeto
		return new static;
	}


	// Funcion para unir la tabla usuarios con la que se especifique
	public static function unir($tabla, $campoReferencia, $campoOriginal)
	{
		// A la variable global se le asigna traer los datos de la tabla roles para la consulta
		static::$consultaJoin = " INNER JOIN $tabla ON usuarios.$campoReferencia = $tabla.$campoOriginal ";

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
		$lista_usuarios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Variable que contiene la sentencia sql, uniendo si se uso la funcion donde y tambien ordenar
		$sql = static::$consultaSelect . static::$consultasDonde . static::$consultaJoin . static::$consultaOrdenar . static::$consultaLimite;


		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $usuario = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$usuarioTemporal = new Usuario();

			// Añadir los campos al usuario
			$usuarioTemporal->id 	 	 = ( isset($usuario['id']) ? $usuario['id'] : '');
			$usuarioTemporal->apellido 	 = ( isset($usuario['apellido']) ? $usuario['apellido'] : '');
			$usuarioTemporal->cedula	 = ( isset($usuario['cedula']) ? $usuario['cedula'] : '');
			$usuarioTemporal->celular 	 = ( isset($usuario['celular']) ? $usuario['celular'] : '');
			$usuarioTemporal->ciudad 	 = ( isset($usuario['ciudad']) ? $usuario['ciudad'] : '');
			$usuarioTemporal->contrasena = ( isset($usuario['contrasena']) ? $usuario['contrasena'] : '');
			$usuarioTemporal->correo 	 = ( isset($usuario['correo']) ? $usuario['correo'] : '');
			$usuarioTemporal->direccion	 = ( isset($usuario['direccion']) ? $usuario['direccion'] : '');
			$usuarioTemporal->nombre 	 = ( isset($usuario['nombre']) ? $usuario['nombre'] : '');
			$usuarioTemporal->rol_id 	 = ( isset($usuario['rol_id']) ? $usuario['rol_id'] : '');

			$usuarioTemporal->rol = ( isset($usuario['rol']) ? $usuario['rol'] : '' );


			// Guarda el objeto usuario en el arreglo
			$lista_usuarios[] = $usuarioTemporal;
		}



		// Restaurar las variables estaticas
		static::$consultasDonde = '';
		static::$numeroConsultasDonde = 0;
		static::$consultaJoin = '';
		static::$consultaSelect = 'SELECT * FROM usuarios ';
		static::$consultaOrdenar = '';
		static::$consultaLimite = '';


		// Devolver todos los usuarios
		return $lista_usuarios;

	}




	// Funcion para hacer una consulta sql propia, como parametros recive el string con la consulta sql
	public static function consulta($sql)
	{
		// Arreglo que va a contener todos los reportes
		$lista_usuarios = [];


		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Consulta para la base de datos y despues lo guarda en la variable
		$resultado = $conexion->conn->query($sql);


		// Recorrer todos los usuarios que llegaron de la bd
		while ( $usuario = $resultado->fetch_assoc() ) {

			// Crear un usario temporal en cada vuelta
			$usuarioTemporal = new Usuario();

			// Añadir los campos al usuario
			$usuarioTemporal->id 	 	 = $usuario['id'];
			$usuarioTemporal->apellido 	 = $usuario['apellido'];
			$usuarioTemporal->cedula	 = $usuario['cedula'];
			$usuarioTemporal->celular 	 = $usuario['celular'];
			$usuarioTemporal->ciudad 	 = $usuario['ciudad'];
			$usuarioTemporal->contrasena = $usuario['contrasena'];
			$usuarioTemporal->correo 	 = $usuario['correo'];
			$usuarioTemporal->direccion	 = $usuario['direccion'];
			$usuarioTemporal->nombre 	 = $usuario['nombre'];
			$usuarioTemporal->rol_id 	 = $usuario['rol_id'];

			// Guarda el objeto usuario en el arreglo
			$lista_usuarios[] = $usuarioTemporal;
		}

		// Devolver todos los usuarios
		return $lista_usuarios;
	}




	// Funcion para insertar un usuario sin tener que instanciar la clase
	public static function crear($datos)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Preparar la sentencia para isertar el usuario en la bd
		$sentencia = $conexion->conn->prepare("INSERT INTO usuarios VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		// Pasar los campos del arreglo a la sentencia
		$sentencia->bind_param(
				'sissssssi',
				$datos['apellido'],
				$datos['cedula'],
				$datos['celular'],
				$datos['ciudad'],
				$datos['contrasena'],
				$datos['correo'],
				$datos['direccion'],
				$datos['nombre'],
				$datos['rol_id']
		);



		// Ejecutar la sentencia
		$sentencia->execute();
	}


	// Funcion para guardar los datos del objecto actual (Usuario), ya sea actualizar o guardar uno nuevo
	public function guardar()
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;

		// Comprobar si es un registro nuevo o uno ya existente
		if ($this->update) {

			// Preparar la sentencia para actualizar el usuario en la bd
			$sentencia = $conexion->conn->prepare("UPDATE usuarios SET apellido= ?, cedula= ?, celular= ?, ciudad= ?, contrasena= ?, correo= ?, direccion= ?, nombre= ?, rol_id= ? WHERE id= ?");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'sissssssii',
					$this->apellido,
					$this->cedula,
					$this->celular,
					$this->ciudad,
					$this->contrasena,
					$this->correo,
					$this->direccion,
					$this->nombre,
					$this->rol_id,
					$this->id
			);

		} else {

			// Preparar la sentencia para isertar el usuario en la bd
			$sentencia = $conexion->conn->prepare("INSERT INTO usuarios VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			// Pasar los campos del objecto a la sentencia
			$sentencia->bind_param(
					'sissssssi',
					$this->apellido,
					$this->cedula,
					$this->celular,
					$this->ciudad,
					$this->contrasena,
					$this->correo,
					$this->direccion,
					$this->nombre,
					$this->rol_id
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





	// Funcion para eliminar usuario pasando el id directamente
	public static function eliminarPorID($id)
	{
		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al usuario de la bd encontrado por id
		$conexion->conn->query("DELETE FROM usuarios WHERE id = $id LIMIT 1");
	}


	// Funcion para eliminar despues de que se haya buscado un usuario y se tenga en una variable
	public function eliminar()
	{
		// Toma el id del usuario actual
		$id = $this->id;


		// Crear una instancia de la conexion
		$conexion = new Conexion;


		// Elimina al usuario de la bd encontrado por id
		$conexion->conn->query("DELETE FROM usuarios WHERE id = $id LIMIT 1");
	}


}
