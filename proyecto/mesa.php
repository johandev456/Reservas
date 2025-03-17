<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas Disponibles - Restaurante Elegante</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="mesas">
            <div class="container">
                <h2 id="restaurant-name">Mesas Disponibles</h2>
                <ul id="mesa-list">
                    <!-- Las mesas se llenarán dinámicamente -->
                </ul>
            </div>
        </section>
    </main>

    <?php include 'footer.html'; ?>

    <script>
        // Obtener el parámetro de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const restaurante = urlParams.get('restaurante');
        const restaurantNameElement = document.getElementById('restaurant-name');
        const mesaList = document.getElementById('mesa-list');

        if (restaurante === 'italiano') {
            restaurantNameElement.textContent = 'Mesas Disponibles en Restaurante Italiano';
            mesaList.innerHTML = `
                <li>Mesa 1 (4 personas)</li>
                <li>Mesa 2 (4 personas)</li>
                <li>Mesa 3 (6 personas)</li>
            `;
        } else if (restaurante === 'mexicano') {
            restaurantNameElement.textContent = 'Mesas Disponibles en Restaurante Mexicano';
            mesaList.innerHTML = `
                <li>Mesa 1 (4 personas)</li>
                <li>Mesa 2 (4 personas)</li>
                <li>Mesa 3 (6 personas)</li>
                <li>Mesa 4 (8 personas)</li>
            `;
        }
    </script>
</body>
</html>