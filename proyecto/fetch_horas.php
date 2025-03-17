<?php
include 'conexion.php';

$personas = isset($_GET['personas']) ? intval($_GET['personas']) : 0;
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$restaurante = isset($_GET['restaurante']) ? intval($_GET['restaurante']) : 0;

// Obtener mesas del restaurante una sola vez
$sql = "SELECT * FROM Mesas WHERE restaurant_id = $restaurante";
$result = $conexion->query($sql);
$mesas_disponibles = $result->fetch_all(MYSQLI_ASSOC);

// Obtener las horas iniciales
$horarios_disponibles = [];
for ($hour = 8; $hour <= 21; $hour++) {
    $horarios_disponibles[] = sprintf("%02d:00", $hour);
}

foreach ($horarios_disponibles as $index => $hora) {
    $hora_inicio = "$date $hora:00";
    $hora_fin = date('Y-m-d H:i:s', strtotime($hora_inicio . ' +1 hour'));

    // Verificar reservas existentes en esa hora específica
    $total_personas_reservadas = 0;
    $mesas_ocupadas = [];
    foreach ($mesas_disponibles as $mesa) {
        $sql = "SELECT COUNT(*) as total FROM Reservations
                WHERE restaurant_id = $restaurante
                AND mesa_id = {$mesa['id']}
                AND reservation_date BETWEEN '$hora_inicio' AND '$hora_fin'";

        $reserva_result = $conexion->query($sql);
        $reserva_row = $reserva_result->fetch_assoc();
        
        if ($reserva_row['total'] > 0) {
            $total_personas_reservadas += $mesa['seating_capacity'];
            $mesas_ocupadas[] = $mesa['id'];
        }
    }

    // Si no hay suficiente espacio, eliminar hora actual y próximas 2 horas
    if ($total_personas_reservadas + $personas > array_sum(array_column($mesas_disponibles, 'seating_capacity'))) {
        unset($horarios_disponibles[$index]);
        if (isset($horarios_disponibles[$index + 1])) unset($horarios_disponibles[$index + 1]);
        if (isset($horarios_disponibles[$index + 2])) unset($horarios_disponibles[$index + 2]);
    }
}

// Reindexar arreglo
$horarios_disponibles = array_values($horarios_disponibles);

// Devolver resultado
header('Content-Type: application/json');
echo json_encode($horarios_disponibles);
?>