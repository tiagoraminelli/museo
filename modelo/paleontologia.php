<?php

require_once "pieza.php"; // Si esta clase es necesaria, mantenla

class Paleontologia extends Pieza {
    protected $table = "paleontologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idPaleontologia;
    private $era;
    private $periodo;
    private $descripcion;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idPaleontologia = null,
        $era = null,
        $periodo = null,
        $descripcion = null,
        $Pieza_idPieza = null
    ) {
        $this->idPaleontologia = $idPaleontologia;
        $this->era = $era;
        $this->periodo = $periodo;
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
    public function getIdPaleontologia() {
        return $this->idPaleontologia;
    }

    public function getEra() {
        return $this->era;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdPaleontologia($idPaleontologia) {
        $this->idPaleontologia = $idPaleontologia;
    }

    public function setEra($era) {
        $this->era = $era;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }


    // Método para obtener todos los registros de la tabla paleontologia
    public function getAllPaleontologias() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }


     // Método para obtener un registro por id
    public function getAllPaleontologiaById($idPaleontologia) {
    $sql = "SELECT * FROM " . $this->table . " WHERE idPaleontologia = ?";
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$idPaleontologia]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }


    // Método para obtener registros por idPieza
    public function getAllPaleontologiaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deletePaleontologiaById($idPaleontologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idPaleontologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idPaleontologia]); // Ejecutar la consulta y devolver el resultado
    }

    // Método para contar registros en la tabla paleontologia
    public function getCantidadPaleontologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }




    // Método para guardar un registro (INSERT o UPDATE)
    public function savePaleontologia($param) {
        $this->getConection();
    
        $exists = false;
        if (isset($param['idPaleontologia']) && !empty($param['idPaleontologia'])) {
            // Verificar si el registro ya existe
            $actualPaleontologia = $this->getAllPaleontologiaById($param['idPaleontologia']);
    
            if ($actualPaleontologia) {
                $exists = true;
                $this->idPaleontologia = $actualPaleontologia['idPaleontologia'];
                $this->era = $actualPaleontologia['era'];
                $this->periodo = $actualPaleontologia['periodo'];
                $this->descripcion = $actualPaleontologia['descripcion'];
                $this->Pieza_idPieza = $actualPaleontologia['Pieza_idPieza'];
            }
        }
    
        // Asignar los parámetros al objeto
        if (isset($param['idPaleontologia'])) {
            $this->idPaleontologia = $param['idPaleontologia'];
        }
        if (isset($param['era'])) {
            $this->era = $param['era'];
        }
        if (isset($param['periodo'])) {
            $this->periodo = $param['periodo'];
        }
        if (isset($param['descripcion'])) {
            $this->descripcion = $param['descripcion'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }
    
        // Si el registro ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET era = ?, periodo = ?, descripcion = ?, Pieza_idPieza = ? WHERE idPaleontologia = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->era, $this->periodo, $this->descripcion, $this->Pieza_idPieza, $this->idPaleontologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (era, periodo, descripcion, Pieza_idPieza) VALUES (?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([
                $this->era, $this->periodo, $this->descripcion, $this->Pieza_idPieza
            ]);
            $this->idPaleontologia = $this->conection->lastInsertId();
        }
    
        return $this->idPaleontologia;
    }
}

?>
