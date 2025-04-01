<?php
$serverName = "GABY\\SQLEXPRESS";
$database = "SuministrosSA";
$username = "UsuarioAdmin";
$password = "5678";
try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        $estados_permitidos = ['Dañado', 'En tránsito', 'Reservado', 'Disponible'];
        if (!in_array($estado, $estados_permitidos)) {
            die("❌ Error: Estado no válido.");}
        $conexion->beginTransaction();
        $sqlInventario = "INSERT INTO Inventario (Nombre, Descripcion, Categoria, PrecioVenta, CostoAdquisicion, StockActual, StockMinimo, UnidadMedida, SKU, StockMaximo, Estado, Lote) 
                          VALUES (:nombre, :descripcion, :categoria, :precioVenta, :costoAdquisicion, :stockActual, :stockMinimo, :unidadMedida, :sku, :stockMaximo, :estado, :lote)";
        $stmtInventario = $conexion->prepare($sqlInventario);
        $stmtInventario->bindParam(':nombre', $nombre);
        $stmtInventario->bindParam(':descripcion', $descripcion);
        $stmtInventario->bindParam(':categoria', $categoria);
        $stmtInventario->bindParam(':precioVenta', $precioVenta);
        $stmtInventario->bindParam(':costoAdquisicion', $costoAdquisicion);
        $stmtInventario->bindParam(':stockActual', $stockActual);
        $stmtInventario->bindParam(':stockMinimo', $stockMinimo);
        $stmtInventario->bindParam(':unidadMedida', $unidadMedida);
        $stmtInventario->bindParam(':sku', $sku);
        $stmtInventario->bindParam(':stockMaximo', $stockMaximo);
        $stmtInventario->bindParam(':estado', $estado);
        $stmtInventario->bindParam(':lote', $lote);

        if ($stmtInventario->execute()) {
            $conexion->commit();
            header("Location: mostrar_inventario.php");
            exit();
        } else {
            throw new Exception("❌ Error al insertar el producto en el inventario.");
        }
    }
} catch (Exception $e) {
    $conexion->rollBack();
    echo "❌ Error: " . $e->getMessage();
}?>