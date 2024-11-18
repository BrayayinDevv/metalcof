<?php

    include 'db_connection.php';
    include "controllers/productoController.php";
    

    $productoController = new ProductoController($conn);
    $productos = $productoController->consultarProductos();

    $categorias = [];
    foreach ($productos as $producto) {
        if(!in_array($producto["categoria_producto"], $categorias)){
            array_push($categorias, $producto["categoria_producto"]);
        }
    }


    function darFormatoPrecioCo ($precio){
        return "$" . number_format($precio, 2, '.', ',');
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - METALCOF</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
    include 'header.php';

    ?>

    <main id="productos">
        <h2>Nuestros Productos</h2>
        <div class="header">

            <form class="search-bar" onsubmit="event.preventDefault();">
                <input type="text" name="busqueda" placeholder="Buscar productos..." onkeyup="buscarProductos()">
                <button type="button" onclick="buscarProductos()">🔍</button>
            </form>  
        </div>
        <section class="product-section">
            <br>
            <br>

            <?php

                foreach ($categorias as $categoria) {
                    echo "<h3>". $categoria ."</h3>";
                    echo "<div class='product-grid'>";
                    
                    foreach ($productos as $producto) {

                        if($categoria == $producto["categoria_producto"]){
                            echo "<div class='product-card'>";
    
                                echo "<img src='". $producto["imagen_producto"]  ."' alt='". $producto["nombre_producto"] ."'>";
    
                                echo "<h4>". $producto["nombre_producto"] ."</h4>";
    
                                echo "<p>". $producto["descripcion_producto"] ."</p>";
    
                                echo "<span class='price'>". darFormatoPrecioCo($producto["precio_producto"]) ."</span>";
    
                                echo "<button onclick='agregarAlCarrito(".htmlspecialchars(json_encode($producto)) .")'>Agregar al Carrito</button>";
                                
                            echo "</div>";
                        }

                    }
                    
                    echo "</div>";

                }

            ?>


    </main>
    <footer>
        <p>&copy; 2024 METALCOF. Todos los derechos reservados.</p>
    </footer>


    <script src="script.js"></script>
</body>
</html>
