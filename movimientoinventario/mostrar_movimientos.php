<?php
include '../conexion/conexion.php';

try {
    $sql = "SELECT MovimientoID, InventarioID, FechaMovimiento, TipoMovimiento, Cantidad, Motivo 
            FROM MovimientosDeInventario";
    $stmt = $conn->query($sql);

} catch (PDOException $e) {
    echo "❌ Error al obtener los movimientos de inventario: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos de Inventario</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<header>
    <h1>📦 Movimientos de Inventarios</h1>
</header>
<main>
    <section id="movimientos">
        <h2>🔄 Lista de Movimientos de Inventario</h2>
        <table>
            <thead>
                <tr>
                    <th>MovimientoID</th>
                    <th>Producto (ID)</th>
                    <th>Fecha de Movimiento</th>
                    <th>Tipo de Movimiento</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['MovimientoID']) . "</td>
                        <td>" . htmlspecialchars($row['InventarioID']) . "</td>
                        <td>" . htmlspecialchars($row['FechaMovimiento']) . "</td>
                        <td>" . htmlspecialchars($row['TipoMovimiento']) . "</td>
                        <td>" . htmlspecialchars($row['Cantidad']) . "</td>
                        <td>" . htmlspecialchars($row['Motivo']) . "</td>
                        <td>
                            <a href='editar_movimiento.php?movimiento_id=" . htmlspecialchars($row['MovimientoID']) . "'>✏️ Editar</a> | 
                            <a href='eliminar_movimiento.php?movimiento_id=" . htmlspecialchars($row['MovimientoID']) . "' onclick='return confirm(\"¿Seguro que quieres eliminar este movimiento?\")'>🗑️ Eliminar</a>
                        </td>
                    </tr>";
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
