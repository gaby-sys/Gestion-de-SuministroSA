<?php
include '../conexion/conexion.php';
if (isset($_GET['movimiento_id'])) {
    $movimiento_id = (int) $_GET['movimiento_id'];
    try {
        $sql = "SELECT MovimientoID, InventarioID, FechaMovimiento, TipoMovimiento, Cantidad, Motivo 
                FROM MovimientosDeInventario WHERE MovimientoID = :movimiento_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':movimiento_id', $movimiento_id);
        $stmt->execute();
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movimiento) {
            echo "❌ Movimiento no encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "❌ Error al obtener el movimiento: " . $e->getMessage();
        exit;
    }
} else {
    echo "❌ Error: ID de movimiento no proporcionado.";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inventario_id = (int) $_POST['inventario_id'];
    $fecha_movimiento = $_POST['fecha_movimiento'];
    $tipo_movimiento = $_POST['tipo_movimiento'];
    $cantidad = (int) $_POST['cantidad'];
    $motivo = $_POST['motivo'];

    try {
        $sql_update = "UPDATE MovimientosDeInventario 
                       SET InventarioID = :inventario_id, FechaMovimiento = :fecha_movimiento, 
                           TipoMovimiento = :tipo_movimiento, Cantidad = :cantidad, Motivo = :motivo 
                       WHERE MovimientoID = :movimiento_id";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':inventario_id', $inventario_id);
        $stmt_update->bindParam(':fecha_movimiento', $fecha_movimiento);
        $stmt_update->bindParam(':tipo_movimiento', $tipo_movimiento);
        $stmt_update->bindParam(':cantidad', $cantidad);
        $stmt_update->bindParam(':motivo', $motivo);
        $stmt_update->bindParam(':movimiento_id', $movimiento_id);
        $stmt_update->execute();
        echo "✅ Movimiento de inventario actualizado con éxito.";
        header("Location: mostrar_movimientos.php");
        exit;
    } catch (PDOException $e) {
        echo "❌ Error al actualizar el movimiento: " . $e->getMessage();}}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Movimiento de Inventario</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<header>
    <h1>📦 Editar Movimiento de Inventario</h1>
</header>
<main>
    <section id="editar_movimiento">
        <h2>🔄 Editar Movimiento de Inventario</h2>
        <form action="editar_movimiento.php?movimiento_id=<?php echo $movimiento['MovimientoID']; ?>" method="POST">
            <label for="inventario_id">🔢 Producto (ID):</label>
            <input type="text" id="inventario_id" name="inventario_id" value="<?php echo htmlspecialchars($movimiento['InventarioID']); ?>" required><br><br>

            <label for="fecha_movimiento">📅 Fecha de Movimiento:</label>
            <input type="date" id="fecha_movimiento" name="fecha_movimiento" value="<?php echo htmlspecialchars($movimiento['FechaMovimiento']); ?>" required><br><br>

            <label for="tipo_movimiento">🔄 Tipo de Movimiento:</label>
            <select id="tipo_movimiento" name="tipo_movimiento" required>
                <option value="Entrada" <?php echo $movimiento['TipoMovimiento'] == 'Entrada' ? 'selected' : ''; ?>>➕ Entrada</option>
                <option value="Salida" <?php echo $movimiento['TipoMovimiento'] == 'Salida' ? 'selected' : ''; ?>>➖ Salida</option>
            </select><br><br>

            <label for="cantidad">🔢 Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($movimiento['Cantidad']); ?>" required><br><br>

            <label for="motivo">📋 Motivo:</label>
            <input type="text" id="motivo" name="motivo" value="<?php echo htmlspecialchars($movimiento['Motivo']); ?>" required><br><br>

            <button type="submit">💾 Guardar Cambios</button>
            <button type="button" onclick="window.location.href='mostrar_movimientos.php'">📋 Ver Movimientos</button>
        </form>
    </section>
</main>
<footer>
    <p>📞 Contacto: soporte@suministros.com | Todos los derechos reservados &copy; 2025</p>
</footer>
</body>
</html>