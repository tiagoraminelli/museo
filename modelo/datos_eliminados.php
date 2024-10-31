<?php

require_once "pieza.php"; // Clase padre

class DatosEliminados extends Pieza {
    protected $table = "datos_eliminados"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    private $id;
    private $Pieza_idPieza;
    private $IdClasificacion;
    private $Tabla; // Nuevo campo agregado
    private $campo1;
    private $campo2;
    private $campo3;
    private $campo4;
    private $campo5;
    private $campo6;
    private $campo7;
    private $campo8; // Campo adicional

  // Establece la conexión con la base de datos
  private function getConection() {
    $db = new Db(); // Crea un nuevo objeto de la clase Db
    $this->conection = $db->conection; // Asigna la conexión a la propiedad
}

    public function __construct(
        $id = null,
        $Pieza_idPieza = null,
        $IdClasificacion = null,
        $Tabla = null,
        $campo1 = null,
        $campo2 = null,
        $campo3 = null,
        $campo4 = null,
        $campo5 = null,
        $campo6 = null,
        $campo7 = null,
        $campo8 = null // Campo adicional
    ) {
        $this->id = $id;
        $this->Pieza_idPieza = $Pieza_idPieza;
        $this->IdClasificacion = $IdClasificacion;
        $this->Tabla = $Tabla;
        $this->campo1 = $campo1;
        $this->campo2 = $campo2;
        $this->campo3 = $campo3;
        $this->campo4 = $campo4;
        $this->campo5 = $campo5;
        $this->campo6 = $campo6;
        $this->campo7 = $campo7;
        $this->campo8 = $campo8; // Campo adicional
        $this->getConection(); // Establece la conexión a la base de datos
    }

    // Métodos getters y setters para cada propiedad
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPiezaIdPieza() {
        return $this->Pieza_idPieza;
    }

    public function setPiezaIdPieza($Pieza_idPieza) {
        $this->Pieza_idPieza = $Pieza_idPieza;
    }

    public function getIdClasificacion() {
        return $this->IdClasificacion;
    }

    public function setIdClasificacion($IdClasificacion) {
        $this->IdClasificacion = $IdClasificacion;
    }

    public function getTabla() {
        return $this->Tabla;
    }

    public function setTabla($Tabla) {
        $this->Tabla = $Tabla;
    }

    public function getCampo1() {
        return $this->campo1;
    }

    public function setCampo1($campo1) {
        $this->campo1 = $campo1;
    }

    public function getCampo2() {
        return $this->campo2;
    }

    public function setCampo2($campo2) {
        $this->campo2 = $campo2;
    }

    public function getCampo3() {
        return $this->campo3;
    }

    public function setCampo3($campo3) {
        $this->campo3 = $campo3;
    }

    public function getCampo4() {
        return $this->campo4;
    }

    public function setCampo4($campo4) {
        $this->campo4 = $campo4;
    }

    public function getCampo5() {
        return $this->campo5;
    }

    public function setCampo5($campo5) {
        $this->campo5 = $campo5;
    }

    public function getCampo6() {
        return $this->campo6;
    }

    public function setCampo6($campo6) {
        $this->campo6 = $campo6;
    }

    public function getCampo7() {
        return $this->campo7;
    }

    public function setCampo7($campo7) {
        $this->campo7 = $campo7;
    }

    public function getCampo8() {
        return $this->campo8;
    }

    public function setCampo8($campo8) {
        $this->campo8 = $campo8;
    }

    public function getDatosEliminadosPaginadas($limite, $offset) {
        $sql = "SELECT * FROM ".$this->table." LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener todos los registros de la tabla datos_eliminados
    public function getAllDatosEliminados() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

    public function getTotalDatosEliminados() {
        $sql = "SELECT COUNT(*) FROM datos_eliminados";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Método para obtener un registro de datos eliminados por idPieza
    public function getDatosEliminadosByPiezaId($Pieza_idPieza) {
        $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$Pieza_idPieza]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    // Método para obtener un registro de datos eliminados por idClasificacion
    public function getDatosEliminadosByClasificacionId($IdClasificacion) {
        $sql = "SELECT * FROM " . $this->table . " WHERE IdClasificacion = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$IdClasificacion]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    public function restorePiezaByTable($idPieza)
{
    try {
        // Iniciar transacción
        $this->conection->beginTransaction();
        
        // Obtener los datos de la pieza eliminada desde la tabla datos_eliminados
        $sqlSelect = "SELECT Pieza_idPieza, IdClasificacion, Tabla, campo1, campo2, campo3, campo4
                      FROM datos_eliminados WHERE Pieza_idPieza = :idPieza";
        $stmtSelect = $this->conection->prepare($sqlSelect);
        $stmtSelect->bindParam(':idPieza', $idPieza, PDO::PARAM_INT);
        $stmtSelect->execute();
        
        // Verificar si existe un registro con el ID especificado
        $deletedData = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        if (!$deletedData) {
            throw new Exception("Registro no encontrado en datos_eliminados.");
        }

        // Preparar la consulta de inserción según la tabla de clasificación
        switch ($deletedData['Tabla']) {
            case 'Paleontología':
                $sqlInsert = "INSERT INTO Paleontología (era, periodo, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                break;
            case 'Osteología':
                $sqlInsert = "INSERT INTO Osteología (especie, clasificacion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :Pieza_idPieza)";
                break;
            case 'Ictiología':
                $sqlInsert = "INSERT INTO Ictiología (clasificacion, especies, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                break;
            case 'Geología':
                $sqlInsert = "INSERT INTO Geología (tipo_rocas, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :Pieza_idPieza)";
                break;
            case 'Botánica':
                $sqlInsert = "INSERT INTO Botanica (reino, familia, especie, orden, division, clase, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :campo4, :campo5, :campo6, :campo7, :Pieza_idPieza)";
                break;
            case 'Zoología':
                $sqlInsert = "INSERT INTO Zoologia (reino, familia, especie, orden, phylum, clase, genero, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :campo4, :campo5, :campo6, :campo7, :campo8, :Pieza_idPieza)";
                break;
            case 'Arqueología':
                $sqlInsert = "INSERT INTO Arqueologia (integridad_historica, estetica, material, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                break;
            case 'Octología':
                $sqlInsert = "INSERT INTO Octologia (clasificacion, tipo, especie, descripcion, Pieza_idPieza)
                              VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                break;
            default:
                throw new Exception("Clasificación no válida.");
        }

        // Preparar y ejecutar la inserción
        $stmtInsert = $this->conection->prepare($sqlInsert);
        
        // Usar los valores recuperados para la inserción
        $stmtInsert->execute([
            ':campo1' => $deletedData['campo1'],
            ':campo2' => $deletedData['campo2'],
            ':campo3' => $deletedData['campo3'],
            ':campo4' => $deletedData['campo4'],
            ':campo5' => isset($deletedData['campo5']) ? $deletedData['campo5'] : null,
            ':campo6' => isset($deletedData['campo6']) ? $deletedData['campo6'] : null,
            ':campo7' => isset($deletedData['campo7']) ? $deletedData['campo7'] : null,
            ':campo8' => isset($deletedData['campo8']) ? $deletedData['campo8'] : null,
            ':Pieza_idPieza' => $deletedData['Pieza_idPieza'],
        ]);

        // Eliminar el registro de la tabla datos_eliminados después de reinserción exitosa
        $sqlDelete = "DELETE FROM datos_eliminados WHERE Pieza_idPieza = :idPieza";
        $stmtDelete = $this->conection->prepare($sqlDelete);
        $stmtDelete->bindParam(':idPieza', $idPieza, PDO::PARAM_INT);
        $stmtDelete->execute();

        // Confirmar transacción
        $this->conection->commit();
        return true;

    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $this->conection->rollBack();
        throw new Exception("Error al restaurar la pieza: " . $e->getMessage());
    }
}

}
