<?php 
include '../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proveedor_id = $_POST['proveedor_id'];
    $nombreEmpresa = $_POST['nombreEmpresa'];
    $contactoPrincipal = $_POST['contactoPrincipal'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $tiempoEntregaPromedio = $_POST['tiempoEntregaPromedio'];
    $condicionesPago = $_POST['condicionesPago'];
    $estado = $_POST['estado'];
    $sql = "UPDATE Proveedores 
            SET NombreEmpresa = :nombreEmpresa,
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
    $stmt->execute();
    header('Location: mostrar_proveedores.php');
    exit;
} else if (isset($_GET['proveedor_id'])) {
    $proveedor_id = $_GET['proveedor_id'];
    $sql = "SELECT * FROM Proveedores WHERE ProveedorID = :proveedor_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':proveedor_id', $proveedor_id);
    $stmt->execute();
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "❌ No se ha proporcionado un ID de proveedor.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <header>
        <h1>📦 Gestión de Proveedores</h1>
        <h1>📋 Editar Proveedor </h1>
</header>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <h1>✏️ Editar Proveedor</h1>
    <form action="editar_proveedor.php" method="POST">
        <input type="hidden" name="proveedor_id" value="<?php echo $proveedor['ProveedorID']; ?>">

        <label for="nombreEmpresa">🏢 Nombre de la Empresa:</label>
        <input type="text" id="nombreEmpresa" name="nombreEmpresa" value="<?php echo htmlspecialchars($proveedor['NombreEmpresa']); ?>" required>

        <label for="contactoPrincipal">👤 Contacto Principal:</label>
        <input type="text" id="contactoPrincipal" name="contactoPrincipal" value="<?php echo htmlspecialchars($proveedor['ContactoPrincipal']); ?>" required>

        <label for="telefono">📞 Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($proveedor['Telefono']); ?>" required>

        <label for="correo">✉️ Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($proveedor['Correo']); ?>" required>

        <label for="direccion">📍 Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($proveedor['Direccion']); ?>" required>

        <label for="tiempoEntregaPromedio">⏳ Tiempo de Entrega Promedio (días):</label>
        <input type="number" id="tiempoEntregaPromedio" name="tiempoEntregaPromedio" value="<?php echo htmlspecialchars($proveedor['TiempoEntregaPromedio']); ?>" required>

        <label for="condicionesPago">💳 Condiciones de Pago:</label>
        <input type="text" id="condicionesPago" name="condicionesPago" value="<?php echo htmlspecialchars($proveedor['CondicionesPago']); ?>" required>

        <label for="estado">📌 Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Activo" <?php echo $proveedor['Estado'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="Inactivo" <?php echo $proveedor['Estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>
        <button type="submit">💾 Actualizar Proveedor</button>
    </form>
    <button onclick="window.location.href='mostrar_proveedores.php'">📋 Ver Proveedores Registrados</button>
</body>
</html>