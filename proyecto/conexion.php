<?php
$host = "localhost";
$usuario = "root";
$clave = "alex010101";
$bd = "restaurantes";

// Desactivar excepciones automáticas de mysqli para poder manejar el error 1049
mysqli_report(MYSQLI_REPORT_OFF);

// Intentar conectar directamente a la BD
$conexion = @new mysqli($host, $usuario, $clave, $bd);

// Si la BD no existe (código de error 1049), crearla desde el SQL
if ($conexion->connect_errno === 1049) {
    $tmp = @new mysqli($host, $usuario, $clave);
    if ($tmp->connect_error) {
        die("Error al conectar con el servidor MySQL: " . $tmp->connect_error);
    }

    $sqlFile = __DIR__ . DIRECTORY_SEPARATOR . 'restaurantes.sql';
    if (!file_exists($sqlFile)) {
        die("No se encontró el archivo de esquema: " . $sqlFile);
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        die("No se pudo leer el archivo de esquema: " . $sqlFile);
    }

    // Ejecutar múltiples sentencias para crear la BD y tablas
    if (!$tmp->multi_query($sql)) {
        die("Error al inicializar la base de datos: " . $tmp->error);
    }
    // Avanzar por todos los resultados para completar la ejecución
    while ($tmp->more_results()) {
        $tmp->next_result();
    }
    $tmp->close();

    // Reintentar la conexión a la BD ya creada
    $conexion = @new mysqli($host, $usuario, $clave, $bd);
}

if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}

mysqli_set_charset($conexion, "utf8mb4");
?>