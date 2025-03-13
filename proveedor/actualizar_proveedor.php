<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proveedor_id'])) {
    $proveedor_id = $_POST['proveedor_id'];
    $nombreEmpresa = $_POST['nombreEmpresa'];
    $contactoPrincipal = $_POST['contactoPrincipal'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $tiempoEntregaPromedio = $_POST['tiempoEntregaPromedio'];
    $condicionesPago = $_POST['condicionesPago'];
    $estado = $_POST['estado'];
    $sql = "UPDATE Proveedores SET 
                NombreEmpresa = :nombreEmpresa,
                ContactoPrincipal = :contactoPrincipal,
                Telefono = :telefono,
                Correo = :correo,
                Direccion = :direccion,
                TiempoEntregaPromedio = :tiempoEntregaPromedio,
                CondicionesPago = :condicionesPago,
                Estado = :estado
            WHERE ProveedorID = :proveedor_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombreEmpresa', $nombreEmpresa);
    $stmt->bindParam(':contactoPrincipal', $contactoPrincipal);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':tiempoEntregaPromedio', $tiempoEntregaPromedio);
    $stmt->bindParam(':condicionesPago', $condicionesPago);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':proveedor_id', $proveedor_id);
    if ($stmt->execute()) {
        header("Location: mostrar_proveedores.php");
        exit;
    } else {
        echo "❌ Error al actualizar el proveedor.";
    }
} else {
    echo "❌ Datos incompletos.";
}
?>
