<?php
$serverName = "GABY\\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['venta_id'])) {
        $ventaID = $_GET['venta_id'];
        $sqlVenta = "SELECT * FROM Ventas WHERE VentaID = :venta_id";
        $stmtVenta = $conexion->prepare($sqlVenta);
        $stmtVenta->bindParam(':venta_id', $ventaID);
        $stmtVenta->execute();
        $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);
        if (!$venta) {
            echo "❌ Venta no encontrada.";
            exit;
        }
        $sqlDetalle = "SELECT * FROM DetalleDeVentas WHERE VentaID = :venta_id";
        $stmtDetalle = $conexion->prepare($sqlDetalle);
        $stmtDetalle->bindParam(':venta_id', $ventaID);
        $stmtDetalle->execute();
        $detalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC);
        if (!$detalle) {
            echo "❌ Detalles de la venta no encontrados.";
            exit;
        }  }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['venta_id'])) {
        $ventaID = $_POST['venta_id'];
        $detalleID = $_POST['detalle_id']; 
        $clienteID = $_POST['cliente_id'];
        $fechaVenta = $_POST['fecha_venta'];
        $numeroFactura = $_POST['numero_factura'];
        $montoTotal = $_POST['monto_total'];
        $metodoPago = $_POST['metodo_pago'];
        $condicionPago = $_POST['condicion_pago'];
        $fechaEntrega = $_POST['fecha_entrega'];
        $estadoVenta = $_POST['estado_venta'];
        $observaciones = $_POST['observaciones'];
        $sqlUpdate = "UPDATE Ventas SET ClienteID = :cliente_id, FechaVenta = :fecha_venta, NumeroFactura = :numero_factura, 
                      MontoTotal = :monto_total, MetodoPago = :metodo_pago, CondicionPago = :condicion_pago, 
                      FechaEntrega = :fecha_entrega, EstadoVenta = :estado_venta, Observaciones = :observaciones 
                      WHERE VentaID = :venta_id";
        
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':cliente_id', $clienteID);
        $stmtUpdate->bindParam(':fecha_venta', $fechaVenta);
        $stmtUpdate->bindParam(':numero_factura', $numeroFactura);
        $stmtUpdate->bindParam(':monto_total', $montoTotal);
        $stmtUpdate->bindParam(':metodo_pago', $metodoPago);
        $stmtUpdate->bindParam(':condicion_pago', $condicionPago);
        $stmtUpdate->bindParam(':fecha_entrega', $fechaEntrega);
        $stmtUpdate->bindParam(':estado_venta', $estadoVenta);
        $stmtUpdate->bindParam(':observaciones', $observaciones);
        $stmtUpdate->bindParam(':venta_id', $ventaID);

        if ($stmtUpdate->execute()) {
            $productoID = $_POST['producto'];
            $cantidad = $_POST['cantidad'];
            $precioUnitario = $_POST['precio_unitario'];
            $subtotal = $cantidad * $precioUnitario;

            $sqlUpdateDetalle = "UPDATE DetalleDeVentas 
                                 SET ProductoID = :producto, Cantidad = :cantidad, PrecioUnitario = :precio_unitario
                                 WHERE DetalleID = :detalle_id";  

            $stmtUpdateDetalle = $conexion->prepare($sqlUpdateDetalle);
            $stmtUpdateDetalle->bindParam(':producto', $productoID);
            $stmtUpdateDetalle->bindParam(':cantidad', $cantidad);
            $stmtUpdateDetalle->bindParam(':precio_unitario', $precioUnitario);
            $stmtUpdateDetalle->bindParam(':detalle_id', $detalleID); 

            if ($stmtUpdateDetalle->execute()) {
                header("Location: mostrar_ventas.php");
                exit;
            } else {
                echo "❌ Error al actualizar el detalle de la venta.";
            }
        } else {
            echo "❌ Error al actualizar la venta.";}}} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Venta</title>
    <link rel="stylesheet" href="crudcito.css">
</head><body> <header>
        <h1>🛒 Actualización de Venta</h1>  </header> <main>
        <section id="formulario">
            <h2>📝 Actualizar Venta</h2>
            <form action="update_venta.php" method="POST">
                <input type="hidden" name="venta_id" value="<?php echo $venta['VentaID']; ?>">
                <input type="hidden" name="detalle_id" value="<?php echo $detalle['DetalleID']; ?>"> 

                <label for="cliente">👤 Cliente:</label>
                <input type="text" id="cliente" name="cliente_id" placeholder="ID del cliente" value="<?php echo htmlspecialchars($venta['ClienteID']); ?>" required>

                <label for="fecha_venta">📅 Fecha de Venta:</label>
                <input type="date" id="fecha_venta" name="fecha_venta" value="<?php echo $venta['FechaVenta']; ?>" required><br><br>

                <label for="numero_factura">🧾 Número de Factura:</label>
                <input type="text" id="numero_factura" name="numero_factura" placeholder="Ejemplo: F12345" value="<?php echo htmlspecialchars($venta['NumeroFactura']); ?>" required><br><br>

                <label for="monto_total">💵 Monto Total:</label>
                <input type="number" id="monto_total" name="monto_total" placeholder="Monto total de la venta" step="0.01" value="<?php echo $venta['MontoTotal']; ?>" required><br><br>

                <label for="metodo_pago">💳 Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required>
                    <option value="Efectivo" <?php echo ($venta['MetodoPago'] == 'Efectivo') ? 'selected' : ''; ?>>💵 Efectivo</option>
                    <option value="Tarjeta" <?php echo ($venta['MetodoPago'] == 'Tarjeta') ? 'selected' : ''; ?>>💳 Tarjeta</option>
                    <option value="Transferencia" <?php echo ($venta['MetodoPago'] == 'Transferencia') ? 'selected' : ''; ?>>🏦 Transferencia</option>
                </select><br><br>

                <label for="condicion_pago">📜 Condición de Pago:</label>
                <input type="text" id="condicion_pago" name="condicion_pago" placeholder="Ejemplo: Contado" value="<?php echo htmlspecialchars($venta['CondicionPago']); ?>" required><br><br>

                <label for="fecha_entrega">🚚 Fecha de Entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo $venta['FechaEntrega']; ?>"><br><br>

                <label for="estado_venta">Estado de la Venta:</label>
                <select id="estado_venta" name="estado_venta" required>
                    <option value="Entregada" <?php echo ($venta['EstadoVenta'] == 'Entregada') ? 'selected' : ''; ?>>📦 Entregada</option>
                    <option value="Pagada" <?php echo ($venta['EstadoVenta'] == 'Pagada') ? 'selected' : ''; ?>>💰 Pagada</option>
                </select><br><br>

                <label for="observaciones">📝 Observaciones:</label>
                <textarea id="observaciones" name="observaciones" placeholder="Comentarios adicionales"><?php echo htmlspecialchars($venta['Observaciones']); ?></textarea><br><br>

                <h3>🎲 Detalle de Venta</h3>
                <label for="producto">📦 Producto:</label>
                <input type="text" id="producto" name="producto" value="<?php echo $detalle['ProductoID']; ?>" required><br><br>

                <label for="cantidad">🔢 Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" value="<?php echo $detalle['Cantidad']; ?>" required><br><br>

                <label for="precio_unitario">💰 Precio Unitario:</label>
                <input type="number" id="precio_unitario" name="precio_unitario" step="0.01" value="<?php echo $detalle['PrecioUnitario']; ?>" required><br><br>

                <button type="submit">💾 Guardar Cambios</button>
            </form></section></main></body></html>