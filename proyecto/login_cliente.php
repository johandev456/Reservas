<?php
include 'conexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM Customers WHERE email = '$email'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['pass']) {
            $_SESSION['customer_id'] = $row['id'];
            $_SESSION['customer_email'] = $row['email'];

            // Guardar la IP del usuario
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $update_ip_sql = "UPDATE Customers SET last_ip = '$user_ip' WHERE id = {$row['id']}";
            $conexion->query($update_ip_sql);

            header('Location: index.php');
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "No se encontró una cuenta con ese correo electrónico.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="login">
            <div class="container">
                <h2>Iniciar Sesión - Cliente</h2>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
                    <p class="success">Registro exitoso. Ahora puedes iniciar sesión.</p>
                <?php endif; ?>
                <form method="POST" action="login_cliente.php">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <button type="submit" class="btn">Iniciar Sesión</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'footer.html'; ?>
</body>
</html>