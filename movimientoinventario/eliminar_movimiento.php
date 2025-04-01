<?php
include '../conexion/conexion.php';
if (isset($_GET['movimiento_id'])) {
    $movimiento_id = (int) $_GET['movimiento_id'];
    try {
        $sql_delete = "DELETE FROM MovimientosDeInventario WHERE MovimientoID = :movimiento_id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(':movimiento_id', $movimiento_id);
        $stmt_delete->execute();
        echo "✅ Movimiento de inventario eliminado con éxito.";
        header("Location: mostrar_movimientos.php");
        exit;
    } catch (PDOException $e) {
        echo "❌ Error al eliminar el movimiento de inventario: " . $e->getMessage();
    }
} else {
    echo "❌ Error: ID de movimiento no proporcionado.";
    exit;
}
?>