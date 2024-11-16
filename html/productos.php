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
    <header>
        <div class="logo">
            <h1>METALCOF</h1>
        </div>
        <nav>
            <ul>
                <li><a href="home.html">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="acerca.html">Acerca de Nosotros</a></li>
                <li><a href="carrito.html">Carrito</a></li>
            </ul>
        </nav>
    </header>

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
    
                                echo "<button onclick='agregarAlCarrito(".json_encode($producto) .")'>Agregar al Carrito</button>";
                                
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

    <script>
        function agregarAlCarrito(producto){
    

            datosCarrito = JSON.parse(localStorage.getItem("datosCarrito"))

            if(!datosCarrito || !datosCarrito[0] ){
                datosCarrito = [producto.id_producto+producto.nombre_producto:{...producto, cantidad:1}]
            }else{
                
            }



            console.log(datosCarrito)
            localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));

        }
    </script>
   
</body>
</html>
