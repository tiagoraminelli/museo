<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla

class Osteologia extends Pieza {
    protected $table = "osteologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idOsteologia;
    private $especie;
    private $clasificacion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idOsteologia = null,
        $especie = null,
        $clasificacion = null,
        $Pieza_idPieza = null
    ) {
        $this->idOsteologia = $idOsteologia;
        $this->especie = $especie;
        $this->clasificacion = $clasificacion;
        $this->Pieza_idPieza = $Pieza_idPieza;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getIdOsteologia() {
        return $this->idOsteologia;
    }

    public function getEspecie() {
        return $this->especie;
    }

    public function getClasificacion() {
        return $this->clasificacion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdOsteologia($idOsteologia) {
        $this->idOsteologia = $idOsteologia;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }

    public function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

    // Método para obtener todos los registros de la tabla osteologia
    public function getAllOsteologias() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para obtener un registro por id
    public function getOsteologiaById($idOsteologia) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idOsteologia = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idOsteologia]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveOsteologia($param) {
        $this->getConection();
    
        $exists = false;
        if (isset($param['idOsteologia']) && !empty($param['idOsteologia'])) {
            // Verificar si la osteología ya existe
            $actualOsteologia = $this->getOsteologiaById($param['idOsteologia']);
    
            if ($actualOsteologia) {
                $exists = true;
                $this->idOsteologia = $actualOsteologia['idOsteologia'];
                $this->especie = $actualOsteologia['especie'];
                $this->clasificacion = $actualOsteologia['clasificacion'];
                $this->Pieza_idPieza = $actualOsteologia['Pieza_idPieza'];
            }
        }
    
        // Asignar los parámetros al objeto
        if (isset($param['idOsteologia'])) {
            $this->idOsteologia = $param['idOsteologia'];
        }
        if (isset($param['especie'])) {
            $this->especie = $param['especie'];
        }
        if (isset($param['clasificacion'])) {
            $this->clasificacion = $param['clasificacion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }
    
        // Si la osteología ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET especie = ?, clasificacion = ?, Pieza_idPieza = ? WHERE idOsteologia = ?";
            //die($sql);
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->especie, $this->clasificacion, $this->Pieza_idPieza, $this->idOsteologia]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (especie, clasificacion, Pieza_idPieza) VALUES (?, ?, ?)";
            //die($sql);
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$this->especie, $this->clasificacion, $this->Pieza_idPieza]);
            $this->idOsteologia = $this->conection->lastInsertId();
        }
    
        return $this->idOsteologia;
    }

    // Método para obtener registros por idPieza
    public function getOsteologiaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deleteOsteologiaById($idOsteologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idOsteologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idOsteologia]); // Ejecutar la consulta y devolver el resultado
    }

    // Método para contar registros en la tabla osteologia
    public function getCantidadOsteologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }

    public function buscarOsteologias($search) {
        // Definir la consulta SQL con búsqueda en varios campos
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE idOsteologia LIKE :search 
                OR especie LIKE :search 
                OR clasificacion LIKE :search 
                OR Pieza_idPieza LIKE :search";
        // Preparar la consulta
        $stmt = $this->conection->prepare($sql);
        
        // Vincular el parámetro de búsqueda con comodines '%' para búsqueda parcial
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Retornar los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getOsteologiasPaginadas($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
} //fin de la clase
?>
