<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla
class Geologia extends Pieza {
    protected $table = "geologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idGeologia;
    private $tipo_rocas;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idGeologia = null,
        $tipo_rocas = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idGeologia = $idGeologia;
        $this->tipo_rocas = $tipo_rocas;
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
    public function getIdGeologia() {
        return $this->idGeologia;
    }

    public function getTipoRocas() {
        return $this->tipo_rocas;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdGeologia($idGeologia) {
        $this->idGeologia = $idGeologia;
    }

    public function setTipoRocas($tipo_rocas) {
        $this->tipo_rocas = $tipo_rocas;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

     // Método para todas la piezas
     public function getAllGeologias() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveGeologia($param) {
        $this->getConection();

        $exists = false;
        if (isset($param['idGeologia']) && !empty($param['idGeologia'])) {
            // Verificar si la geología ya existe
            $actualGeologia = $this->getAllGeologiaById($param['idGeologia']);
    
            if ($actualGeologia) {
                $exists = true;
                $this->idGeologia = $actualGeologia['idGeologia'];
                $this->tipo_rocas = $actualGeologia['tipo_rocas'];
                $this->descripcion = $actualGeologia['descripcion'];
                $this->Pieza_idPieza = $actualGeologia['Pieza_idPieza'];
            }
        }

        // Asignar los parámetros al objeto
        if (isset($param['idGeologia'])) {
            $this->idGeologia = $param['idGeologia'];
        }
        if (isset($param['tipo_rocas'])) {
            $this->tipo_rocas = $param['tipo_rocas'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }

        // Si la geología ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET tipo_rocas = ?, descripcion = ?, Pieza_idPieza = ? WHERE idGeologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->tipo_rocas, $this->descripcion, $this->Pieza_idPieza, $this->idGeologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (tipo_rocas, descripcion, Pieza_idPieza) VALUES (?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->tipo_rocas, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idGeologia = $this->conection->lastInsertId();
        }

        return $this->idGeologia;
    }

    // Método para obtener un registro por id
    public function getAllGeologiaById($idGeologia) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idGeologia = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idGeologia]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para obtener registros por idPieza
    public function getAllGeologiaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deleteGeologiaById($idGeologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idGeologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idGeologia]); // Ejecutar la consulta y devolver el resultado
    }

    // Método para contar registros en la tabla geologia
    public function getCantidadGeologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }
    public function getGeologiasPaginadas($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarGeologias($search) {
        // Definir la consulta SQL con búsqueda en varios campos
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE idGeologia LIKE :search 
                OR tipo_rocas LIKE :search 
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
?>
