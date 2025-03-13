<?php 
$serverName = "GABY\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";

try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
        !empty($_POST['nombre']) && !empty($_POST['descripcion']) && 
        !empty($_POST['categoria']) && !empty($_POST['precio_venta']) && 
        !empty($_POST['costo_adquisicion']) && !empty($_POST['stock_actual']) && 
        !empty($_POST['stock_minimo']) && !empty($_POST['unidad_medida']) && 
        !empty($_POST['sku'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precioVenta = $_POST['precio_venta'];
        $costoAdquisicion = $_POST['costo_adquisicion'];
        $stockActual = $_POST['stock_actual'];
        $stockMinimo = $_POST['stock_minimo'];
        $unidadMedida = $_POST['unidad_medida'];
        $sku = $_POST['sku'];
        $sql = "INSERT INTO Productos 
                (Nombre, Descripcion, Categoria, PrecioVenta, CostoAdquisicion, StockActual, StockMinimo, UnidadMedida, SKU) 
                VALUES 
                ('$nombre', '$descripcion', '$categoria', '$precioVenta', '$costoAdquisicion', '$stockActual', '$stockMinimo', '$unidadMedida', '$sku')";
        if ($conexion->exec($sql)) {
            echo "<p style='color: green;'>Producto registrado exitosamente.</p>";
        } else {
            echo "<p style='color: red;'>Error al registrar el producto.</p>";
        }
    }
    $sql = "SELECT * FROM Productos";
    $productos = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_GET['eliminar'])) {
        $idEliminar = $_GET['eliminar'];
        $sqlEliminar = "DELETE FROM Productos WHERE ProductoID = $idEliminar";
        $conexion->exec($sqlEliminar);
        header("Location: insert.php?mensaje=Producto eliminado exitosamente");
        exit;
    }

} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos - Suministros S.A.</title>
    <link rel="stylesheet" href="crudcitos.css">
</head>
<body>
    <header>
        <h1>📦 Gestión de Productos - Suministros S.A. 📦</h1>
    </header>
    <main>
        <section>
            <h2>📋 Lista de Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio Venta</th>
                        <th>Costo</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                            <td><?= htmlspecialchars($producto['Descripcion']) ?></td>
                            <td><?= htmlspecialchars($producto['Categoria']) ?></td>
                            <td><?= htmlspecialchars($producto['PrecioVenta']) ?></td>
                            <td><?= htmlspecialchars($producto['CostoAdquisicion']) ?></td>
                            <td><?= htmlspecialchars($producto['StockActual']) ?></td>
                            <td>
                                <a href="insert.php?eliminar=<?= htmlspecialchars($producto['ProductoID']) ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
