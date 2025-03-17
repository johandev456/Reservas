<header>
    <div class="container">
        <h1>Restaurante Elegante</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
               
                <li><a href="contacto.php">Contacto</a></li>
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <li><a href="admin_reservas.php">Administrar Reservas</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php elseif (isset($_SESSION['customer_id'])): ?>
                    <li><a href="mis_reservas.php">Mis Reservas</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                    
                <?php else: ?>
                    
                    <li><a href="registro_cliente.php">Registro</a></li>
                    <li><a href="login_cliente.php">Login</a></li>
                  
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>