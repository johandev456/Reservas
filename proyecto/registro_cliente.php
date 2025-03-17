<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Validar datos
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico no válido.";
    } else {
        

        $sql = "INSERT INTO Customers (name, email, phone, pass) VALUES ('$name', '$email', '$phone', '$password')";
        if ($conexion->query($sql) === TRUE) {
            header('Location: login_cliente.php?registro=exitoso');
            exit;
        } else {
            $error = "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <section class="registro">
            <div class="container">
                <h2>Registro de Cliente</h2>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST" action="registro_cliente.php">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="phone">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" required>
                    
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <button type="submit" class="btn">Registrarse</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'footer.html'; ?>
</body>
</html>