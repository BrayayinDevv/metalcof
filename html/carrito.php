<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - METALCOF</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'header.php';

    ?>

    <main id="carrito">
        <h2>Carrito de Compras</h2>
        <div id="cart-items">

            
            

        </div>
        <div class="total">
            <h3>Total: <span id="cart-total">$0</span></h3>
            <button onclick="checkout()">Realizar Compra</button>
        </div>
    </main>

    <footer class="footer">
        © 2024 METALCOF. Todos los derechos reservados.
    </footer>

    <script src="script.js"></script>


    <script>
        //Agregar productos al carrito
        const contenedorProd =document.getElementById("cart-items");
        const totalProdSpan =document.getElementById("cart-total");
        
        const productosEnCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};

        
        console.log(productosEnCarrito)

        let htmlText = "";

        let totalPedido = 0;
        for (const key in productosEnCarrito) {
            if (Object.prototype.hasOwnProperty.call(productosEnCarrito, key)) {
                const element = productosEnCarrito[key];
                console.log(key)

                htmlText +=`
                    <div class="producto">
                        <img src="${element.imagen_producto}" alt="${element.nombre_producto}">
                        <div class="info-producto">
                            <h3>${element.nombre_producto}</h3>
                            <p>${element.descripcion_producto}</p>
                            <span class="precio">${formatoPesos(element.precio_producto)}</span>
                            <span class="cantidad">Cantidad: ${element.cantidad}</span>
                        </div>
                        <div class="acciones-producto">
                            <button onclick='eliminarProd(${key})'>Eliminar</button>
                        </div>
                    </div>
                    <hr>
                `;

                totalPedido += element.precio_producto * element.cantidad;

            }
        }

        contenedorProd.innerHTML = htmlText;
        totalProdSpan.innerHTML = formatoPesos(totalPedido);

        //Eliminar producto del carrito
        function eliminarProd(idProd){
            let datosCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};
            delete datosCarrito[idProd]
            
            localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));

            location.reload();
        }

        //cambiar numero a pesos
        function formatoPesos(numero){
            return numero.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
        }

    </script>
</body>
</html>