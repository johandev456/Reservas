<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php');
    exit;
}

$sql = "SELECT Reservations.id, Reservations.reservation_date, Reservations.number_of_people, Customers.name AS customer_name, Customers.email, Customers.phone, Mesas.table_number
        FROM Reservations
        JOIN Customers ON Reservations.customer_id = Customers.id
        JOIN Mesas ON Reservations.mesa_id = Mesas.id
        WHERE Reservations.restaurant_id = 1"; // Ajusta el ID del restaurante según sea necesario
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Reservas</title>
    <link rel="stylesheet" href="styles.css">
    <script src="admin_reservas.js" defer></script>
    
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <section class="admin-reservas">
            <div class="container">
                <h2>Administración de Reservas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha y Hora</th>
                            <th>Personas</th>
                            <th>Cliente</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Mesa</th>
                            <th>Acciones</th>
                            <th><button onclick="openModal('add')">Agregar</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['reservation_date']; ?></td>
                            <td><?php echo $row['number_of_people']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['table_number']; ?></td>
                            <td>
                            <button onclick="openModal('edit', <?= $row['id'] ?>)">Editar</button>                            </td>
                            <td>
                            <button onclick="window.location.href='delete_reservation.php?id=<?= $row['id'] ?>'">Eliminar</button>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Overlay -->
<div id="modal-overlay" class="modal-overlay hidden"></div>

<!-- Modal -->
<div id="modal" class="modal-container hidden">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <form id="reservation-form" method="post" onsubmit="saveReservation(event)">
      <input type="hidden" id="reservation-id">
      <label>Fecha y Hora:</label>
      <input type="datetime-local" id="reservation-date" required>
      <label>Personas:</label>
      <input type="number" id="number-of-people" required>
      <label>Cliente:</label>
      <input type="text" id="customer-name" required>
      <label>Email:</label>
      <input type="text" id="customer-email" required>
      <label>Teléfono:</label>
      <input type="text" id="customer-phone" required>
      <label>Mesa:</label>
      <input type="number" id="table-number" required>
      <button type="submit">Guardar</button>
    </form>
  </div>
</div>




    <?php include 'footer.html'; ?>

    
</body>
</html>