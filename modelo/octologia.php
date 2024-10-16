<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla

class Octologia extends Pieza {
    protected $table = "octologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idOctologia;
    private $clasificacion;
    private $tipo;
    private $especie;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idOctologia = null,
        $clasificacion = null,
        $tipo = null,
        $especie = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idOctologia = $idOctologia;
        $this->clasificacion = $clasificacion;
        $this->tipo = $tipo;
        $this->especie = $especie;
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
    public function getIdOctologia() {
        return $this->idOctologia;
    }

    public function getClasificacion() {
        return $this->clasificacion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getEspecie() {
        return $this->especie;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdOctologia($idOctologia) {
        $this->idOctologia = $idOctologia;
    }

    public function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

    // Método para obtener un registro por id
    public function getAllOctologiaById($idOctologia) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idOctologia = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idOctologia]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para obtener todos los registros de la tabla octologia
    public function getAllOctologias() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveOctologia($param) {
        $this->getConection();

        $exists = false;
        if (isset($param['idOctologia']) && !empty($param['idOctologia'])) {
            // Verificar si la octología ya existe
            $actualOctologia = $this->getAllOctologiaById($param['idOctologia']);

            if ($actualOctologia) {
                $exists = true;
                $this->idOctologia = $actualOctologia['idOctologia'];
                $this->clasificacion = $actualOctologia['clasificacion'];
                $this->tipo = $actualOctologia['tipo'];
                $this->especie = $actualOctologia['especie'];
                $this->descripcion = $actualOctologia['descripcion'];
                $this->Pieza_idPieza = $actualOctologia['Pieza_idPieza'];
            }
        }

        // Asignar los parámetros al objeto
        if (isset($param['idOctologia'])) {
            $this->idOctologia = $param['idOctologia'];
        }
        if (isset($param['clasificacion'])) {
            $this->clasificacion = $param['clasificacion'];
        }
        if (isset($param['tipo'])) {
            $this->tipo = $param['tipo'];
        }
        if (isset($param['especie'])) {
            $this->especie = $param['especie'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }

        // Si la octología ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET clasificacion = ?, tipo = ?, especie = ?, descripcion = ?, Pieza_idPieza = ? WHERE idOctologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->clasificacion, $this->tipo, $this->especie, $this->descripcion, $this->Pieza_idPieza, $this->idOctologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (clasificacion, tipo, especie, descripcion, Pieza_idPieza) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->clasificacion, $this->tipo, $this->especie, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idOctologia = $this->conection->lastInsertId();
        }

        return $this->idOctologia;
    }

    // Método para eliminar un registro por id
    public function deleteOctologiaById($idOctologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idOctologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idOctologia]); // Ejecuta la eliminación y retorna el resultado
    }

    // Método para contar registros
    public function countOctologias() {
        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retorna la cantidad de registros
    }
}
?>
