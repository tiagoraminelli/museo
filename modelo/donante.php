<?php
require_once "bd.php";
require_once "pieza.php";

class Donante extends Pieza {
    protected $table = "donante"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idDonante;
    private $nombre;
    private $apellido;
    private $fecha;

    // Constructor
    public function __construct(
        $idDonante = null,
        $nombre = null,
        $apellido = null,
        $fecha = null
    ) {
        $this->idDonante = $idDonante;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fecha = $fecha;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters y Setters para todas las propiedades
    public function getIdDonante() {
        return $this->idDonante;
    }

    public function setIdDonante($idDonante) {
        $this->idDonante = $idDonante;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    // Método para obtener todos los registros de la tabla donante
    public function getAllDonantes() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

     // Método para obtener todos los registros de la tabla donante
     public function getDonanteById($id) {
        $sql = "SELECT * FROM " . $this->table." WHERE idDonante = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para obtener donantes paginados
    public function getDonantesPaginados($porPagina, $offset) {
        $sql = "SELECT * FROM " . $this->table . " LIMIT :offset, :porPagina";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':porPagina', $porPagina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener el total de donantes
    public function getTotalDonantes() {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function buscarDonantes($searchTerm) {
        $sql = "SELECT * FROM donante WHERE nombre LIKE :searchTerm OR apellido LIKE :searchTerm";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTablasRelacionadasConDonante($idDonante) {
        $sql = "SELECT * FROM pieza WHERE Donante_idDonante = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idDonante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  

    public function save($param) {
        $this->getConection();
    
        $exists = false;
        if (isset($param['idDonante']) && !empty($param['idDonante'])) {
            // Verificar si el donante ya existe
            $actualDonante = $this->getDonanteById($param['idDonante']);
    
            if ($actualDonante) {
                $exists = true;
                $this->idDonante = $actualDonante['idDonante'];
                $this->nombre = $actualDonante['nombre'];
                $this->apellido = $actualDonante['apellido'];
                $this->fecha = $actualDonante['fecha'];
            }
        }
    
        // Asignar los parámetros al objeto
        if (isset($param['idDonante'])) {
            $this->idDonante = $param['idDonante'];
        }
        if (isset($param['nombre'])) {
            $this->nombre = $param['nombre'];
        }
        if (isset($param['apellido'])) {
            $this->apellido = $param['apellido'];
        }
        if (isset($param['fecha'])) {
            $this->fecha = $param['fecha'];
        }
    
        // Si el donante ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE ".$this->table." SET nombre = ?, apellido = ?, fecha = ? WHERE idDonante = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->nombre, $this->apellido, $this->fecha, $this->idDonante]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO ".$this->table." (nombre, apellido, fecha) VALUES (?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->nombre, $this->apellido, $this->fecha]);
            $this->idDonante = $this->conection->lastInsertId();
        }
    
        return $this->idDonante;
    }
    




} // Fin de la clase 
?>
