<?php
session_start();

// Verifica si el usuario ha iniciado sesion
if (!isset($_SESSION['nombre_usuario'])) {
    exit();
}
//Obtieen el nombre del usuario de la base de datos
$nombreUsuario = $_SESSION['nombre_usuario']; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inicio - METALCOF</title>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <h1>METALCOF</h1>
                <h1 class="main-title">Estufas y Hornos de Calidad</h1>
            </div>
            <div class="bienvenida">
                <p>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>! 👋</p>
            </div>
            <div class="logout">
                <a href="index.html" class="logout-button">Salir</a>
            </div>
        </div>
        <br>
        <nav>
            <ul>
                <li><a href="home.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="acerca.php">Acerca de Nosotros</a></li>
                <li><a href="carrito.php">Carrito</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>