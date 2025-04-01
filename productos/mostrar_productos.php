<?php
include '../conexion/conexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Registrados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>📋 Productos Registrados</h1>
    </header>
    <main>
        <section id="tabla">
            <h2>Lista de Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ProductoID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>SKU</th>
                        <th>Precio Venta</th>
                        <th>Costo Adquisición</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Unidad Medida</th>
                        <th>Estado</th>
                        <th>Lote</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "SELECT ProductoID, Nombre, Descripcion, Categoria, SKU, PrecioVenta, CostoAdquisicion, StockActual, StockMinimo, UnidadMedida, Estado, Lote FROM Productos";
                        $stmt = $conn->query($sql);
                        echo $stmt->rowCount(); // Mostrar la cantidad de productos encontrados
                        if ($stmt) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['ProductoID']) . "</td>
                                    <td>" . htmlspecialchars($row['Nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['Descripcion']) . "</td>
                                    <td>" . htmlspecialchars($row['Categoria']) . "</td>
                                    <td>" . htmlspecialchars($row['SKU']) . "</td>
                                    <td>" . htmlspecialchars($row['PrecioVenta']) . "</td>
                                    <td>" . htmlspecialchars($row['CostoAdquisicion']) . "</td>
                                    <td>" . htmlspecialchars($row['StockActual']) . "</td>
                                    <td>" . htmlspecialchars($row['StockMinimo']) . "</td>
                                    <td>" . htmlspecialchars($row['UnidadMedida']) . "</td>
                                    <td>" . htmlspecialchars($row['Estado']) . "</td>
                                    <td>" . htmlspecialchars($row['Lote']) . "</td>
                                    <td>
                                        <a href='update.php?producto_id=" . htmlspecialchars($row['ProductoID']) . "'>Editar</a> | 
                                        <a href='Eliminar.php?producto_id=" . htmlspecialchars($row['ProductoID']) . "'>Eliminar</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='13'>No se encontraron productos.</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='13'>Error al cargar los productos: " . $e->getMessage() . "</td></tr>";
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
