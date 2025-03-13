<?php
$serverName = "GABY\SQLEXPRESS"; 
$database = "SuministrosSA";    
$username = "UsuarioAdmin";   
$password = "5678"; 
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $sku = $_POST['sku'];
    $precio_venta = $_POST['precio_venta'];
    $costo_adquisicion = $_POST['costo_adquisicion'];
    $stock_actual = $_POST['stock_actual'];
    $stock_minimo = $_POST['stock_minimo'];
    $unidad_medida = $_POST['unidad_medida'];

    try {
        $sql_producto = "INSERT INTO Productos (Nombre, Descripcion, Categoria, SKU, PrecioVenta, CostoAdquisicion, StockActual, StockMinimo, UnidadMedida) 
                         VALUES ('$nombre', '$descripcion', '$categoria', '$sku', '$precio_venta', '$costo_adquisicion', '$stock_actual', '$stock_minimo', '$unidad_medida')";
        $conn->exec($sql_producto);

        echo "<script>alert('Producto registrado con éxito'); window.location.href = 'crud.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al registrar el producto: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('No se enviaron datos del formulario');</script>";
}
?>

