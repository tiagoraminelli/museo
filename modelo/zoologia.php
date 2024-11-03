<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla
class Zoologia extends Pieza {
    protected $table = "zoologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idZoologia;
    private $reino;
    private $familia;
    private $especie;
    private $orden;
    private $phylum;
    private $clase;
    private $genero;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idZoologia = null,
        $reino = null,
        $familia = null,
        $especie = null,
        $orden = null,
        $phylum = null,
        $clase = null,
        $genero = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idZoologia = $idZoologia;
        $this->reino = $reino;
        $this->familia = $familia;
        $this->especie = $especie;
        $this->orden = $orden;
        $this->phylum = $phylum;
        $this->clase = $clase;
        $this->genero = $genero;
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
    public function getIdZoologia() {
        return $this->idZoologia;
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

    public function getPhylum() {
        return $this->phylum;
    }

    public function getClase() {
        return $this->clase;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdZoologia($idZoologia) {
        $this->idZoologia = $idZoologia;
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

    public function setPhylum($phylum) {
        $this->phylum = $phylum;
    }

    public function setClase($clase) {
        $this->clase = $clase;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

        // Método para obtener un registro por id
        public function getAllZoologias() {
            $sql = "SELECT * FROM " . $this->table;
            $stmt = $this->conection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
        }
    
        // Método para obtener un registro por id
        public function getAllZoologiaById($idZoologia) {
            $sql = "SELECT * FROM " . $this->table . " WHERE idZoologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$idZoologia]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
        }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveZoologia($param) {
        $this->getConection();
        
        $exists = false;
        if (isset($param['idZoologia']) && !empty($param['idZoologia'])) {
            // Verificar si la zoología ya existe
            $actualZoologia = $this->getAllZoologiaById($param['idZoologia']);
    
            if ($actualZoologia) {
                $exists = true;
                $this->idZoologia = $actualZoologia['idZoologia'];
                $this->reino = $actualZoologia['reino'];
                $this->familia = $actualZoologia['familia'];
                $this->especie = $actualZoologia['especie'];
                $this->orden = $actualZoologia['orden'];
                $this->phylum = $actualZoologia['phylum'];
                $this->clase = $actualZoologia['clase'];
                $this->genero = $actualZoologia['genero'];
                $this->descripcion = $actualZoologia['descripcion'];
                $this->Pieza_idPieza = $actualZoologia['Pieza_idPieza'];
            }
        }
        
        // Asignar los parámetros al objeto
        if (isset($param['idZoologia'])) {
            $this->idZoologia = $param['idZoologia'];
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
        if (isset($param['phylum'])) {
            $this->phylum = $param['phylum'];
        }
        if (isset($param['clase'])) {
            $this->clase = $param['clase'];
        }
        if (isset($param['genero'])) {
            $this->genero = $param['genero'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }

        // Si la zoología ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET reino = ?, familia = ?, especie = ?, orden = ?, phylum = ?, clase = ?, genero = ?, descripcion = ?, Pieza_idPieza = ? WHERE idZoologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->reino, $this->familia, $this->especie, $this->orden, $this->phylum, $this->clase, $this->genero, $this->descripcion, $this->Pieza_idPieza, $this->idZoologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (reino, familia, especie, orden, phylum, clase, genero, descripcion, Pieza_idPieza) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->reino, $this->familia, $this->especie, $this->orden, $this->phylum, $this->clase, $this->genero, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idZoologia = $this->conection->lastInsertId();
        }

        return $this->idZoologia; // Retorna el ID de la zoología guardada
    }

    // Método para obtener registros por idPieza
    public function getZoologiasByPiezaId($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro
    public function deleteZoologia($idZoologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idZoologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idZoologia]); // Retorna true si se eliminó correctamente
    }

    public function getCantidadZoologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }

    public function getZoologiasPaginadas($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarZoologias($search) {
        // Definir la consulta SQL con búsqueda en varios campos
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE idZoologia LIKE :search 
                OR reino LIKE :search 
                OR familia LIKE :search 
                OR especie LIKE :search 
                OR orden LIKE :search 
                OR phylum LIKE :search 
                OR clase LIKE :search 
                OR genero LIKE :search 
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
