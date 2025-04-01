<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['inventario_id'])) {
    $inventario_id = (int) $_GET['inventario_id'];
    try {
        $conn->beginTransaction(); 
        $sql_eliminar_inventario = "DELETE FROM Inventario WHERE InventarioID = $inventario_id";
        $conn->query($sql_eliminar_inventario);
        
        $conn->commit(); 
        header("Location: mostrar_inventario.php"); 
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "❌ Error al eliminar el inventario: " . $e->getMessage(); 
    }
} else {
    echo "❌ Error: ID de inventario no proporcionado.";
}
?>
