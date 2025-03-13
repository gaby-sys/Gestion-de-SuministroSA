<?php
include '../conexion/conexion.php';


if (isset($_GET['proveedor_id'])) {
    $proveedor_id = $_GET['proveedor_id'];
    $checkProductosSql = "SELECT COUNT(*) FROM ProductosProveedores WHERE ProveedorID = :proveedor_id";
    $stmtCheck = $conn->prepare($checkProductosSql);
    $stmtCheck->bindParam(':proveedor_id', $proveedor_id);
    $stmtCheck->execute();
    $productosCount = $stmtCheck->fetchColumn();

    if ($productosCount > 0) {
        echo "❌ No puedes eliminar este proveedor porque hay productos asociados a él. Elimina los productos primero o cambia el proveedor.";
    } else {
        $sql = "DELETE FROM Proveedores WHERE ProveedorID = :proveedor_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':proveedor_id', $proveedor_id);

        if ($stmt->execute()) {
            echo "Proveedor eliminado correctamente.";
            header("Location: mostrar_proveedores.php");
            exit;
        } else {
            echo "❌ Error al eliminar el proveedor.";
        }
    }
}
?>
