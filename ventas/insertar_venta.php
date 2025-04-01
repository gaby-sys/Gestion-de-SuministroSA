<?php
$serverName = "GABY\\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $clienteID = $_POST['cliente'];
        $fechaVenta = $_POST['fecha_venta'];
        $numeroFactura = $_POST['numero_factura'];
        $montoTotal = $_POST['monto_total'];
        $metodoPago = $_POST['metodo_pago'];
        $condicionPago = $_POST['condicion_pago'];
        $fechaEntrega = $_POST['fecha_entrega'];
        $estadoVenta = $_POST['estado_venta'];
        $observaciones = $_POST['observaciones'];
        $sqlVenta = "INSERT INTO Ventas (ClienteID, FechaVenta, NumeroFactura, MontoTotal, MetodoPago, CondicionPago, FechaEntrega, EstadoVenta, Observaciones) 
                     VALUES (:clienteID, :fechaVenta, :numeroFactura, :montoTotal, :metodoPago, :condicionPago, :fechaEntrega, :estadoVenta, :observaciones)";
        
        $stmtVenta = $conexion->prepare($sqlVenta);
        $stmtVenta->bindParam(':clienteID', $clienteID);
        $stmtVenta->bindParam(':fechaVenta', $fechaVenta);
        $stmtVenta->bindParam(':numeroFactura', $numeroFactura);
        $stmtVenta->bindParam(':montoTotal', $montoTotal);
        $stmtVenta->bindParam(':metodoPago', $metodoPago);
        $stmtVenta->bindParam(':condicionPago', $condicionPago);
        $stmtVenta->bindParam(':fechaEntrega', $fechaEntrega);
        $stmtVenta->bindParam(':estadoVenta', $estadoVenta);
        $stmtVenta->bindParam(':observaciones', $observaciones);
        if ($stmtVenta->execute()) {
            $ventaID = $conexion->lastInsertId();
            if (isset($_POST['producto']) && isset($_POST['cantidad']) && isset($_POST['precio_unitario'])) {
                $productoID = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $precioUnitario = $_POST['precio_unitario'];
                $subtotal = $cantidad * $precioUnitario;
$sqlDetalle = "INSERT INTO DetalleDeVentas (VentaID, ProductoID, Cantidad, PrecioUnitario)
VALUES (:ventaID, :productoID, :cantidad, :precioUnitario)";
$stmtDetalle = $conexion->prepare($sqlDetalle);
$stmtDetalle->bindParam(':ventaID', $ventaID);
$stmtDetalle->bindParam(':productoID', $productoID);
$stmtDetalle->bindParam(':cantidad', $cantidad);
$stmtDetalle->bindParam(':precioUnitario', $precioUnitario);

if ($stmtDetalle->execute()) {
header("Location: mostrar_ventas.php");
exit;
} else {echo "❌ Error al insertar los detalles de la venta.";
}} else {
                echo "❌ No se han proporcionado productos para la venta.";
            }
        } else {
            echo "❌ Error al insertar la venta.";} }
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>