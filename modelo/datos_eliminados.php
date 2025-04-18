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
// En tu clase DatosEliminados
public function getAllDatosEliminadosByPiezaId($Pieza_idPieza) {
    $sql = "SELECT * FROM " . $this->table . " WHERE Pieza_idPieza = ?";
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$Pieza_idPieza]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
}

public function getAllDatosEliminados() {
    $sql = "SELECT * FROM " . $this->table;
    $stmt = $this->conection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados
}

    public function getTotalDatosEliminados() {
        $sql = "SELECT COUNT(*) FROM datos_eliminados";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Método para obtener un registro de datos eliminados por idPieza


    // Método para obtener un registro de datos eliminados por idClasificacion
    public function getDatosEliminadosByClasificacionId($IdClasificacion) {
        $sql = "SELECT * FROM " . $this->table . " WHERE IdClasificacion = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$IdClasificacion]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un solo resultado
    }

    public function restorePiezaByTable($idPiezaViejo,$idPiezaNuevo)
    {
        try {
            // Iniciar transacción
            $this->conection->beginTransaction();
    
            // Verificar si el idPieza existe en la tabla pieza
            $sqlVerify = "SELECT idPieza FROM pieza WHERE idPieza = :idPieza";
            $stmtVerify = $this->conection->prepare($sqlVerify);
            $stmtVerify->bindParam(':idPieza', $idPiezaNuevo, PDO::PARAM_INT);
            $stmtVerify->execute();
    
            // Obtener los datos de la pieza eliminada desde la tabla datos_eliminados
            $sqlSelect = "SELECT * FROM datos_eliminados WHERE Pieza_idPieza = :idPieza";
            $stmtSelect = $this->conection->prepare($sqlSelect);
            $stmtSelect->bindParam(':idPieza', $idPiezaViejo, PDO::PARAM_INT);
            $stmtSelect->execute();
        
            // Verificar si existe un registro con el ID especificado
            $deletedData = $stmtSelect->fetch(PDO::FETCH_ASSOC);
            if (!$deletedData) {
                throw new Exception("Registro no encontrado en datos_eliminados.");
            }
            // Preparar la consulta de inserción según la tabla de clasificación
            switch ($deletedData['Tabla']) {
                case 'Paleontología':
                    $sqlInsert = "INSERT INTO paleontologia (era, periodo, descripcion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";

                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':campo3' => $deletedData['campo3'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Osteología':
                    $sqlInsert = "INSERT INTO osteologia (especie, clasificacion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Ictiología':
                    $sqlInsert = "INSERT INTO ictiologia (clasificacion, especies, descripcion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':campo3' => $deletedData['campo3'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Geología':
                    $sqlInsert = "INSERT INTO geologia (tipo_rocas, descripcion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Botánica':
                    $sqlInsert = "INSERT INTO botanica (reino, familia, especie, orden, division, clase, descripcion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :campo3, :campo4, :campo5, :campo6, :campo7, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':campo3' => $deletedData['campo3'],
                        ':campo4' => $deletedData['campo4'],
                        ':campo5' => $deletedData['campo5'],
                        ':campo6' => $deletedData['campo6'],
                        ':campo7' => $deletedData['campo7'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Zoologia':
                    $sqlInsert = "INSERT INTO zoologia (reino, familia, especie, orden, phylum, clase, genero, descripcion, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :campo3, :campo4, :campo5, :campo6, :campo7, :campo8, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':campo3' => $deletedData['campo3'],
                        ':campo4' => $deletedData['campo4'],
                        ':campo5' => $deletedData['campo5'],
                        ':campo6' => $deletedData['campo6'],
                        ':campo7' => $deletedData['campo7'],
                        ':campo8' => $deletedData['campo8'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Arqueologia':
                    $sqlInsert = "INSERT INTO arqueologia (integridad_historica, estetica, material, Pieza_idPieza)
                                  VALUES (:campo1, :campo2, :campo3, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':campo1' => $deletedData['campo1'],
                        ':campo2' => $deletedData['campo2'],
                        ':campo3' => $deletedData['campo3'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    break;
                case 'Octologia':
                    $sqlInsert = "INSERT INTO octologia (clasificacion, tipo, especie, descripcion, Pieza_idPieza)
                                      VALUES (:clasificacion, :tipo, :especie, :descripcion, :Pieza_idPieza)";
                    $dataToInsert = [
                        ':clasificacion' => $deletedData['campo1'],
                        ':tipo' => $deletedData['campo2'],
                        ':especie' => $deletedData['campo3'],
                        ':descripcion' => $deletedData['campo4'],
                        ':Pieza_idPieza' => $idPiezaNuevo,
                    ];
                    //var_dump($deletedData['Tabla']); // Verificar el valor de Tabla
                    break;
                default:
                    throw new Exception("Clasificación no válida.");
            }
        
            // Preparar y ejecutar la inserción
            $stmtInsert = $this->conection->prepare($sqlInsert);
            $stmtInsert->execute($dataToInsert);
    
            // Obtener los datos de la pieza eliminada desde la tabla datos_eliminados
            $sqlDeteled = "DELETE FROM datos_eliminados WHERE Pieza_idPieza = :idPieza";
            $stmtDeteled = $this->conection->prepare($sqlDeteled);
            $stmtDeteled->bindParam(':idPieza', $idPiezaViejo, PDO::PARAM_INT);
            $stmtDeteled->execute();
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
