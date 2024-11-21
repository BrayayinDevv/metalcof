<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_cliente'];
    $correo = $_POST['correo_cliente'];
    $numero = $_POST['numero_contacto'];
    $direccion = $_POST['direccion_cliente'];
    $metodo_pago = $_POST['metodo_pago'];
    $productos_json = $_POST['productos'];
    $productos = json_decode($productos_json, true);

    if (empty($productos)) {
        die("Error: El carrito está vacío.");
    }

    // Validar campos
    if (empty($nombre) || empty($correo) || empty($numero) || empty($direccion) || empty($metodo_pago)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Calcular el total
    $total = 0;
    foreach ($productos as $producto) {
        $total += $producto['precio_producto'] * $producto['cantidad'];
    }

    // Insertar en la tabla factura
    $query_factura = "INSERT INTO factura (nombre_cliente, correo_cliente, numero_contacto, direccion_cliente, metodo_pago) 
                      VALUES (?, ?, ?, ?, ?)";
    $stmt_factura = $conn->prepare($query_factura);
    $stmt_factura->bind_param("sssss", $nombre, $correo, $numero, $direccion, $metodo_pago);

    if ($stmt_factura->execute()) {
        $id_factura = $stmt_factura->insert_id;

        // Insertar los productos en la tabla detalle_factura
        $query_detalle = "INSERT INTO detalle_factura (id_factura, nombre_producto, cantidad, precio_unitario) 
                          VALUES (?, ?, ?, ?)";
        $stmt_detalle = $conn->prepare($query_detalle);

        foreach ($productos as $producto) {
            $stmt_detalle->bind_param(
                "isid",
                $id_factura,
                $producto['nombre_producto'],
                $producto['cantidad'],
                $producto['precio_producto']
            );
            $stmt_detalle->execute();
        }

        header("Location: factura.php?id_factura=$id_factura&total=$total");
        exit;
    } else {
        echo "Error al procesar el pago: " . $conn->error;
    }
    
}
?>
