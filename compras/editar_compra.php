<?php
$serverName = "GABY\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['compra_id'])) {
        $compraID = $_GET['compra_id'];
        $sql = "SELECT * FROM Compras WHERE CompraID = :compra_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':compra_id', $compraID);
        $stmt->execute();
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compra_id'])) {
        $compraID = $_POST['compra_id'];
        $clienteID = $_POST['cliente_id'];
        $proveedorID = $_POST['proveedor_id'];
        $metodoPago = $_POST['metodo_pago'];
        $montoTotal = $_POST['monto_total'];
        $estado = $_POST['estado'];
        $fechaCompra = $_POST['fecha_compra'];
        $fechaEntrega = $_POST['fecha_entrega'];
        $numeroFactura = $_POST['numero_factura'];
        $sqlUpdate = "UPDATE Compras 
                      SET ClienteID = :cliente_id, 
                          ProveedorID = :proveedor_id, 
                          MetodoPago = :metodo_pago, 
                          MontoTotal = :monto_total, 
                          Estado = :estado, 
                          FechaCompra = :fecha_compra, 
                          FechaEntrega = :fecha_entrega, 
                          NumeroFactura = :numero_factura
                      WHERE CompraID = :compra_id";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':cliente_id', $clienteID);
        $stmtUpdate->bindParam(':proveedor_id', $proveedorID);
        $stmtUpdate->bindParam(':metodo_pago', $metodoPago);
        $stmtUpdate->bindParam(':monto_total', $montoTotal);
        $stmtUpdate->bindParam(':estado', $estado);
        $stmtUpdate->bindParam(':fecha_compra', $fechaCompra);
        $stmtUpdate->bindParam(':fecha_entrega', $fechaEntrega);
        $stmtUpdate->bindParam(':numero_factura', $numeroFactura);
        $stmtUpdate->bindParam(':compra_id', $compraID);
        if ($stmtUpdate->execute()) {
            echo "¡Compra actualizada exitosamente!";
            header("Location: mostrar_compras.php");
            exit;
        } else {
            echo "Error al actualizar la compra.";
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📦 Editar Compra - Suministros S.A. 📦</h1>
    </header>
    <main>
        <section id="formulario_compra">
            <h2>🛠️ Actualizar Compra</h2>
            <form action="editar_compra.php" method="POST">
                <input type="hidden" name="compra_id" value="<?php echo $compra['CompraID']; ?>">

                <label for="cliente_id">👤 Cliente ID:</label>
                <input type="number" id="cliente_id" name="cliente_id" value="<?php echo $compra['ClienteID']; ?>" required><br><br>

                <label for="proveedor_id">🏢 Proveedor ID:</label>
                <input type="number" id="proveedor_id" name="proveedor_id" value="<?php echo $compra['ProveedorID']; ?>" required><br><br>

                <label for="metodo_pago">💳 Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required>
                    <option value="Efectivo" <?php if ($compra['MetodoPago'] == 'Efectivo') echo 'selected'; ?>>💵 Efectivo</option>
                    <option value="Transferencia Bancaria" <?php if ($compra['MetodoPago'] == 'Transferencia Bancaria') echo 'selected'; ?>>🏦 Transferencia Bancaria</option>
                    <option value="Cheque" <?php if ($compra['MetodoPago'] == 'Cheque') echo 'selected'; ?>>📑 Cheque</option>
                    <option value="Tarjeta de Crédito" <?php if ($compra['MetodoPago'] == 'Tarjeta de Crédito') echo 'selected'; ?>>💳 Tarjeta de Crédito</option>
                </select><br><br>

                <label for="monto_total">💵 Monto Total:</label>
                <input type="number" id="monto_total" name="monto_total" step="0.01" value="<?php echo $compra['MontoTotal']; ?>" required><br><br>

                <label for="estado">📦 Estado de la Compra:</label>
                <select id="estado" name="estado" required>
                    <option value="Pendiente" <?php if ($compra['Estado'] == 'Pendiente') echo 'selected'; ?>>⏳ Pendiente</option>
                    <option value="En tránsito" <?php if ($compra['Estado'] == 'En tránsito') echo 'selected'; ?>>🚚 En tránsito</option>
                    <option value="Entregada" <?php if ($compra['Estado'] == 'Entregada') echo 'selected'; ?>>✅ Entregada</option>
                    <option value="Cancelada" <?php if ($compra['Estado'] == 'Cancelada') echo 'selected'; ?>>❌ Cancelada</option>
                </select><br><br>

                <label for="fecha_compra">📅 Fecha de Compra:</label>
                <input type="date" id="fecha_compra" name="fecha_compra" value="<?php echo $compra['FechaCompra']; ?>" required><br><br>

                <label for="fecha_entrega">📦 Fecha de Entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo $compra['FechaEntrega']; ?>" required><br><br>

                <label for="numero_factura">🧾 Número de Factura:</label>
                <input type="text" id="numero_factura" name="numero_factura" value="<?php echo $compra['NumeroFactura']; ?>" required><br><br>

                <button type="submit">💾 Actualizar Compra</button>
                <button type="button" onclick="window.location.href='mostrar_compras.php'">📋 Ver Compras Registradas</button>
            </form> </section></main>
</body>
</html>