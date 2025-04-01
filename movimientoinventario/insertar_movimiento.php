<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inventario_id = (int) $_POST['inventario_id'];
    $tipo_movimiento = $_POST['tipo_movimiento'];
    $cantidad = (int) $_POST['cantidad'];
    $fecha = $_POST['fecha_movimiento']; 
    $observaciones = $_POST['motivo']; 
    try {
        $sql = "INSERT INTO MovimientosDeInventario (InventarioID, TipoMovimiento, Cantidad, FechaMovimiento, Motivo) 
                VALUES (:inventario_id, :tipo_movimiento, :cantidad, :fecha, :observaciones)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':inventario_id', $inventario_id);
        $stmt->bindParam(':tipo_movimiento', $tipo_movimiento);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':observaciones', $observaciones);

        $stmt->execute();
        echo "✅ Movimiento de Inventario agregado con éxito.";
        header("Location: mostrar_movimientos.php");
        exit;

    } catch (PDOException $e) {
        echo "❌ Error al insertar el movimiento de inventario: " . $e->getMessage();}}?>