<?php
require_once "bd.php";

class UsuarioHasPieza {
    protected $table = "usuario_has_pieza"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $usuarioIdUsuario; // Clave foránea de usuario
    private $piezaIdPieza; // Clave foránea de pieza
    private $fecha_resgistro; //
    private $ultima_actualizacion; //

    // Constructor
    public function __construct($usuarioIdUsuario = null, $piezaIdPieza = null) {
        $this->usuarioIdUsuario = $usuarioIdUsuario;
        $this->piezaIdPieza = $piezaIdPieza;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getUsuarioIdUsuario() {
        return $this->usuarioIdUsuario;
    }

    public function getPiezaIdPieza() {
        return $this->piezaIdPieza;
    }

    public function getFecha_resgistro() {
        return $this->fecha_resgistro;
    }

    public function getUltima_actualizacion() {
        return $this->ultima_actualizacion;
    }

    // Setters
    public function setUsuarioIdUsuario($usuarioIdUsuario) {
        $this->usuarioIdUsuario = $usuarioIdUsuario;
    }

    public function setPiezaIdPieza($piezaIdPieza) {
        $this->piezaIdPieza = $piezaIdPieza;
    }

    public function setFecha_resgistro($fecha_resgistro) {
        $this->fecha_resgistro = $fecha_resgistro;
    }

    public function setUltima_actualizacion($ultima_actualizacion) {
        $this->ultima_actualizacion = $ultima_actualizacion;
    }
    // Método para obtener todos los registros de la tabla usuario_has_pieza
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para obtener todos los registros de la tabla usuario_has_pieza
    public function getAllDetalles() {
    $sql = "SELECT 
    up.Usuario_idUsuario, 
    up.Pieza_idPieza, 
    up.fecha_registro,
    up.ultima_actualizacion,
    u.dni, 
    u.nombre, 
    u.apellido, 
    p.fecha_ingreso,
    p.num_inventario 

    FROM 
    usuario_has_pieza AS up
    INNER JOIN 
      usuario AS u ON u.idUsuario = up.Usuario_idUsuario 
    INNER JOIN 
    pieza AS p ON p.idPieza = up.Pieza_idPieza";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

   

    public function getPaginados($limite, $offset) {
        $sql = "SELECT * FROM " . $this->table . " LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCantidadRegistros() {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }


    // Método para obtener un registro por ID de usuario y ID de pieza
    public function getByIds($usuarioIdUsuario, $piezaIdPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Usuario_idUsuario = ? AND Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$usuarioIdUsuario, $piezaIdPieza]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el resultado de la consulta
    }

    // Método para eliminar un registro por ID de usuario y ID de pieza
    public function eliminarPorIds($usuarioIdUsuario, $piezaIdPieza) {
        $sql = "DELETE FROM " . $this->table . " WHERE Usuario_idUsuario = ? AND Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$usuarioIdUsuario, $piezaIdPieza]); // Retorna true si se eliminó correctamente
    }

    // Método para insertar o actualizar un registro
    public function saveUsuarioPieza($param) {
        $this->getConection();

        // Asignar los parámetros al objeto
        if (isset($param['Usuario_idUsuario'])) {
            $this->usuarioIdUsuario = $param['Usuario_idUsuario'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->piezaIdPieza = $param['Pieza_idPieza'];
        }

        // Verificar si ya existe el registro
        $existingRecord = $this->getByIds($this->usuarioIdUsuario, $this->piezaIdPieza);

        if ($existingRecord) {
            // Si existe, se actualiza
            $sql = "UPDATE " . $this->table . " SET Pieza_idPieza = ? WHERE Usuario_idUsuario = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->piezaIdPieza, $this->usuarioIdUsuario]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (Usuario_idUsuario, Pieza_idPieza,fecha_registro) VALUES (?, ?, current_timestamp())";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->usuarioIdUsuario, $this->piezaIdPieza]);
        }

        return true; // Retorna true al finalizar el guardado
    }

    // Método para obtener todas las piezas por ID de usuario
    public function getPiezasPorUsuario($usuarioIdUsuario) {
        $sql = "SELECT Pieza_idPieza FROM " . $this->table . " WHERE Usuario_idUsuario = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$usuarioIdUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todas las piezas asociadas al usuario
    }

    // Método para obtener todos los usuarios por ID de pieza
    public function getUsuariosPorPieza($piezaIdPieza) {
        $sql = "SELECT Usuario_idUsuario FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$piezaIdPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los usuarios asociados a la pieza
    }
} // fin de la clase

?>
