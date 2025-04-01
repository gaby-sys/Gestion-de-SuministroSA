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
        $sqlCheck = "SELECT * FROM Ventas WHERE VentaID = :venta_id";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->bindParam(':venta_id', $ventaID);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() == 0) {
            echo "❌ Venta no encontrada.";
            exit; }
        $sqlDeleteDetalles = "DELETE FROM DetalleDeVentas WHERE VentaID = :venta_id";
        $stmtDeleteDetalles = $conexion->prepare($sqlDeleteDetalles);
        $stmtDeleteDetalles->bindParam(':venta_id', $ventaID);
        $stmtDeleteDetalles->execute();
        $sqlDeleteVenta = "DELETE FROM Ventas WHERE VentaID = :venta_id";
        $stmtDeleteVenta = $conexion->prepare($sqlDeleteVenta);
        $stmtDeleteVenta->bindParam(':venta_id', $ventaID);
        
        if ($stmtDeleteVenta->execute()) {
            header("Location: mostrar_ventas.php");
            exit;
        } else {
            echo "❌ Error al eliminar la venta.";
        }
    } else {
        echo "❌ No se proporcionó un ID de venta válido.";}} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>