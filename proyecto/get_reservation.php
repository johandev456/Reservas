<?php
include 'conexion.php';

$id = intval($_GET['id']);
$sql = "SELECT Reservations.id, Reservations.reservation_date, Reservations.number_of_people, Customers.name AS customer_name, Customers.email AS customer_email, Customers.phone AS customer_phone, Mesas.table_number
        FROM Reservations
        JOIN Customers ON Reservations.customer_id = Customers.id
        JOIN Mesas ON Reservations.mesa_id = Mesas.id
        WHERE Reservations.id = $id";
$result = $conexion->query($sql);
$data = $result->fetch_assoc();


echo json_encode($data);
?>