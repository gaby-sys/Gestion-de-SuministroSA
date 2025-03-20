<?php
include '../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head> <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Compras</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📋 Detalle de Compras</h1>
    </header>
    <main>
        <section id="tabla">
            <h2>Lista de Compras con Detalles</h2>
            <table>
                <thead>
                    <tr>
                        <th>CompraID</th>
                        <th>ClienteID</th>
                        <th>ProveedorID</th>
                        <th>Fecha de Compra</th>
                        <th>Número de Factura</th>
                        <th>Método de Pago</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "
                            SELECT 
                                c.CompraID, 
                                c.ClienteID, 
                                c.ProveedorID, 
                                c.FechaCompra, 
                                c.NumeroFactura, 
                                c.MetodoPago, 
                                c.MontoTotal, 
                                c.Estado,
                                STRING_AGG(CONCAT(dc.Cantidad, ' x ', dc.CostoUnitario), '<br>') AS Detalles
                            FROM 
                                Compras c
                            LEFT JOIN 
                                DetalleCompras dc 
                            ON 
                                c.CompraID = dc.CompraID
                            GROUP BY 
                                c.CompraID, c.ClienteID, c.ProveedorID, c.FechaCompra, c.NumeroFactura, c.MetodoPago, c.MontoTotal, c.Estado
                        ";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['CompraID']) . "</td>
                                <td>" . htmlspecialchars($row['ClienteID']) . "</td>
                                <td>" . htmlspecialchars($row['ProveedorID']) . "</td>
                                <td>" . htmlspecialchars($row['FechaCompra']) . "</td>
                                <td>" . htmlspecialchars($row['NumeroFactura']) . "</td>
                                <td>" . htmlspecialchars($row['MetodoPago']) . "</td>
                                <td>" . htmlspecialchars($row['MontoTotal']) . "</td>
                                <td>" . htmlspecialchars($row['Estado']) . "</td>
                                <td>" . $row['Detalles'] . "</td>
                                <td>
                                    <a href='editar_compra.php?compra_id=" . htmlspecialchars($row['CompraID']) . "'>✏️ Editar</a> | 
                                    <a href='eliminar_compra.php?compra_id=" . htmlspecialchars($row['CompraID']) . "' onclick='return confirm(\"¿Seguro que quieres eliminar esta compra?\")'>🗑️ Eliminar</a>
                                </td>
                            </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='10'>Error al cargar los detalles de las compras: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>📞 Contacto: soporte@suministros.com | Todos los derechos reservados &copy; 2025</p>
    </footer>
</body> </html>