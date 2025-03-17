<?php
include 'conexion.php';

$id = intval($_POST['id']);
$reservation_date = $_POST['reservation_date'];
$number_of_people = intval($_POST['number_of_people']);
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$customer_phone = $_POST['customer_phone'];
$table_number = intval($_POST['table_number']);

// Actualizar cliente
$sql_customer = "UPDATE Customers SET name = '$customer_name', email = '$customer_email', phone = '$customer_phone'
                 WHERE id = (SELECT customer_id FROM Reservations WHERE id = $id)";
if ($conexion->query($sql_customer) === TRUE) {
    // Actualizar reserva
    $sql_reservation = "UPDATE Reservations SET reservation_date = '$reservation_date', number_of_people = $number_of_people, mesa_id = $table_number
                        WHERE id = $id";
    if ($conexion->query($sql_reservation) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la reserva: ' . $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el cliente: ' . $conexion->error]);
}
?>