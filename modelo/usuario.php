<?php
require_once "bd.php"; // Asegúrate de que este archivo contenga la clase Db
require_once "pieza.php"; // Supongo que esta clase sigue siendo necesaria

class Usuario {
    protected $table = "usuario"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idUsuario;
    private $dni;
    private $nombre;
    private $apellido;
    private $email;
    private $clave;
    private $fecha_alta;
    private $tipo_de_usuario; // Nuevo campo

    // Constructor
    public function __construct(
        $idUsuario = null,
        $dni = null,
        $nombre = null,
        $apellido = null,
        $email = null,
        $clave = null,
        $fecha_alta = null,
        $tipo_de_usuario = null // Nuevo parámetro
    ) {
        $this->idUsuario = $idUsuario;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->clave = $clave;
        $this->fecha_alta = $fecha_alta;
        $this->tipo_de_usuario = $tipo_de_usuario; // Inicializa el nuevo campo
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getFechaAlta() {
        return $this->fecha_alta;
    }

    public function getTipoDeUsuario() {
        return $this->tipo_de_usuario; // Getter para el nuevo campo
    }

    // Setters
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setFechaAlta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }

    public function setTipoDeUsuario($tipo_de_usuario) {
        $this->tipo_de_usuario = $tipo_de_usuario; // Setter para el nuevo campo
    }


    public function getUsuarios(){ //creamos la conexion a la tabla
        $this->getConection(); //ejecuta un metodo de la clase que gestiona la conexion a la base de datos
        $sql="SELECT * FROM ".$this->table; //armamos la cadena sql 
        $stmt=$this->conection->prepare($sql); //metemos la cadena que armamos para armar la consulta
        $stmt->execute(); //ejecutamos la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno de todos los resultados de la consulta
    
    }
    

    public function existeDni($dni, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE dni = ?";
        $params = [$dni];
        
        if ($excluirId !== null) {
            $sql .= " AND idUsuario != ?";
            $params[] = $excluirId;
        }
        
        $stmt = $this->conection->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] > 0;
    }
    
    /**
     * Verifica si un email ya existe (excluyendo al usuario actual)
     * @param string $email Email a verificar
     * @param int|null $excluirId ID de usuario a excluir (para edición)
     * @return bool True si el email ya existe
     */
    public function existeEmail($email, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE email = ?";
        $params = [$email];
        
        if ($excluirId !== null) {
            $sql .= " AND idUsuario != ?";
            $params[] = $excluirId;
        }
        
        $stmt = $this->conection->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] > 0;
    }
    
    /**
     * Obtiene un usuario por su DNI
     * @param string $dni DNI del usuario
     * @return array|null Datos del usuario o null si no existe
     */
    public function getUsuarioPorDNI($dni) {
        $sql = "SELECT * FROM " . $this->table . " WHERE dni = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$dni]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsuariosById($id){
        $sql = "SELECT * FROM " . $this->table . " WHERE idUsuario = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    
    /**
     * Obtiene un usuario por su email
     * @param string $email Email del usuario
     * @return array|null Datos del usuario o null si no existe
     */
    public function getUsuarioPorEmail($email) {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUsuariosById($id){ //empieza la funtion
        $this->getConection(); //ejecuta un metodo de la clase que gestiona la conexion a la base de datos
        $sql="DELETE FROM ".$this->table." WHERE `idUsuario` = ? "; //armamos la cadena sql 
        $stmt=$this->conection->prepare($sql); //metemos la cadena que armamos para armar la consulta
        return $stmt->execute([$id]); //ejecutamos la consulta
    }public function buscarUsuario($search, $exactMatch = false) {
        // Definir la consulta SQL base
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE dni LIKE :search 
                OR nombre LIKE :search 
                OR apellido LIKE :search 
                OR email LIKE :search 
                OR fecha_alta LIKE :search
                OR tipo_de_usuario LIKE :search";
        
        // Preparar el término de búsqueda
        $searchTerm = $exactMatch ? $search : '%' . $search . '%';
        
        // Preparar la consulta
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        
        // Ejecutar y retornar resultados
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($param) {
        $this->getConection();

        // Check if user exists
        $exists = FALSE;
        if (isset($param['idUsuario']) && ($param['idUsuario'] != "")) {
            $ActualInstancia = $this->getUsuariosById($param['idUsuario']);
            
            if ($ActualInstancia) {
                $exists = TRUE; // User exists
                $this->idUsuario = $ActualInstancia['idUsuario'];
                $this->dni = $ActualInstancia['dni'];
                $this->nombre = $ActualInstancia['nombre'];
                $this->apellido = $ActualInstancia['apellido'];
                $this->email = $ActualInstancia['email'];
                $this->tipo_de_usuario = $ActualInstancia['tipo_de_usuario'];
                $this->clave = $ActualInstancia['clave'];
            }
        }

        // Assign values from the parameters
        if (isset($param['dni'])) {
            $this->dni = $param['dni'];
        }
        if (isset($param['nombre'])) {
            $this->nombre = $param['nombre'];
        }
        if (isset($param['apellido'])) {
            $this->apellido = $param['apellido'];
        }
        if (isset($param['email'])) {
            $this->email = $param['email'];
        }
        if (isset($param['clave'])) {
            // Hash the password before saving
            $this->clave = password_hash($param['clave'], PASSWORD_DEFAULT);
        }

        if (!isset($param['fecha_alta'])) {
            $this->fecha_alta = date('Y-m-d');
        }
        if (isset($param['tipo_de_usuario'])) {
            $this->tipo_de_usuario = $param['tipo_de_usuario'];
        }

//echo "INSERT INTO `usuario` (`dni`, `nombre`, `apellido`, `email`, `clave`,`fecha_alta`,`tipo_de_usuario``) VALUES ($this->dni,$this->nombre,$this->apellido,$this->email,$this->clave,$this->fecha_alta,$this->tipo_de_usuario)"."<br>";


        // Insert or update logic
        if ($exists) {
            $sql = "UPDATE `usuario` SET `dni` = ?, `nombre` = ?, `apellido` = ?, `email` = ?,`tipo_de_usuario`= ?, `clave` = ? WHERE `idUsuario` = ?";
            $stmt = $this->conection->prepare($sql);
            
            ///
            // echo "SQL a ejecutar: " . $sql . "<br>";
            // echo "Valores: <br>";
            // echo "dni: " . htmlspecialchars($this->dni) . "<br>";
            // echo "nombre: " . htmlspecialchars($this->nombre) . "<br>";
            // echo "apellido: " . htmlspecialchars($this->apellido) . "<br>";
            // echo "email: " . htmlspecialchars($this->email) . "<br>";
            // echo "tipo_de_usuario: " . htmlspecialchars($this->tipo_de_usuario) . "<br>";
            // echo "clave: " . (!empty($this->clave) ? "[contraseña no mostrada]" : "vacía") . "<br>";
            // echo "idUsuario: " . htmlspecialchars($this->idUsuario) . "<br>";
            // //
            //die($sql);
            $stmt->execute([
                $this->dni, $this->nombre, $this->apellido, $this->email, $this->tipo_de_usuario, $this->clave, $this->idUsuario
            ]);
        } else {
            $sql = "INSERT INTO `usuario` (`dni`, `nombre`, `apellido`, `email`, `clave`, `fecha_alta`, `tipo_de_usuario`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            //die($sql);
            $stmt->execute([
                $this->dni, $this->nombre, $this->apellido, $this->email, $this->clave,$this->fecha_alta,$this->tipo_de_usuario
            ]);
            $this->idUsuario = $this->conection->lastInsertId(); // Get the generated ID
        }

        return $this->idUsuario;
    }

    /**
 * Recupera una lista paginada de usuarios de la base de datos.
*
* @param int $limite La cantidad máxima de usuarios que se devolverán.
* @param int $offset La cantidad de usuarios que se omitirán antes de comenzar a recopilar el conjunto de resultados.
* @return array Una matriz asociativa que contiene los usuarios paginados.
     */

    public function getUsuariosPaginados($limite, $offset) {
        $sql = "SELECT * FROM usuario LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCantidadUsuarios() {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
} //fin de la clase

/*
'test@example.us'
'mysecretpassword'
*/
?>


