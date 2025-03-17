<?php
include("conexion.php");
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes - Reserva Elegante</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <section class="hero">
            <div class="container">
                <h2>Elige tu Restaurante</h2>
                <p>Selecciona uno de nuestros restaurantes para hacer tu reserva.</p>
            </div>
        </section>

        <section class="restaurantes">
            <div class="container">
            <?php 
                $sql = "SELECT * FROM restaurants";
                $resultado = $conexion->query($sql);
                if ($resultado) {
                    if ($resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<div class='card'>";
                            echo "<img src='".$fila['image_url']."' alt='".$fila['name']."'>";
                            echo "<h3>".$fila['name']."</h3>";
                            echo "<p>".$fila['description']."</p>";
                            if(isset($_SESSION['customer_id'])){
                                echo "<a href='reservas.php?restaurante=".$fila['id']."' class='btn'>Reservar</a>";
                            }
                            else{
                                echo "<a href='login_cliente.php' class='btn'>Reservar</a>";
                            }
                           
                            echo "<a href='detalles.php?restaurante=".$fila['id']."' class='btn'>Ver Detalles</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No hay restaurantes disponibles en este momento.</p>";
                    }
                } else {
                    echo "<p>Error en la consulta: " . $conexion->error . "</p>";
                }
                ?>
                <div class="card">
                    <img src="https://st2.depositphotos.com/3690537/5231/i/450/depositphotos_52318349-stock-photo-dining-out.jpg" alt="Restaurante Italiano">
                    <h3>Restaurante Italiano</h3>
                    <p>Disfruta de la auténtica cocina italiana en un ambiente acogedor.</p>
                    <a href="reservas.html?restaurante=italiano" class="btn">Reservar</a>
                    <a href="detalles.html?restaurante=italiano" class="btn">Ver Detalles</a>
                </div>
                <div class="card">
                    <img src="https://st2.depositphotos.com/3386033/6930/i/450/depositphotos_69308469-stock-photo-elegant-restaurant-interior.jpg" alt="Restaurante Mexicano">
                    <h3>Restaurante Mexicano</h3>
                    <p>Saborea los mejores platillos mexicanos en un ambiente festivo.</p>
                    <a href="reservas.html?restaurante=mexicano" class="btn">Reservar</a>
                    <a href="detalles.html?restaurante=mexicano" class="btn">Ver Detalles</a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.html'; ?>
</body>
</html>