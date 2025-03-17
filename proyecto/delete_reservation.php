<?php
include 'conexion.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM Reservations WHERE id = $id";
if ($conexion->query($sql) === TRUE) {
    echo "Reserva eliminada exitosamente.";
    header('Location: admin_reservas.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}
?>