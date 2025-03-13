<?php
$serverName = "GABY\SQLEXPRESS";  
$database = "SuministrosSA"; 
$username = "UsuarioAdmin"; 
$password = "5678";  
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_GET['producto_id'])) {
        $productoID = $_GET['producto_id'];
        $sql = "SELECT * FROM Productos WHERE ProductoID = :producto_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':producto_id', $productoID);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productoID'])) {
        $productoID = $_POST['productoID'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precioVenta = $_POST['precio_venta'];
        $costoAdquisicion = $_POST['costo_adquisicion'];
        $stockActual = $_POST['stock_actual'];
        $stockMinimo = $_POST['stock_minimo'];
        $unidadMedida = $_POST['unidad_medida'];
        $sku = $_POST['sku'];
        $sqlUpdate = "UPDATE Productos 
                      SET Nombre = :nombre, 
                          Descripcion = :descripcion, 
                          Categoria = :categoria, 
                          PrecioVenta = :precioVenta, 
                          CostoAdquisicion = :costoAdquisicion, 
                          StockActual = :stockActual, 
                          StockMinimo = :stockMinimo, 
                          UnidadMedida = :unidadMedida, 
                          SKU = :sku 
                      WHERE ProductoID = :productoID";
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
        $stmtUpdate->bindParam(':productoID', $productoID);

        if ($stmtUpdate->execute()) {
            echo "Producto actualizado exitosamente!";
            header("Location: mostrar_productos.php"); 
            exit;
        } else {
            echo "Error al actualizar el producto.";
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="crudcitos.css">
</head>
<body>
    <header>
        <h1>📦 Actualizar Producto - Suministros S.A. 📦</h1>
    </header>
    <main>
        <form action="update.php" method="POST">
            <h2>📝 Actualizar Producto</h2>
            <input type="hidden" name="productoID" value="<?php echo $producto['ProductoID']; ?>">

            <label for="nombre">📛 Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $producto['Nombre']; ?>" required>

            <label for="descripcion">📜 Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $producto['Descripcion']; ?></textarea>

            <label for="categoria">🏷️ Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo $producto['Categoria']; ?>" required>

            <label for="precio_venta">💰 Precio de Venta:</label>
            <input type="number" step="0.01" id="precio_venta" name="precio_venta" value="<?php echo $producto['PrecioVenta']; ?>" required>

            <label for="costo_adquisicion">🛒 Costo de Adquisición:</label>
            <input type="number" step="0.01" id="costo_adquisicion" name="costo_adquisicion" value="<?php echo $producto['CostoAdquisicion']; ?>" required>

            <label for="stock_actual">📦 Stock Actual:</label>
            <input type="number" id="stock_actual" name="stock_actual" value="<?php echo $producto['StockActual']; ?>" required>

            <label for="stock_minimo">⚠️ Stock Mínimo:</label>
            <input type="number" id="stock_minimo" name="stock_minimo" value="<?php echo $producto['StockMinimo']; ?>" required>

            <label for="unidad_medida">⚖️ Unidad de Medida:</label>
            <input type="text" id="unidad_medida" name="unidad_medida" value="<?php echo $producto['UnidadMedida']; ?>" required>

            <label for="sku">🆔 SKU:</label>
            <input type="text" id="sku" name="sku" value="<?php echo $producto['SKU']; ?>" required>

            <button type="submit">Actualizar Producto</button>
        </form>
    </main>
</body>
</html>
