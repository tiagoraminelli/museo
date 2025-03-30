<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    header("Location: ../../index.php");
    exit;
}
if($_SESSION['nivel'] != 'administrador'){
    header("Location: ./piezaslistado.php");
}   
require_once("../../modelo/bd.php");
require_once("../../modelo/registros_eliminados.php");
require_once("../../modelo/datos_eliminados.php");
require_once("../../modelo/UsuarioPieza.php"); // Asegúrate de tener esta clase

$IdPiezaViejo = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($IdPiezaViejo > 0) {
    $registro = new registros_eliminados();
    $nuevoIdPieza = $registro->restorePieza($IdPiezaViejo);
    
    if ($nuevoIdPieza) {
        // 1. Restaurar datos adicionales de la pieza
        $restaurarTabla = new DatosEliminados();
        $datosTraidos = $restaurarTabla->getAllDatosEliminadosByPiezaId($IdPiezaViejo);
        $restaurarTabla->restorePiezaByTable($IdPiezaViejo, $nuevoIdPieza);
        
        // 2. Crear registro en usuario_has_pieza
        $usuarioPieza = new UsuarioHasPieza();
        $param = array(
            'Usuario_idUsuario' => $_SESSION['id'],
            'Pieza_idPieza' => $nuevoIdPieza
        );
        $result = $usuarioPieza->saveUsuarioPieza($param);
        
        if($result) {
            $_SESSION['mensaje'] = "Restaurado con éxito correctamente";
            header("Location: ../eliminados.php?restaurado=1");
        } else {
            $_SESSION['mensaje'] = "Pieza restaurada pero error al asociar con usuario";
            header("Location: ../eliminados.php?restaurado=2");
        }
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al restaurar el elemento.";
        header("Location: ../eliminados.php?restaurado=0");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "ID inválido.";
    header("Location: ../eliminados.php?restaurado=0");
    exit();
}
?>