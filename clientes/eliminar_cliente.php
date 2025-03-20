<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cliente_id'])) {
    $cliente_id = (int)$_GET['cliente_id']; 

    try {
        $conn->beginTransaction(); 
        $sql_eliminar_cliente = "DELETE FROM Clientes WHERE ClienteID = $cliente_id";
        $conn->query($sql_eliminar_cliente);
        $conn->commit(); 
        header("Location: mostrar_clientes.php"); 
        exit;
    } catch (PDOException $e) {
        $conn->rollBack(); 
        echo "❌ Error al eliminar el cliente: " . $e->getMessage();
    }
} else {
    echo "❌ Error: ID de cliente no proporcionado.";
}
?>