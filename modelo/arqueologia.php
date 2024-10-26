<?php
require_once "pieza.php"; // Si esta clase es necesaria, mantenla
class Arqueologia extends Pieza {
    protected $table = "arqueologia"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idArqueologia;
    private $integridad_historica;
    private $estetica;
    private $material;
    private $Pieza_idPieza; // Clave foránea

    // Constructor
    public function __construct(
        $idArqueologia = null,
        $integridad_historica = null,
        $estetica = null,
        $material = null,
        $Pieza_idPieza = null
    ) {
        $this->idArqueologia = $idArqueologia;
        $this->integridad_historica = $integridad_historica;
        $this->estetica = $estetica;
        $this->material = $material;
        $this->Pieza_idPieza = $Pieza_idPieza;
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getIdArqueologia() {
        return $this->idArqueologia;
    }

    public function getIntegridadHistorica() {
        return $this->integridad_historica;
    }

    public function getEstetica() {
        return $this->estetica;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza; // Getter para la clave foránea
    }

    // Setters
    public function setIdArqueologia($idArqueologia) {
        $this->idArqueologia = $idArqueologia;
    }

    public function setIntegridadHistorica($integridad_historica) {
        $this->integridad_historica = $integridad_historica;
    }

    public function setEstetica($estetica) {
        $this->estetica = $estetica;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza; // Setter para la clave foránea
    }

    // Método para guardar un registro (INSERT o UPDATE)
    public function saveArqueologia($param) {
        $this->getConection();
    
        $exists = false;
        if (isset($param['idArqueologia']) && !empty($param['idArqueologia'])) {
            // Verificar si la arqueología ya existe
            $actualArqueologia = $this->getAllArqueologiaById($param['idArqueologia']);
    
            if ($actualArqueologia) {
                $exists = true;
                $this->idArqueologia = $actualArqueologia['idArqueologia'];
                $this->integridad_historica = $actualArqueologia['integridad_historica'];
                $this->estetica = $actualArqueologia['estetica'];
                $this->material = $actualArqueologia['material'];
                $this->Pieza_idPieza = $actualArqueologia['Pieza_idPieza'];
            }
        }
    
        // Asignar los parámetros al objeto
        if (isset($param['idArqueologia'])) {
            $this->idArqueologia = $param['idArqueologia'];
        }
        if (isset($param['integridad_historica'])) {
            $this->integridad_historica = $param['integridad_historica'];
        }
        if (isset($param['estetica'])) {
            $this->estetica = $param['estetica'];
        }
        if (isset($param['material'])) {
            $this->material = $param['material'];
        }
        if (isset($param['Pieza_idPieza'])) {
            $this->Pieza_idPieza = $param['Pieza_idPieza'];
        }
    
        // Si la arqueología ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET integridad_historica = ?, estetica = ?, material = ?, Pieza_idPieza = ? WHERE idArqueologia = ?";
            $stmt = $this->conection->prepare($sql);
            //die($sql);
            $stmt->execute([
                $this->integridad_historica, $this->estetica, $this->material, $this->Pieza_idPieza, $this->idArqueologia
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (integridad_historica, estetica, material, Pieza_idPieza) VALUES (?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            //die($sql);
            $stmt->execute([
                $this->integridad_historica, $this->estetica, $this->material, $this->Pieza_idPieza
            ]);
            $this->idArqueologia = $this->conection->lastInsertId();
        }
    
        return $this->idArqueologia;
    }
    
   // Método para obtener un registro por id
    public function getAllArqueologias() {
    $sql = "SELECT * FROM " . $this->table;
    $stmt = $this->conection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }
    
    // Método para obtener un registro por id
    public function getAllArqueologiaById($idArqueologia) {
        $sql = "SELECT * FROM " . $this->table . " WHERE idArqueologia = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idArqueologia]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para obtener registros por idPieza
    public function getAllArqueologiaByIdPieza($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
    }

    // Método para eliminar un registro por id
    public function deleteArqueologiaById($idArqueologia) {
        $sql = "DELETE FROM " . $this->table . " WHERE idArqueologia = ?";
        $stmt = $this->conection->prepare($sql);
        return $stmt->execute([$idArqueologia]); // Ejecutar la consulta y devolver el resultado
    }

    // Método para contar registros en la tabla arqueologia
    public function getCantidadArqueologia() {
        $sql = "SELECT COUNT(*) AS cantidad FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['cantidad']; // Retorna la cantidad de registros
    }
} //fin de la clase

?>

