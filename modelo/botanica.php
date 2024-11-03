<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla
class Botanica extends Pieza {
    protected $table = "botanica"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idBotanica;
    private $reino;
    private $familia;
    private $especie;
    private $orden;
    private $division;
    private $clase;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idBotanica = null,
        $reino = null,
        $familia = null,
        $especie = null,
        $orden = null,
        $division = null,
        $clase = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idBotanica = $idBotanica;
        $this->reino = $reino;
        $this->familia = $familia;
        $this->especie = $especie;
        $this->orden = $orden;
        $this->division = $division;
        $this->clase = $clase;
        $this->descripcion = $descripcion;
        $this->Pieza_idPieza = $Pieza_idPieza;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getIdBotanica() {
        return $this->idBotanica;
    }

    public function getReino() {
        return $this->reino;
    }

    public function getFamilia() {
        return $this->familia;
    }

    public function getEspecie() {
        return $this->especie;
    }

    public function getOrden() {
        return $this->orden;
    }

    public function getDivision() {
        return $this->division;
    }

    public function getClase() {
        return $this->clase;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdBotanica($idBotanica) {
        $this->idBotanica = $idBotanica;
    }

    public function setReino($reino) {
        $this->reino = $reino;
    }

    public function setFamilia($familia) {
        $this->familia = $familia;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }

    public function setOrden($orden) {
        $this->orden = $orden;
    }

    public function setDivision($division) {
        $this->division = $division;
    }

    public function setClase($clase) {
        $this->clase = $clase;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }


    // Método para obtener un registro por id
    public function getAllBotanicaById($idBotanica) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idBotanica = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idBotanica]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    
    // Método para obtener todos los registros de la tabla botanica
    public function getAllBotanicas() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveBotanica($param) {
        $this->getConection();

        $exists = false;
        if (isset($param['idBotanica']) && !empty($param['idBotanica'])) {
            // Verificar si la botánica ya existe
            $actualBotanica = $this->getAllBotanicaById($param['idBotanica']);
    
            if ($actualBotanica) {
                $exists = true;
                $this->idBotanica = $actualBotanica['idBotanica'];
                $this->reino = $actualBotanica['reino'];
                $this->familia = $actualBotanica['familia'];
                $this->especie = $actualBotanica['especie'];
                $this->orden = $actualBotanica['orden'];
                $this->division = $actualBotanica['division'];
                $this->clase = $actualBotanica['clase'];
                $this->descripcion = $actualBotanica['descripcion'];
                $this->Pieza_idPieza = $actualBotanica['Pieza_idPieza'];
            }
        }

        // Asignar los parámetros al objeto
        if (isset($param['idBotanica'])) {
            $this->idBotanica = $param['idBotanica'];
        }
        if (isset($param['reino'])) {
            $this->reino = $param['reino'];
        }
        if (isset($param['familia'])) {
            $this->familia = $param['familia'];
        }
        if (isset($param['especie'])) {
            $this->especie = $param['especie'];
        }
        if (isset($param['orden'])) {
            $this->orden = $param['orden'];
        }
        if (isset($param['division'])) {
            $this->division = $param['division'];
        }
        if (isset($param['clase'])) {
            $this->clase = $param['clase'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }

        // Si la botánica ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET reino = ?, familia = ?, especie = ?, orden = ?, division = ?, clase = ?, descripcion = ?, Pieza_idPieza = ? WHERE idBotanica = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->reino, $this->familia, $this->especie, $this->orden, $this->division, $this->clase, $this->descripcion, $this->Pieza_idPieza, $this->idBotanica
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (reino, familia, especie, orden, division, clase, descripcion, Pieza_idPieza) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->reino, $this->familia, $this->especie, $this->orden, $this->division, $this->clase, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idBotanica = $this->conection->lastInsertId();
        }

        return $this->idBotanica;
    }


    // Método para obtener registros por idPieza
    public function getAllBotanicaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deleteBotanicaById($idBotanica) {
        $sql = "DELETE FROM " . $this->table . " WHERE idBotanica = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idBotanica]); // Ejecuta la eliminación y retorna el resultado
    }

    // Método para contar registros
    public function getCantidadBotanica() {
        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retorna la cantidad de registros
    }

    public function getBotanicasPaginadas($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarBotanicas($search) {
        // Definir la consulta SQL con búsqueda en varios campos
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE idBotanica LIKE :search 
                OR reino LIKE :search 
                OR familia LIKE :search 
                OR especie LIKE :search 
                OR orden LIKE :search 
                OR division LIKE :search 
                OR clase LIKE :search 
                OR descripcion LIKE :search 
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
    
}
