<?php
include '../conexion/conexion.php';
if (!isset($conn)) {
    die("❌ No se pudo establecer la conexión con la base de datos.");
}if (isset($_GET['cliente_id'])) {
    $clienteID = $_GET['cliente_id'];
    if (!is_numeric($clienteID)) {
        echo "❌ Cliente ID no válido.";
        exit;
    }
    try {
        $sql = "SELECT * FROM Clientes WHERE ClienteID = $clienteID";
        $result = $conn->query($sql);
        $cliente = $result->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            echo "❌ Cliente no encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        die("❌ Error al consultar el cliente: " . $e->getMessage());
    }
} else {
    echo "⚠️ Cliente ID no proporcionado.";
    exit;
}if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razonSocial = $_POST['razon_social'];
    $nombreContacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccionFacturacion = $_POST['direccion_facturacion'];
    $direccionEnvio = $_POST['direccion_envio'];
    $condicionesPago = $_POST['condiciones_pago'];
    $tipoCliente = $_POST['tipo_cliente'];
    $estado = $_POST['estado_cliente'];
    try {
        $sqlUpdate = "UPDATE Clientes
                      SET RazonSocial = '$razonSocial',
                          NombreContacto = '$nombreContacto',
                          Telefono = '$telefono',
                          Email = '$email',
                          DireccionFacturacion = '$direccionFacturacion',
                          DireccionEnvio = '$direccionEnvio',
                          CondicionesPago = '$condicionesPago',
                          TipoCliente = '$tipoCliente',
                          Estado = '$estado'
                      WHERE ClienteID = $clienteID";

        $conn->query($sqlUpdate);
        header("Location: mostrar_clientes.php");
        exit;
    } catch (PDOException $e) {
        echo "❌ Error al actualizar el cliente: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>✏️ Actualizar Cliente</h1>
    </header>
    <main>
        <form action="update_cliente.php?cliente_id=<?php echo $clienteID; ?>" method="POST">
            <input type="hidden" name="clienteID" value="<?php echo $cliente['ClienteID']; ?>">

            <label for="razon_social">📛 Razón Social:</label>
            <input type="text" id="razon_social" name="razon_social" value="<?php echo $cliente['RazonSocial']; ?>" required>

            <label for="nombre_contacto">👤 Nombre de Contacto:</label>
            <input type="text" id="nombre_contacto" name="nombre_contacto" value="<?php echo $cliente['NombreContacto']; ?>" required>

            <label for="telefono">📞 Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['Telefono']; ?>" required>

            <label for="email">📧 Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $cliente['Email']; ?>" required>

            <label for="direccion_facturacion">🏠 Dirección de Facturación:</label>
            <input type="text" id="direccion_facturacion" name="direccion_facturacion" value="<?php echo $cliente['DireccionFacturacion']; ?>" required>

            <label for="direccion_envio">🚚 Dirección de Envío:</label>
            <input type="text" id="direccion_envio" name="direccion_envio" value="<?php echo $cliente['DireccionEnvio']; ?>" required>

            <label for="condiciones_pago">💳 Condiciones de Pago:</label>
            <select id="condiciones_pago" name="condiciones_pago" required>
                <option value="contado" <?php echo $cliente['CondicionesPago'] === 'contado' ? 'selected' : ''; ?>>💰 Contado</option>
                <option value="credito" <?php echo $cliente['CondicionesPago'] === 'credito' ? 'selected' : ''; ?>>💳 Crédito</option>
                <option value="pagos_parciales" <?php echo $cliente['CondicionesPago'] === 'pagos_parciales' ? 'selected' : ''; ?>>💸 Pagos Parciales</option>
            </select>

            <label for="tipo_cliente">🔖 Tipo de Cliente:</label>
            <select id="tipo_cliente" name="tipo_cliente" required>
                <option value="mayorista" <?php echo $cliente['TipoCliente'] === 'mayorista' ? 'selected' : ''; ?>>🏢 Mayorista</option>
                <option value="minorista" <?php echo $cliente['TipoCliente'] === 'minorista' ? 'selected' : ''; ?>>🛍️ Minorista</option>
                <option value="corporativo" <?php echo $cliente['TipoCliente'] === 'corporativo' ? 'selected' : ''; ?>>🏢 Corporativo</option>
            </select>

            <label for="estado_cliente">🟢 Estado del Cliente:</label>
            <select id="estado_cliente" name="estado_cliente">
                <option value="activo" <?php echo $cliente['Estado'] === 'activo' ? 'selected' : ''; ?>>✅ Activo</option>
                <option value="inactivo" <?php echo $cliente['Estado'] === 'inactivo' ? 'selected' : ''; ?>>❌ Inactivo</option>
            </select>
            
            <button type="submit">💾 Actualizar Cliente</button>
        </form>
    </main>
</body>
</html>