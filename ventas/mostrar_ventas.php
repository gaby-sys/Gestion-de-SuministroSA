<?php
include '../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Ventas</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📋 Detalle de Ventas</h1>
    </header>
    <main>
        <section id="tabla">
            <h2>Lista de Ventas con Detalles</h2>
            <table>
                <thead>
                    <tr>
                        <th>VentaID</th>
                        <th>ClienteID</th>
                        <th>ProductoID</th>
                        <th>Fecha de Venta</th>
                        <th>Número de Factura</th>
                        <th>Monto Total</th>
                        <th>Método de Pago</th>
                        <th>Condición de Pago</th>
                        <th>Fecha de Entrega</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "
                           SELECT v.VentaID, v.ClienteID, d.ProductoID, v.FechaVenta, v.NumeroFactura, v.MontoTotal, 
                                   v.MetodoPago, v.CondicionPago, v.FechaEntrega, v.EstadoVenta, v.Observaciones,
                                   d.Cantidad, d.PrecioUnitario, d.Subtotal
                            FROM Ventas v
                            LEFT JOIN DetalleDeVentas d ON v.VentaID = d.VentaID

                        ";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['VentaID']) . "</td>
                                <td>" . htmlspecialchars($row['ClienteID']) . "</td>
                                <td>" . htmlspecialchars($row['ProductoID']) . "</td>
                                <td>" . htmlspecialchars($row['FechaVenta']) . "</td>
                                <td>" . htmlspecialchars($row['NumeroFactura']) . "</td>
                                <td>" . htmlspecialchars($row['MontoTotal']) . "</td>
                                <td>" . htmlspecialchars($row['MetodoPago']) . "</td>
                                <td>" . htmlspecialchars($row['CondicionPago']) . "</td>
                                <td>" . htmlspecialchars($row['FechaEntrega']) . "</td>
                                <td>" . htmlspecialchars($row['EstadoVenta']) . "</td>
                                <td>" . htmlspecialchars($row['Observaciones']) . "</td>
                                <td>" . htmlspecialchars($row['Cantidad']) . "</td>
                                <td>" . htmlspecialchars($row['PrecioUnitario']) . "</td>
                                <td>" . htmlspecialchars($row['Subtotal']) . "</td>
                                <td>
                                    <a href='update_venta.php?venta_id=" . htmlspecialchars($row['VentaID']) . "'>✏️ Editar</a> | 
                                    <a href='eliminar_venta.php?venta_id=" . htmlspecialchars($row['VentaID']) . "' onclick='return confirm(\"¿Seguro que quieres eliminar esta venta?\")'>🗑️ Eliminar</a>
                                </td>
                            </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='14'>Error al cargar los detalles de las ventas: " . $e->getMessage() . "</td></tr>";
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