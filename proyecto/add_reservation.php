<?php
include 'conexion.php';

$reservation_date = $_POST['reservation_date'];
$number_of_people = intval($_POST['number_of_people']);
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$customer_phone = $_POST['customer_phone'];
$table_number = intval($_POST['table_number']);

// Insertar cliente si no existe
$sql_customer = "INSERT INTO Customers (name, email, phone,pass) VALUES ('$customer_name', '$customer_email', '$customer_phone','1234')
                 ON DUPLICATE KEY UPDATE name = VALUES(name), email = VALUES(email), phone = VALUES(phone)";
if ($conexion->query($sql_customer) === TRUE) {
    $customer_id = $conexion->insert_id ?: $conexion->query("SELECT id FROM Customers WHERE email = '$customer_email'")->fetch_assoc()['id'];

    // Insertar reserva
    $sql_reservation = "INSERT INTO Reservations (reservation_date, number_of_people, customer_id, mesa_id, restaurant_id)
                        VALUES ('$reservation_date', $number_of_people, $customer_id, $table_number, 1)";
    if ($conexion->query($sql_reservation) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar la reserva: ' . $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al insertar el cliente: ' . $conexion->error]);
}
?>