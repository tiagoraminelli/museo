<?php
require_once "bd.php"; // Asegúrate de que este archivo contenga la clase Db

class DonadoresEliminados {
    protected $table = "donadores_eliminados"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $id;
    private $idDonante;
    private $nombre;
    private $apellido;
    private $fecha;
    private $fecha_eliminacion;

    // Constructor
    public function __construct(
        $id = null,
        $idDonante = null,
        $nombre = null,
        $apellido = null,
        $fecha = null,
        $fecha_eliminacion = null
    ) {
        $this->id = $id;
        $this->idDonante = $idDonante;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fecha = $fecha;
        $this->fecha_eliminacion = $fecha_eliminacion;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdDonante() {
        return $this->idDonante;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getFechaEliminacion() {
        return $this->fecha_eliminacion;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdDonante($idDonante) {
        $this->idDonante = $idDonante;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setFechaEliminacion($fecha_eliminacion) {
        $this->fecha_eliminacion = $fecha_eliminacion;
    }


    public function getDonadoresEliminados() { // Obtener todos los registros eliminados
        $this->getConection(); // Ejecuta un método de la clase que gestiona la conexión a la base de datos
        $sql = "SELECT * FROM " . $this->table; // Armamos la cadena SQL 
        $stmt = $this->conection->prepare($sql); // Preparamos la consulta
        $stmt->execute(); // Ejecutamos la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorno de todos los resultados de la consulta
    }

    public function getDonadorEliminadoById($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = ?"; // Asegúrate de que sea el nombre correcto de la columna
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteDonadorById($id) { // Eliminar un donador por ID
        $this->getConection(); // Ejecuta un método de la clase que gestiona la conexión a la base de datos
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?"; // Armamos la cadena SQL 
        $stmt = $this->conection->prepare($sql); // Preparamos la consulta
        return $stmt->execute([$id]); // Ejecutamos la consulta
    }

    public function getTotalDonadoresEliminados() {
        $sql = "SELECT COUNT(*) as total FROM ".$this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getAllDonadoresEliminadosPaginados($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} // Fin de la clase
?>
