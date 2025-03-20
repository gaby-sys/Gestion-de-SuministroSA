<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $proveedor_id = $_POST['proveedor_id'];
    $metodo_pago = $_POST['metodo_pago'];
    $monto_total = $_POST['monto_total'];
    $estado = $_POST['estado'];
    $fecha_compra = $_POST['fecha_compra'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $numero_factura = $_POST['numero_factura'];
    try {
        $sql = "INSERT INTO Compras (ClienteID, ProveedorID, MetodoPago, MontoTotal, Estado, FechaCompra, FechaEntrega, NumeroFactura)
                VALUES (:cliente_id, :proveedor_id, :metodo_pago, :monto_total, :estado, :fecha_compra, :fecha_entrega, :numero_factura)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':proveedor_id', $proveedor_id);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':monto_total', $monto_total);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha_compra', $fecha_compra);
        $stmt->bindParam(':fecha_entrega', $fecha_entrega);
        $stmt->bindParam(':numero_factura', $numero_factura);
        if ($stmt->execute()) {
            echo "Compra registrada correctamente.";
            header("Location: mostrar_compras.php");
            exit;
        } else {
            echo "❌ Error al registrar la compra.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>