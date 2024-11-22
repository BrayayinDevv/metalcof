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
        <br>
        <br>
            <h3>Total: <span id="cart-total">$0</span></h3>
        <br>
        <form action="procesar_pago.php" method="POST">
            <label for="nombre_cliente">Nombre:</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" required>
            <label for="correo_cliente">Correo Electrónico:</label>
            <input type="email" name="correo_cliente" id="correo_cliente" required>
            <label for="numero_contacto">Número de Contacto:</label>
            <input type="text" name="numero_contacto" id="numero_contacto" required>
            <label for="direccion_cliente">Dirección:</label>
            <input type="text" name="direccion_cliente" id="direccion_cliente" required>
            <label for="metodo_pago">Método de Pago:</label>
            <select name="metodo_pago" id="metodo_pago" required>
                <option value="PSE">PSE</option>
                <option value="Débito">Débito</option>
                <option value="Crédito">Crédito</option>
            </select>
            <input type="hidden" name="productos" id="productos">
            <button type="submit">Realizar el pago</button>
        </form>

        <div id="factura-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Factura Generada</h2>
                <div id="factura-detalles"></div>
            </div>
        </div>
<script>
    //datos del carrito están en localStorage
    document.getElementById('productos').value = localStorage.getItem('datosCarrito');
</script>


    </main>
    <footer class="footer">
        © 2024 METALCOF. Todos los derechos reservados.
    </footer>

    <script src="script.js"></script>


<script>
        //Agregar productos al carrito para comprar
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

        //Eliminar producto del carrito para comprar
        function eliminarProd(idProd){
            let datosCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};
            delete datosCarrito[idProd]
            
            localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));

            location.reload();
        }

        //Cambia numero a pesos
        function formatoPesos(numero){
            return numero.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
        }

        document.querySelector("form").addEventListener("submit", function (e) {
            e.preventDefault(); // Previene el envío estandar del formulario

            const formData = new FormData(this);

        fetch("procesar_pago.php", {
            method: "POST",
            body: formData,
    })
        .then((response) => response.text())
        .then((data) => {

            // Inserta datos de la factura en el modal
            document.getElementById("factura-detalles").innerHTML = data;

            // Mostrar el modal
            const modal = document.getElementById("factura-modal");
            modal.style.display = "flex";

            // Agrega funcionalidad para cerrar el modal
            document.querySelector(".close-btn").onclick = function () {
                modal.style.display = "none";
            };
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Hubo un problema al procesar la solicitud.");
        });
});
</script>
</body>
</html>