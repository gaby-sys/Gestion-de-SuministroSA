<?php
$serverName = "GABY\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['inventario_id'])) {
        $inventarioID = $_GET['inventario_id'];
        $sql = "SELECT * FROM Inventario WHERE InventarioID = :inventario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':inventario_id', $inventarioID);
        $stmt->execute();
        $inventario = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inventario_id'])) {
        $inventarioID = $_POST['inventario_id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precioVenta = $_POST['precio_venta'];
        $costoAdquisicion = $_POST['costo_adquisicion'];
        $stockActual = $_POST['stock_actual'];
        $stockMinimo = $_POST['stock_minimo'];
        $unidadMedida = $_POST['unidad_medida'];
        $sku = $_POST['sku'];
        $stockMaximo = $_POST['stock_maximo'];
        $estado = $_POST['estado'];
        $lote = $_POST['lote'];
        $sqlUpdate = "UPDATE Inventario 
                      SET Nombre = :nombre, 
                          Descripcion = :descripcion, 
                          Categoria = :categoria, 
                          PrecioVenta = :precioVenta, 
                          CostoAdquisicion = :costoAdquisicion, 
                          StockActual = :stockActual, 
                          StockMinimo = :stockMinimo, 
                          UnidadMedida = :unidadMedida, 
                          SKU = :sku, 
                          StockMaximo = :stockMaximo, 
                          Estado = :estado, 
                          Lote = :lote
                      WHERE InventarioID = :inventario_id";
        
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':nombre', $nombre);
        $stmtUpdate->bindParam(':descripcion', $descripcion);
        $stmtUpdate->bindParam(':categoria', $categoria);
        $stmtUpdate->bindParam(':precioVenta', $precioVenta);
        $stmtUpdate->bindParam(':costoAdquisicion', $costoAdquisicion);
        $stmtUpdate->bindParam(':stockActual', $stockActual);
        $stmtUpdate->bindParam(':stockMinimo', $stockMinimo);
        $stmtUpdate->bindParam(':unidadMedida', $unidadMedida);
        $stmtUpdate->bindParam(':sku', $sku);
        $stmtUpdate->bindParam(':stockMaximo', $stockMaximo);
        $stmtUpdate->bindParam(':estado', $estado);
        $stmtUpdate->bindParam(':lote', $lote);
        $stmtUpdate->bindParam(':inventario_id', $inventarioID);

        if ($stmtUpdate->execute()) {
            echo "¡Inventario actualizado exitosamente!";
            header("Location: mostrar_inventario.php?inventario_id=" . $inventarioID);
            exit;
        } else {
            echo "❌ Error al actualizar el inventario."; }  }
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Inventario</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📦 Actualización de Inventario</h1>
    </header>
    <main>
        <section id="formulario">
            <h2>📝 Actualizar Producto</h2>
            <form action="update_inventario.php" method="POST">
                <input type="hidden" name="inventario_id" value="<?php echo htmlspecialchars($inventario['InventarioID']); ?>">

                <label for="nombre">🔤 Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($inventario['Nombre']); ?>" required><br><br>

                <label for="descripcion">📝 Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($inventario['Descripcion']); ?>" required><br><br>

                <label for="categoria">🏷 Categoría:</label>
                <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($inventario['Categoria']); ?>" required><br><br>

                <label for="precio_venta">💲 Precio de Venta:</label>
                <input type="number" id="precio_venta" name="precio_venta" value="<?php echo htmlspecialchars($inventario['PrecioVenta']); ?>" step="0.01" required><br><br>

                <label for="costo_adquisicion">💸 Costo de Adquisición:</label>
                <input type="number" id="costo_adquisicion" name="costo_adquisicion" value="<?php echo htmlspecialchars($inventario['CostoAdquisicion']); ?>" step="0.01" required><br><br>

                <label for="stock_actual">📦 Stock Actual:</label>
                <input type="number" id="stock_actual" name="stock_actual" value="<?php echo htmlspecialchars($inventario['StockActual']); ?>" required><br><br>

                <label for="stock_minimo">📉 Stock Mínimo:</label>
                <input type="number" id="stock_minimo" name="stock_minimo" value="<?php echo htmlspecialchars($inventario['StockMinimo']); ?>" required><br><br>

                <label for="unidad_medida">📏 Unidad de Medida:</label>
                <input type="text" id="unidad_medida" name="unidad_medida" value="<?php echo htmlspecialchars($inventario['UnidadMedida']); ?>" required><br><br>

                <label for="sku">🔑 SKU:</label>
                <input type="text" id="sku" name="sku" value="<?php echo htmlspecialchars($inventario['SKU']); ?>" required><br><br>

                <label for="stock_maximo">📈 Stock Máximo:</label>
                <input type="number" id="stock_maximo" name="stock_maximo" value="<?php echo htmlspecialchars($inventario['StockMaximo']); ?>" required><br><br>

                <label for="estado">✅ Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="Disponible" <?php if ($inventario['Estado'] == 'Disponible') echo 'selected'; ?>>✅ Disponible</option>
                    <option value="Dañado" <?php if ($inventario['Estado'] == 'Dañado') echo 'selected'; ?>>⚠️ Dañado</option>
                    <option value="En tránsito" <?php if ($inventario['Estado'] == 'En tránsito') echo 'selected'; ?>>🚚 En tránsito</option>
                    <option value="Reservado" <?php if ($inventario['Estado'] == 'Reservado') echo 'selected'; ?>>📦 Reservado</option>
                </select><br><br>

                <label for="lote">🗂 Lote:</label>
                <input type="text" id="lote" name="lote" value="<?php echo htmlspecialchars($inventario['Lote']); ?>" required><br><br>

                <button type="submit">💾 Actualizar Producto</button>
            </form>
        </section>
    </main>
</body>
</html>