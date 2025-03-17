<?php
include 'conexion.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $number_of_people = intval($_POST['table']);
    $restaurant_id = intval($_POST['restaurant_id']);
    $customer_id = 1; // Asegúrate que este existe.

    // Obtener mesas disponibles
    $reservation_date_start = "$date $time:00";
    $reservation_date_end = date('Y-m-d H:i:s', strtotime($reservation_date_start . ' +1 hour'));
    
    // Consulta para obtener mesas disponibles (no ocupadas en ese horario específico)
    $sql = "SELECT * FROM Mesas 
            WHERE restaurant_id = $restaurant_id 
            AND id NOT IN (
                SELECT mesa_id FROM Reservations
                WHERE reservation_date BETWEEN '$reservation_date_start' AND '$reservation_date_end'
            ) 
            ORDER BY seating_capacity ASC";
    
    $result = $conexion->query($sql);
    if (!$result) {
        die("Error SQL al obtener mesas disponibles: " . $conexion->error);
    }
    
    $mesas_disponibles = [];
    while ($row = $result->fetch_assoc()) {
        $mesas_disponibles[] = $row;
    }
    
    // Verificar si hay suficientes mesas disponibles
    $mesas_asignadas = [];
    $personas_restantes = $number_of_people;
    
    foreach ($mesas_disponibles as $mesa) {
        if ($personas_restantes <= 0) break;
        $mesas_asignadas[] = $mesa;
        $personas_restantes -= $mesa['seating_capacity'];
    }
    
    if ($personas_restantes > 0) {
        die("No hay suficientes mesas disponibles en este horario.");
    }
    
    // Insertar reservas correctamente
    $personas_restantes = $number_of_people;
    
    foreach ($mesas_asignadas as $mesa) {
        $personas_a_reservar = min($personas_restantes, $mesa['seating_capacity']);
    
        $sql_insert = "INSERT INTO Reservations (restaurant_id, customer_id, mesa_id, reservation_date, number_of_people) 
                       VALUES ($restaurant_id, $customer_id, {$mesa['id']}, '$reservation_date_start', $personas_a_reservar)";
    
        if (!$conexion->query($sql_insert)) {
            die("Error SQL al insertar: " . $conexion->error . "<br>Consulta: " . $sql_insert);
        }
    
        $personas_restantes -= $personas_a_reservar;
    }
    
    echo "Reserva insertada exitosamente, sin conflictos.";
} else {
    die("Método inválido.");
}
?>
<?php
    // Mostrar página de confirmación
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Confirmación de Reserva</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <section class='confirmacion'>
                <div class='container'>
                    <h2>Reserva Confirmada</h2>
                    <p>Gracias, $first_name $last_name. Tu reserva ha sido confirmada.</p>
                    <p><strong>Restaurante:</strong> $restaurant_id</p>
                    <p><strong>Fecha y Hora:</strong> $reservation_date_start</p>
                    <p><strong>Personas:</strong> $number_of_people</p>
                    <p><strong>Teléfono:</strong> $phone</p>
                    <p><strong>Correo Electrónico:</strong> $email</p>
                </div>
            </section>
        </main>
        <footer>
            <div class='container'>
                <p>© 2023 Restaurante Elegante. Todos los derechos reservados.</p>
            </div>
        </footer>
    </body>
    </html>";

?>