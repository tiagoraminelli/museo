<?php
require_once "bd.php";
require_once "pieza.php";

class registros_eliminados extends Pieza {
    protected $table = "registros_eliminados"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idPrimaria;
    private $idPieza;
    private $numInventario;
    private $especie;
    private $estadoConservacion;
    private $fechaIngreso;
    private $cantidadPiezas;
    private $clasificacion;
    private $observacion;
    private $imagen;
    private $donanteIdDonante;

     // Getters and Setters

     public function getId() {
        return $this->idPrimaria;
    }

    public function setId($idPrimaria) {
        $this->idPrimaria = $idPrimaria;
    }

    public function getIdPieza() {
        return $this->idPieza;
    }

    public function setIdPieza($idPieza) {
        $this->idPieza = $idPieza;
    }

    public function getNumInventario() {
        return $this->numInventario;
    }

    public function setNumInventario($numInventario) {
        $this->numInventario = $numInventario;
    }

    public function getEspecie() {
        return $this->especie;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }

    public function getEstadoConservacion() {
        return $this->estadoConservacion;
    }

    public function setEstadoConservacion($estadoConservacion) {
        $this->estadoConservacion = $estadoConservacion;
    }

    public function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getCantidadDePiezas() {
        return $this->cantidadPiezas;
    }

    public function setCantidadDePiezas($cantidadPiezas) {
        $this->cantidadPiezas = $cantidadPiezas;
    }

    public function getClasificacion() {
        return $this->clasificacion;
    }

    public function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getDonanteIdDonante() {
        return $this->donanteIdDonante;
    }

    public function setDonanteIdDonante($donanteIdDonante) {
        $this->donanteIdDonante = $donanteIdDonante;
    }


    // Establece la conexión con la base de datos
       private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Constructor
    public function __construct(
        $idPrimaria = null,
        $idPieza = null,
        $numInventario = null,
        $especie = null,
        $estadoConservacion = null,
        $fechaIngreso = null,
        $cantidadPiezas = null,
        $clasificacion = null,
        $observacion = null,
        $imagen = null,
        $donanteIdDonante = null
    ) {
        $this->idPrimaria = $idPrimaria;
        $this->idPieza = $idPieza;
        $this->numInventario = $numInventario;
        $this->especie = $especie;
        $this->estadoConservacion = $estadoConservacion;
        $this->fechaIngreso = $fechaIngreso;
        $this->cantidadPiezas = $cantidadPiezas;
        $this->clasificacion = $clasificacion;
        $this->observacion = $observacion;
        $this->imagen = $imagen;
        $this->donanteIdDonante = $donanteIdDonante;
        $this->getConection(); // Establece la conexión a la base de datos
    }


    public function getAllRegistrosEliminados() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function AllRegistrosEliminadosCargados() {
        $sql = "SELECT * FROM registros_eliminados 
        INNER JOIN pieza ON registros_eliminados.idPieza = pieza.idPieza";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function registrosEliminadosCargadosByIdPieza($idPieza) {
        $sql = "SELECT * FROM registros_eliminados 
        INNER JOIN pieza ON registros_eliminados.idPieza = pieza.idPieza and pieza.idPieza = ? ";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idPieza]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function deleteRegistrosById($id){ //empieza la funtion
        $this->getConection(); //ejecuta un metodo de la clase que gestiona la conexion a la base de datos
        $sql="DELETE FROM ".$this->table." WHERE `id ` = ? "; //armamos la cadena sql 
        $stmt=$this->conection->prepare($sql); //metemos la cadena que armamos para armar la consulta
        return $stmt->execute([$id]); //ejecutamos la consulta
    }

    public function restorePieza($idPieza)
{
    try {
        // Iniciar transacción
        $this->conection->beginTransaction();
        
        // Obtener los datos de la pieza eliminada desde la tabla registros_eliminados
        $sqlSelect = "SELECT idPieza, num_inventario, especie, estado_conservacion, 
                      fecha_ingreso, cantidad_de_piezas, clasificacion, 
                      observacion, imagen, Donante_idDonante
                      FROM registros_eliminados WHERE idPieza = :idPieza";
        $stmtSelect = $this->conection->prepare($sqlSelect);
        $stmtSelect->bindParam(':idPieza', $idPieza, PDO::PARAM_INT);
        $stmtSelect->execute();
        
        // Verificar si existe un registro con el ID especificado
        $deletedPieza = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        if (!$deletedPieza) {
            throw new Exception("Registro no encontrado en registros_eliminados.");
        }

        // Insertar los datos en la tabla pieza
        $sqlInsert = "INSERT INTO pieza (num_inventario, especie, estado_conservacion, 
                                         fecha_ingreso, cantidad_de_piezas, clasificacion, 
                                         observacion, imagen, Donante_idDonante)
                      VALUES (:num_inventario, :especie, :estado_conservacion, 
                              :fecha_ingreso, :cantidad_de_piezas, :clasificacion, 
                              :observacion, :imagen, :Donante_idDonante)";
        $stmtInsert = $this->conection->prepare($sqlInsert);
        
        // Usar los valores recuperados para la inserción
        $stmtInsert->execute([
            ':num_inventario' => $deletedPieza['num_inventario'],
            ':especie' => $deletedPieza['especie'],
            ':estado_conservacion' => $deletedPieza['estado_conservacion'],
            ':fecha_ingreso' => $deletedPieza['fecha_ingreso'],
            ':cantidad_de_piezas' => $deletedPieza['cantidad_de_piezas'],
            ':clasificacion' => $deletedPieza['clasificacion'],
            ':observacion' => $deletedPieza['observacion'],
            ':imagen' => $deletedPieza['imagen'],
            ':Donante_idDonante' => $deletedPieza['Donante_idDonante'],
        ]);

        // Eliminar el registro de la tabla registros_eliminados después de reinserción exitosa
        $sqlDelete = "DELETE FROM registros_eliminados WHERE idPieza = :idPieza";
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

?>
