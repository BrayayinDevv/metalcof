<?php
include 'db_connection.php';

if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];
    $total = isset($_GET['total']) ? $_GET['total'] : 0;

    // Obtener datos de la factura
    $query_factura = "SELECT * FROM factura WHERE id_factura = ?";
    $stmt_factura = $conn->prepare($query_factura);
    $stmt_factura->bind_param("i", $id_factura);
    $stmt_factura->execute();
    $result_factura = $stmt_factura->get_result();
    $factura = $result_factura->fetch_assoc();

    // Obtener detalle de productos
    $query_detalle = "SELECT * FROM detalle_factura WHERE id_factura = ?";
    $stmt_detalle = $conn->prepare($query_detalle);
    $stmt_detalle->bind_param("i", $id_factura);
    $stmt_detalle->execute();
    $result_detalle = $stmt_detalle->get_result();

    if ($factura) {
        echo "<h1>Factura #{$factura['id_factura']}</h1>";
        echo "<p><strong>Nombre:</strong> {$factura['nombre_cliente']}</p>";
        echo "<p><strong>Correo:</strong> {$factura['correo_cliente']}</p>";
        echo "<p><strong>Número de contacto:</strong> {$factura['numero_contacto']}</p>";
        echo "<p><strong>Dirección:</strong> {$factura['direccion_cliente']}</p>";
        echo "<p><strong>Método de Pago:</strong> {$factura['metodo_pago']}</p>";
        echo "<p><strong>Fecha:</strong> {$factura['fecha']}</p>";

        echo "<h2>Detalle de Productos</h2>";
        while ($detalle = $result_detalle->fetch_assoc()) {
            echo "<p><strong>Producto:</strong> {$detalle['nombre_producto']} 
                  <strong>Cantidad:</strong> {$detalle['cantidad']} 
                  <strong>Precio Unitario:</strong> {$detalle['precio_unitario']}</p>";
        }

        echo "<h2>Total: $total</h2>";
    } else {
        echo "Factura no encontrada.";
    }
} else {
    echo "ID de factura no especificado.";
}
?>

