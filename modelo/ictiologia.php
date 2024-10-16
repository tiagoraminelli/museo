<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla

class Ictiologia extends Pieza {
    protected $table = "ictiologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idIctiologia;
    private $clasificacion;
    private $especies;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idIctiologia = null,
        $clasificacion = null,
        $especies = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idIctiologia = $idIctiologia;
        $this->clasificacion = $clasificacion;
        $this->especies = $especies;
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
    public function getIdIctiologia() {
        return $this->idIctiologia;
    }

    public function getClasificacion() {
        return $this->clasificacion;
    }

    public function getEspecies() {
        return $this->especies;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdIctiologia($idIctiologia) {
        $this->idIctiologia = $idIctiologia;
    }

    public function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

    public function setEspecies($especies) {
        $this->especies = $especies;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

    // Método para obtener todos los registros de la tabla ictiologia
    public function getAllIctiologias() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    // Método para obtener un registro por id
    public function getIctiologiaById($idIctiologia) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idIctiologia = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idIctiologia]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para obtener registros por idPieza
    public function getIctiologiaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deleteIctiologiaById($idIctiologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idIctiologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idIctiologia]); // Ejecutar la consulta y devolver el resultado
    }

    // Método para contar registros en la tabla ictiologia
    public function getCantidadIctiologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveIctiologia($param) {
        $this->getConection();

        $exists = false;
        if (isset($param['idIctiologia']) && !empty($param['idIctiologia'])) {
            // Verificar si el registro ya existe
            $actualIctiologia = $this->getIctiologiaById($param['idIctiologia']);

            if ($actualIctiologia) {
                $exists = true;
                $this->idIctiologia = $actualIctiologia['idIctiologia'];
                $this->clasificacion = $actualIctiologia['clasificacion'];
                $this->especies = $actualIctiologia['especies'];
                $this->descripcion = $actualIctiologia['descripcion'];
                $this->Pieza_idPieza = $actualIctiologia['Pieza_idPieza'];
            }
        }

        // Asignar los parámetros al objeto
        if (isset($param['idIctiologia'])) {
            $this->idIctiologia = $param['idIctiologia'];
        }
        if (isset($param['clasificacion'])) {
            $this->clasificacion = $param['clasificacion'];
        }
        if (isset($param['especies'])) {
            $this->especies = $param['especies'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }

        // Si el registro ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET clasificacion = ?, especies = ?, descripcion = ?, Pieza_idPieza = ? WHERE idIctiologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->clasificacion, $this->especies, $this->descripcion, $this->Pieza_idPieza, $this->idIctiologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (clasificacion, especies, descripcion, Pieza_idPieza) VALUES (?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->clasificacion, $this->especies, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idIctiologia = $this->conection->lastInsertId();
        }

        return $this->idIctiologia;
    }
}

?>
