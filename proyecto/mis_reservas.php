<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header('Location: login_cliente.php');
    exit;
}

$cliente_id = $_SESSION['customer_id'];

$sql = "SELECT Reservations.id, reservation_date, number_of_people, Mesas.table_number
        FROM Reservations
        JOIN Mesas ON Reservations.mesa_id = Mesas.id
        WHERE Reservations.customer_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Mis Reservas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Fecha y Hora</th>
                <th>Número de Personas</th>
                <th>Número de Mesa</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['id']) ?></td>
                    <td><?= htmlspecialchars($fila['reservation_date']) ?></td>
                    <td><?= htmlspecialchars($fila['number_of_people']) ?></td>
                    <td><?= htmlspecialchars($fila['table_number']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.html'; ?>

</body>
</html>