<?php
session_start();
if (!isset($_SESSION['usuario_activo'])) {
    // Redireccionar al index.php si no hay usuario activo
    header("Location: ../../index.php");
    exit;
}
//echo "id activo: ".$_SESSION['id']."<br>";
require_once "../../modelo/bd.php";
require_once "../../modelo/pieza.php";
require_once "../../modelo/donante.php"; // Asegúrate de incluir el modelo de Donante
require_once "../../modelo/arqueologia.php";
require_once "../../modelo/paleontologia.php";
require_once "../../modelo/osteologia.php";
require_once "../../modelo/geologia.php";
require_once "../../modelo/ictiologia.php";
require_once "../../modelo/botanica.php";
require_once "../../modelo/octologia.php";
require_once "../../modelo/zoologia.php";
require_once "../../modelo/usuarioPieza.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario y almacenarlos en un array
    var_dump($_POST);
    $parametro = [
        'num_inventario' => '',
        'especie' => $_POST['especieP'],
        'estado_conservacion' => $_POST['estado_conservacion'],
        'fecha_ingreso' => $_POST['fecha_ingreso'],
        'cantidad_de_piezas' => $_POST['cantidad_de_piezas'],
        'clasificacion' => $_POST['clasificacion'],
        'observacion' => $_POST['observacion'],
        'imagen' => '', // Inicializamos el campo de imagen
    ];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen']['name']; // Nombre original del archivo
        $ruta_tmp = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo

        // Define la ruta de destino
        $ruta_destino = '../../assets/uploads/' . $imagen; // Asegúrate de que la carpeta uploads exista y tenga permisos de escritura
        // Mover el archivo subido a la carpeta deseada
        if (move_uploaded_file($ruta_tmp, $ruta_destino)) {
            $parametro['imagen'] = htmlspecialchars($imagen); // Guardar el nombre de la imagen en el array
            echo "Imagen subida con éxito: " . $parametro['imagen'] . "<br>";
        } else {
            echo "Error al mover la imagen al directorio de destino.<br>";
        }
    } else {
        echo "No se ha subido ninguna imagen o ha ocurrido un error en la carga.<br>";
    }

    // Echo de cada uno de los datos
    //echo "Número de Inventario: " . htmlspecialchars($parametro['num_inventario']) . "<br>";
    //echo "Especie: " . htmlspecialchars($parametro['especie']) . "<br>";
    //echo "Estado de Conservación: " . htmlspecialchars($parametro['estado_conservacion']) . "<br>";
    // echo "Fecha de Ingreso: " . htmlspecialchars($parametro['fecha_ingreso']) . "<br>";
    //echo "Cantidad de Piezas: " . htmlspecialchars($parametro['cantidad_de_piezas']) . "<br>";
    //echo "Clasificación: " . htmlspecialchars($parametro['clasificacion']) . "<br>";
    //echo "Observación: " . htmlspecialchars($parametro['observacion']) . "<br>";
    //echo "Imagen: " . htmlspecialchars($parametro['imagen']) . "<br>";
    


   // Manejo del donante
if (isset($_POST['donante_nombre']) && !empty($_POST['donante_nombre']) && isset($_POST['donante_apellido']) && !empty($_POST['donante_apellido'])) {
    $nombre = trim($_POST['donante_nombre']);
    $apellido = trim($_POST['donante_apellido']);

    // Buscar donante
    $donante = new Donante(); // Asegúrate de que la clase Donante esté bien definida
    $existingDonante = $donante->buscarDonantes($nombre); // Puedes usar solo el nombre o un concatenado

    if (!empty($existingDonante)) {
        // Si el donante ya existe, se asigna el idDonante
        $parametro['Donante_idDonante'] = $existingDonante[0]['idDonante'];
        echo "id para insertar en parametro: ".$parametro['Donante_idDonante']."<br>";
        echo "Donante existente: " . htmlspecialchars($existingDonante[0]['nombre']) . " " . htmlspecialchars($existingDonante[0]['apellido']) . "<br>";
    } else {
        // Si no existe, se agrega el nuevo donante
        $parametro['nombre'] = $nombre;
        $parametro['apellido'] = $apellido;

        // Aquí se podría agregar una fecha si se requiere
        $fechaDonante = date('Y-m-d'); // Fecha actual
        $parametro['fecha'] = $fechaDonante;

        $parametro['Donante_idDonante'] = $donante->save($parametro);
        echo "Donante nuevo insertado con ID: " . htmlspecialchars($parametro['Donante_idDonante']) . "<br>";
    }
} else {
    echo "Los campos de nombre y apellido del donante son obligatorios.<br>";
}

    // Verificar si existe idPieza
    if (isset($_POST['idPieza']) && !empty($_POST['idPieza'])) {
        $parametro['idPieza'] = $_POST['idPieza']; // Agregar idPieza al array
        $parametro['num_inventario'] = "NDH-".$_POST['idPieza']; // Agregar idPieza al array
        // Llamar a la función save para actualizar
        $pieza = new Pieza(); // Asegúrate de que la clase Pieza esté bien definida
        $pieza->save($parametro);
        echo "Pieza actualizada con éxito.";
        header("Location: ../../listados/piezasListado.php");
    } else {
        // Llamar a la función save para insertar
        $pieza = new Pieza(); // Asegúrate de que la clase Pieza esté bien definida
        $idPieza = $pieza->save($parametro); // Guardar la pieza y obtener el ID generado

        if ($idPieza) {
            echo "Pieza insertada con éxito.<br>";

            // Generar el número de inventario
            $numInventario = "NDH-" . $idPieza; // Concatenar el prefijo con el ID
            $parametro['num_inventario'] = $numInventario;
            $parametro['idPieza'] = $idPieza; // Agregar el ID de la pieza al array

            // Actualizar la pieza con el número de inventario generado
            $pieza->save($parametro);
            echo "Número de inventario generado: " . $numInventario . "<br>";

            // Comprobar si existe idPieza y usuario está logueado
            if (isset($_SESSION['id']) && isset($parametro['idPieza'])) {
                $parametro['Usuario_idUsuario'] = $_SESSION['id']; // Obtener el ID del usuario de la sesión
                $parametro['Pieza_idPieza'] = $parametro['idPieza']; // Agregar idPieza al array

                // Crear una instancia de la clase UsuarioPieza
                $usuarioPieza = new UsuarioHasPieza();

                // Llamar a la función saveUsuarioPieza para insertar o actualizar
                if ($usuarioPieza->saveUsuarioPieza($parametro)) {
                    echo "Relación usuario-pieza guardada con éxito.";
                    header("Location: ../../listados/piezasListado.php?historial=1");
                } else {
                    echo "Error al guardar la relación usuario-pieza.<br>";
                }
            } else {
                // Manejar el caso en que falta idPieza o el usuario no está logueado
                echo "Falta el ID de la pieza o el usuario no está logueado.<br>";
            }
        } else {
            echo "Error en la inserción de la pieza.<br>";
        }
    }

//die();


    // Si la clasificación es Arqueología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Arqueología') {
    echo "Procesando datos de Arqueología<br>";
    $arqueologia = new Arqueologia();
    $datosArqueologia = [
        'idArqueologia' => $_POST['idArqueologia'] ?? null, // Incluir el ID si existe
        'integridad_historica' => $_POST['integridad_historica'],
        'estetica' => $_POST['estetica'],
        'material' => $_POST['material'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($arqueologia->saveArqueologia($datosArqueologia)) {
        echo "Registro de Arqueología procesado con éxito (insert o update).<br>";
       
    } else {
        echo "Error al procesar el registro de Arqueología.<br>";
    }
}

// Si la clasificación es Paleontología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Paleontología') {
    echo "Procesando datos de Paleontología<br>";
    $paleontologia = new Paleontologia();
    $datosPaleontologia = [
        'idPaleontologia' => $_POST['idPaleontologia'] ?? null, // Incluir el ID si existe
        'era' => $_POST['era'],
        'periodo' => $_POST['periodo'],
        'descripcion' => $_POST['descripcionPal'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($paleontologia->savePaleontologia($datosPaleontologia)) {
        echo "Registro de Paleontología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Paleontología.<br>";
    }
}

// Si la clasificación es Osteología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Osteología') {
    echo "Procesando datos de Osteología<br>";
    $osteologia = new Osteologia();
    $datosOsteologia = [
        'idOsteologia' => $_POST['idOsteologia'] ?? null, // Incluir el ID si existe
        'especie' => $_POST['especieOst'],
        'clasificacion' => $_POST['clasificacionOst'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($osteologia->saveOsteologia($datosOsteologia)) {
        echo "Registro de Osteología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Osteología.<br>";
    }
}

// Si la clasificación es Geología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Geología') {
    echo "Procesando datos de Geología<br>";
    $geologia = new Geologia(); // Asumiendo que tienes una clase Geologia definida similar a Osteologia
    $datosGeologia = [
        'idGeologia' => $_POST['idGeologia'] ?? null, // Incluir el ID si existe
        'tipo_rocas' => $_POST['tipo_rocas'],
        'descripcion' => $_POST['descripcion'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($geologia->saveGeologia($datosGeologia)) {
        echo "Registro de Geología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Geología.<br>";
    }
}

// Si la clasificación es Ictiología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Ictiología') {
    echo "Procesando datos de Ictiología<br>";
    $ictiologia = new Ictiologia(); // Asumiendo que tienes una clase Ictiologia definida
    $datosIctiologia = [
        'idIctiologia' => $_POST['idIctiologia'] ?? null, // Incluir el ID si existe
        'clasificacion' => $_POST['clasificacionIct'],
        'especies' => $_POST['especiesIct'],
        'descripcion' => $_POST['descripcionIct'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($ictiologia->saveIctiologia($datosIctiologia)) {
        echo "Registro de Ictiología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Ictiología.<br>";
    }
}

// Si la clasificación es Botánica, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Botánica') {
    echo "Procesando datos de Botánica<br>";
    $botanica = new Botanica(); // Asumiendo que tienes una clase Botanica definida
    $datosBotanica = [
        'idBotanica' => $_POST['idBotanica'] ?? null, // Incluir el ID si existe
        'reino' => $_POST['reinoBot'],
        'familia' => $_POST['familiaBot'],
        'especie' => $_POST['especieBot'],
        'orden' => $_POST['ordenBot'],
        'division' => $_POST['divisionBot'],
        'clase' => $_POST['claseBot'],
        'descripcion' => $_POST['descripcionBot'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($botanica->saveBotanica($datosBotanica)) {
        echo "Registro de Botánica procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Botánica.<br>";
    }
}


// Si la clasificación es Octología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Octología') {
    echo "Procesando datos de Octología<br>";
    $octologia = new Octologia(); // Asumiendo que tienes una clase Octologia definida
    $datosOctologia = [
        'idOctologia' => $_POST['idOctologia'] ?? null, // Incluir el ID si existe
        'clasificacion' => $_POST['clasificacionOct'],
        'tipo' => $_POST['tipoOct'],
        'especie' => $_POST['especieOct'],
        'descripcion' => $_POST['descripcionOct'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($octologia->saveOctologia($datosOctologia)) {
        echo "Registro de Octología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Octología.<br>";
    }
}

// Si la clasificación es Zoología, realizar la inserción o actualización en la tabla específica
if ($_POST['clasificacion'] === 'Zoología') {
    echo "Procesando datos de Zoología<br>";
    $zoologia = new Zoologia(); // Asumiendo que tienes una clase Zoologia definida
    $datosZoologia = [
        'idZoologia' => $_POST['idZoologia'] ?? null, // Incluir el ID si existe
        'reino' => $_POST['reino'],
        'familia' => $_POST['familia'],
        'especie' => $_POST['especie'],
        'orden' => $_POST['orden'],
        'phylum' => $_POST['phylum'],
        'clase' => $_POST['clase'],
        'genero' => $_POST['genero'],
        'descripcion' => $_POST['descripcion'],
        'Pieza_idPieza' => $parametro['idPieza'] // Vincular con el ID de la pieza
    ];

    if ($zoologia->saveZoologia($datosZoologia)) {
        echo "Registro de Zoología procesado con éxito (insert o update).<br>";
    } else {
        echo "Error al procesar el registro de Zoología.<br>";
    }
}

} //fin del metodo
?>
