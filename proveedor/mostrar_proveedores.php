<?php
include '../conexion/conexion.php';
$sql = "SELECT * FROM Proveedores";
$proveedores = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Proveedores</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📦 Gestión de Proveedores</h1>
        <h1>📋 Proveedores Registrados</h1>
    </header>
    <table>
        <thead>
            <tr>
                <th>🏢 Nombre de la Empresa</th>
                <th>👤 Contacto Principal</th>
                <th>📞 Teléfono</th>
                <th>✉️ Correo</th>
                <th>📍 Dirección</th>
                <th>⏳ Tiempo de Entrega Promedio</th>
                <th>💳 Condiciones de Pago</th>
                <th>📌 Estado</th>
                <th>✏️ Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><?php echo htmlspecialchars($proveedor['NombreEmpresa']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['ContactoPrincipal']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['Telefono']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['Correo']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['Direccion']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['TiempoEntregaPromedio']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['CondicionesPago']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['Estado']); ?></td>
                <td>
                    <a href="editar_proveedor.php?proveedor_id=<?php echo $proveedor['ProveedorID']; ?>">✏️ Editar</a> |
                    <a href="eliminar_proveedor.php?proveedor_id=<?php echo $proveedor['ProveedorID']; ?>" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">❌ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <footer>
        <p>© 2025 Suministros S.A. - Todos los derechos reservados</p>
    </footer>
</body>
</html>
</body>
</html>
