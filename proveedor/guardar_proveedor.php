<?php
include '../conexion/conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreEmpresa = $_POST['nombreEmpresa'];
    $contactoPrincipal = $_POST['contactoPrincipal'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $tiempoEntregaPromedio = $_POST['tiempoEntregaPromedio'];
    $condicionesPago = $_POST['condicionesPago'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO Proveedores (NombreEmpresa, ContactoPrincipal, Telefono, Correo, Direccion, TiempoEntregaPromedio, CondicionesPago, Estado)
            VALUES (:nombreEmpresa, :contactoPrincipal, :telefono, :correo, :direccion, :tiempoEntregaPromedio, :condicionesPago, :estado)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombreEmpresa', $nombreEmpresa);
    $stmt->bindParam(':contactoPrincipal', $contactoPrincipal);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':tiempoEntregaPromedio', $tiempoEntregaPromedio);
    $stmt->bindParam(':condicionesPago', $condicionesPago);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        echo "Proveedor guardado correctamente.";
        header("Location: mostrar_proveedores.php");
        exit;
    } else {
        echo "❌ Error al guardar el proveedor.";
    }
}
?>