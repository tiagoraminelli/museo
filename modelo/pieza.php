<?php
require_once "bd.php";

class Pieza {
    protected $table = "pieza"; // Nombre de la tabla
    protected $conection; // Conexión a la base de datos

    // Propiedades de la clase que coinciden con las columnas de la base de datos
    private $idPrimaria;
    private $numInventario;
    private $especie;
    private $estadoConservacion;
    private $fechaIngreso;
    private $cantidadPiezas;
    private $clasificacion;
    private $observacion;
    private $imagen;
    private $donanteIdDonante;

    // Constructor
    public function __construct(
        $idPrimaria = null,
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

    // Establece la conexión con la base de datos
    private function getConection() {
        $db = new Db(); // Crea un nuevo objeto de la clase Db
        $this->conection = $db->conection; // Asigna la conexión a la propiedad
    }

    // Getters
    public function getIdPrimaria() {
        return $this->idPrimaria;
    }

    public function getNumInventario() {
        return $this->numInventario;
    }

    public function getEspecie() {
        return $this->especie;
    }

    public function getEstadoConservacion() {
        return $this->estadoConservacion;
    }

    public function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    public function getCantidadPiezas() {
        return $this->cantidadPiezas;
    }

    public function getClasificacion() {
        return $this->clasificacion;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    // Reemplazar el método getImagen
    public function getImagen() {
    return $this->getImagePath($this->imagen);
    }

    public function getDonanteIdDonante() {
        return $this->donanteIdDonante;
    }

    // Setters
    public function setIdPrimaria($idPrimaria) {
        $this->idPrimaria = $idPrimaria;
    }

    public function setNumInventario($numInventario) {
        $this->numInventario = $numInventario;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }

    public function setEstadoConservacion($estadoConservacion) {
        $this->estadoConservacion = $estadoConservacion;
    }

    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function setCantidadPiezas($cantidadPiezas) {
        $this->cantidadPiezas = $cantidadPiezas;
    }

    public function setClasificacion($clasificacion) {
        $this->clasificacion = $clasificacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function setDonanteIdDonante($donanteIdDonante) {
        $this->donanteIdDonante = $donanteIdDonante;
    }

    // Método para obtener todos los registros de la tabla pieza
    public function getAllPiezas() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
    }

      // Método para obtener todos los registros de la tabla pieza
      public function getPiezaById($id) {
        $sql = "SELECT * FROM " . $this->table." WHERE idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna todos los resultados de la consulta
       }

       public function getPiezaByIdImage() {
        $sql = "SELECT * FROM " . $this->table . "";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $pieza = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Agregar la URL de la imagen si existe
        if ($pieza) {
            $pieza['imagen'] = $this->getImagePath($pieza['imagen']);
        }
        return $pieza; // Retorna todos los resultados de la consulta
    }

    // Método para obtener el registro de la tabla pieza y la tabla relacionada según la clasificación
public function getPiezaByIdAndClasificacion($id, $clasificacion) {
    // Mapeo de las clasificaciones a sus respectivas tablas
    $clasificacionTablaMap = [
        'Paleontología' => 'Paleontologia',
        'Osteología' => 'Osteologia',
        'Ictiología' => 'Ictiologia',
        'Geología' => 'Geologia',
        'Botánica' => 'botanica',
        'Zoología' => 'Zoologia',
        'Arqueología' => 'Arqueologia',
        'Octología' => 'Octologia'
    ];

    // Verificar si la clasificación es válida
    if (!array_key_exists($clasificacion, $clasificacionTablaMap)) {
        throw new Exception("Clasificación no válida");
    }

    // Obtener el nombre de la tabla relacionada según la clasificación
    $tablaRelacionada = $clasificacionTablaMap[$clasificacion];

    // Construir la consulta SQL
    $sql = "SELECT * 
    FROM pieza
    INNER JOIN $tablaRelacionada ON pieza.idPieza = $tablaRelacionada.Pieza_idPieza
    WHERE pieza.idPieza = ?;
    ";

    // Preparar y ejecutar la consulta
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$id]);

    // Retornar los resultados de la consulta
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getPiezaByIdAndClasificacionAndDonante($id, $clasificacion) {
    // Mapeo de las clasificaciones a sus respectivas tablas
    $clasificacionTablaMap = [
        'Paleontología' => 'Paleontologia',
        'Osteología' => 'Osteologia',
        'Ictiología' => 'Ictiologia',
        'Geología' => 'Geologia',
        'Botánica' => 'botanica',
        'Zoología' => 'Zoologia',
        'Arqueología' => 'Arqueologia',
        'Octología' => 'Octologia'
    ];

    // Verificar si la clasificación es válida
    if (!array_key_exists($clasificacion, $clasificacionTablaMap)) {
        throw new Exception("Clasificación no válida");
    }

    // Obtener el nombre de la tabla relacionada según la clasificación
    $tablaRelacionada = $clasificacionTablaMap[$clasificacion];

    // Construir la consulta SQL
    $sql = "SELECT * 
    FROM pieza
    INNER JOIN $tablaRelacionada ON pieza.idPieza = $tablaRelacionada.Pieza_idPieza
    INNER JOIN donante ON pieza.Donante_idDonante = donante.idDonante
    WHERE pieza.idPieza = ?;
    ";

    // Preparar y ejecutar la consulta
    $stmt = $this->conection->prepare($sql);
    $stmt->execute([$id]);

    // Retornar los resultados de la consulta
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



    // Método para obtener la ruta completa de la imagen
private function getImagePath($imagen) {
    $rutaUploads = 'uploads/'; // Ruta de la carpeta donde se almacenan las imágenes
    return !empty($imagen) ? $rutaUploads . $imagen : 'ruta/por/defecto/placeholder.png'; // Ruta por defecto si no hay imagen
}



    // Método para eliminar una pieza por idPrimaria
    public function eliminarPorIdPieza($idPieza) {
        $sql = "DELETE FROM " . $this->table . " WHERE idPieza = ?";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute([$idPieza]); // Retorna true si se eliminó correctamente
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPiezasPaginadas($limite, $offset) {
        $sql = "SELECT * FROM pieza LIMIT :limite OFFSET :offset";
        $stmt = $this->conection->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPiezas($search) {
        // Definir la consulta SQL con búsqueda en varios campos
        $sql = "SELECT * FROM " . $this->table . " 
                WHERE idPieza LIKE :search 
                OR num_inventario LIKE :search 
                OR especie LIKE :search 
                OR estado_conservacion LIKE :search 
                OR fecha_ingreso LIKE :search
                OR cantidad_de_piezas LIKE :search
                OR clasificacion LIKE :search
                OR observacion LIKE :search
                OR Donante_idDonante LIKE :search";
    
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
    

    
    public function getTotalPiezas() {
        $sql = "SELECT COUNT(*) as total FROM pieza";
        $stmt = $this->conection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getTablasRelacionadasConPieza($idPieza) {
        // Array de tablas que contienen una clave foránea que referencia a la tabla 'pieza'
        $tablasRelacionadas = [
            'paleontologia' => 'Pieza_idPieza',
            'osteologia' => 'Pieza_idPieza',
            'ictiologia' => 'Pieza_idPieza',
            'geologia' => 'Pieza_idPieza',
            'botanica' => 'Pieza_idPieza',
            'zoologia' => 'Pieza_idPieza',
            'arqueologia' => 'Pieza_idPieza',
            'octologia' => 'Pieza_idPieza'
        ];
    
        $resultado = [];
    
        foreach ($tablasRelacionadas as $tabla => $campoForaneo) {
            $sql = "SELECT * FROM " . $tabla . " WHERE " . $campoForaneo . " = ?";
            $stmt = $this->conection->prepare($sql);
            $stmt->execute([$idPieza]);
            
            // Si la consulta devuelve resultados, añadimos la tabla al resultado
            if ($stmt->rowCount() > 0) {
                $resultado[$tabla] = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guardar los registros encontrados
            }
        }
    
        return $resultado; // Devuelve un array con las tablas y los registros relacionados
    }

    #metodo para cargar y editar usuario:

    public function save($param) {
        $this->getConection();
    
        $exists = false;
        if (isset($param['idPieza']) && !empty($param['idPieza'])) {
            // Verificar si la pieza ya existe
            $actualPieza = $this->getPiezaById($param['idPieza']);
    
            if ($actualPieza) {
                $exists = true;
                $this->idPrimaria = $actualPieza['idPieza'];
                $this->numInventario = $actualPieza['num_inventario'];
                $this->especie = $actualPieza['especie'];
                $this->estadoConservacion = $actualPieza['estado_conservacion'];
                $this->fechaIngreso = $actualPieza['fecha_ingreso'];
                $this->cantidadPiezas = $actualPieza['cantidad_de_piezas'];
                $this->clasificacion = $actualPieza['clasificacion'];
                $this->observacion = $actualPieza['observacion'];
                $this->imagen = $actualPieza['imagen'];
                $this->donanteIdDonante = $actualPieza['Donante_idDonante'];
            }
        }
    
        // Asignar los parámetros al objeto
        if (isset($param['idPieza'])) {
            $this->idPrimaria = $param['idPieza'];
        }
        if (isset($param['num_inventario'])) {
            $this->numInventario = $param['num_inventario'];
        }
        if (isset($param['especie'])) {
            $this->especie = $param['especie'];
        }
        if (isset($param['estado_conservacion'])) {
            $this->estadoConservacion = $param['estado_conservacion'];
        }
        if (isset($param['fecha_ingreso'])) {
            $this->fechaIngreso = $param['fecha_ingreso'];
        }
        if (isset($param['cantidad_de_piezas'])) {
            $this->cantidadPiezas = $param['cantidad_de_piezas'];
        }
        if (isset($param['clasificacion'])) {
            $this->clasificacion = $param['clasificacion'];
        }
        if (isset($param['observacion'])) {
            $this->observacion = $param['observacion'];
        }
        if (isset($param['imagen'])) {
            $this->imagen = $param['imagen'];
        }
        if (isset($param['Donante_idDonante'])) {
            $this->donanteIdDonante = $param['Donante_idDonante'];
        }
    
        // Si la pieza ya existe, se actualiza
        if ($exists) {
            $sql = "UPDATE " . $this->table . " SET num_inventario = ?, especie = ?, estado_conservacion = ?, fecha_ingreso = ?, cantidad_de_piezas = ?, clasificacion = ?, observacion = ?, imagen = ?, Donante_idDonante = ? WHERE idPieza = ?";
            $stmt = $this->conection->prepare($sql);
            //die($sql);
            $stmt->execute([
                $this->numInventario, $this->especie, $this->estadoConservacion, $this->fechaIngreso,
                $this->cantidadPiezas, $this->clasificacion, $this->observacion, $this->imagen, $this->donanteIdDonante, $this->idPrimaria
            ]);
        } else {
            // Si no existe, se inserta uno nuevo
            $sql = "INSERT INTO " . $this->table . " (num_inventario, especie, estado_conservacion, fecha_ingreso, cantidad_de_piezas, clasificacion, observacion, imagen, Donante_idDonante) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conection->prepare($sql);
            //die($sql);
            $stmt->execute([
                $this->numInventario, $this->especie, $this->estadoConservacion, $this->fechaIngreso,
                $this->cantidadPiezas, $this->clasificacion, $this->observacion, $this->imagen, $this->donanteIdDonante
            ]);
            $this->idPrimaria = $this->conection->lastInsertId();
        }
    
        return $this->idPrimaria;
    }
    



    
} // fin de la clase

?>

