<?php
include '../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Inventarios</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📋 Detalle de Inventarios</h1>
    </header>
    <main>
        <section id="tabla">
            <h2>Lista de Inventarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>InventarioID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio de Venta</th>
                        <th>Costo de Adquisición</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Unidad de Medida</th>
                        <th>SKU</th>
                        <th>Stock Máximo</th>
                        <th>Estado</th>
                        <th>Lote</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "SELECT InventarioID, Nombre, Descripcion, Categoria, PrecioVenta, CostoAdquisicion, 
                                        StockActual, StockMinimo, UnidadMedida, SKU, StockMaximo, Estado, Lote
                                FROM Inventario";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['InventarioID']) . "</td>
                                <td>" . htmlspecialchars($row['Nombre']) . "</td>
                                <td>" . htmlspecialchars($row['Descripcion']) . "</td>
                                <td>" . htmlspecialchars($row['Categoria']) . "</td>
                                <td>" . htmlspecialchars($row['PrecioVenta']) . "</td>
                                <td>" . htmlspecialchars($row['CostoAdquisicion']) . "</td>
                                <td>" . htmlspecialchars($row['StockActual']) . "</td>
                                <td>" . htmlspecialchars($row['StockMinimo']) . "</td>
                                <td>" . htmlspecialchars($row['UnidadMedida']) . "</td>
                                <td>" . htmlspecialchars($row['SKU']) . "</td>
                                <td>" . htmlspecialchars($row['StockMaximo']) . "</td>
                                <td>" . htmlspecialchars($row['Estado']) . "</td>
                                <td>" . htmlspecialchars($row['Lote']) . "</td>
                                <td>
                                    <a href='update_inventario.php?inventario_id=" . htmlspecialchars($row['InventarioID']) . "'>✏️ Editar</a> | 
                                    <a href='eliminar_inventario.php?inventario_id=" . htmlspecialchars($row['InventarioID']) . "' onclick='return confirm(\"¿Seguro que quieres eliminar este inventario?\")'>🗑️ Eliminar</a>
                                </td>
                            </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='14'>Error al cargar los detalles de los inventarios: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>📞 Contacto: soporte@suministros.com | Todos los derechos reservados &copy; 2025</p>
    </footer>
</body>
</html>
