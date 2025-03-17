<?php
include 'conexion.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Restaurante Elegante</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <section class="reservas">
            <div class="container">
                <h2 id="restaurant-name">Haz tu Reserva</h2>
                <form id="reservation-form" method="POST" action="procesar_reserva.php">
                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date" required>
                    
                    <label for="table">Personas:</label>
                    <select id="table" name="table" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    
                    <label for="time">Hora:</label>
                    <select id="time" name="time" required>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    
                    <input type="hidden" name="restaurant_id" value="<?php echo $_GET['restaurante']; ?>">
                    
                    <button type="submit" class="btn">Confirmar Reserva</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'footer.html'; ?>

    <script>
        document.getElementById("table").addEventListener("change", function() {
            var personas = this.value;
            fetchHorasDisponibles(personas);
        });

        document.getElementById("date").addEventListener("change", function() {
            var personas = document.getElementById("table").value;
            fetchHorasDisponibles(personas);
        });

        function fetchHorasDisponibles(personas) {
            var date = document.getElementById("date").value;
            var restaurante = new URLSearchParams(window.location.search).get('restaurante');
            fetch("fetch_horas.php?personas=" + personas + "&date=" + date + "&restaurante=" + restaurante)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var timeSelect = document.getElementById("time");
                    timeSelect.innerHTML = "";
                    data.forEach(hora => {
                        var option = document.createElement("option");
                        option.value = hora;
                        option.textContent = hora;
                        timeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching hours:', error));
        }

        // Obtener el parámetro de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const restaurante = urlParams.get('restaurante');

        // Mostrar el nombre del restaurante en la página de reservas
        const restaurantNameElement = document.getElementById('restaurant-name');

        if (restaurante === 'italiano') {
            restaurantNameElement.textContent = 'Haz tu Reserva en Restaurante Italiano';
        } else if (restaurante === 'mexicano') {
            restaurantNameElement.textContent = 'Haz tu Reserva en Restaurante Mexicano';
        }
    </script>
</body>
</html>