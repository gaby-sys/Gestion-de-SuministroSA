<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['compra_id'])) {
    $compra_id = (int) $_GET['compra_id'];
    try {
        $conn->beginTransaction(); 
        $sql_eliminar_referencias = "DELETE FROM DetalleCompras WHERE CompraID = $compra_id";
        $conn->query($sql_eliminar_referencias);
        $sql_eliminar_compra = "DELETE FROM Compras WHERE CompraID = $compra_id";
        $conn->query($sql_eliminar_compra);
        $conn->commit(); 
        header("Location: mostrar_compras.php"); 
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "❌ Error al eliminar la compra: " . $e->getMessage(); 
    }
} else {
    echo "❌ Error: ID de compra no proporcionado."; }
?>