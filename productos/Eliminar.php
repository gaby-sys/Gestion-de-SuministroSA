<?php
include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['producto_id'])) {
    $producto_id = (int) $_GET['producto_id']; 

    try {
        $conn->beginTransaction();
        $sql_eliminar_referencias = "DELETE FROM ProductosProveedores WHERE ProductoID = $producto_id";
        $conn->query($sql_eliminar_referencias);
        $sql_eliminar_producto = "DELETE FROM Productos WHERE ProductoID = $producto_id";
        $conn->query($sql_eliminar_producto);
        $conn->commit();
        header("Location: mostrar_productos.php");
        exit;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "❌ Error al eliminar el producto: " . $e->getMessage();
    }
} else {
    echo "❌ Error: ID de producto no proporcionado.";
}
?>


