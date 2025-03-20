<?php
include '../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Registrados</title>
    <link rel="stylesheet" href="crudcito.css">
</head>
<body>
    <header>
        <h1>📋 Clientes Registrados</h1>
    </header>
    <main>
        <section id="tabla">
            <h2>Lista de Clientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ClienteID</th>
                        <th>Razón Social</th>
                        <th>Nombre de Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección de Facturación</th>
                        <th>Dirección de Envío</th>
                        <th>Condiciones de Pago</th>
                        <th>Tipo de Cliente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "SELECT ClienteID, RazonSocial, NombreContacto, Telefono, Email, DireccionFacturacion, DireccionEnvio, CondicionesPago, TipoCliente, Estado FROM Clientes";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['ClienteID']) . "</td>
                                <td>" . htmlspecialchars($row['RazonSocial']) . "</td>
                                <td>" . htmlspecialchars($row['NombreContacto']) . "</td>
                                <td>" . htmlspecialchars($row['Telefono']) . "</td>
                                <td>" . htmlspecialchars($row['Email']) . "</td>
                                <td>" . htmlspecialchars($row['DireccionFacturacion']) . "</td>
                                <td>" . htmlspecialchars($row['DireccionEnvio']) . "</td>
                                <td>" . htmlspecialchars($row['CondicionesPago']) . "</td>
                                <td>" . htmlspecialchars($row['TipoCliente']) . "</td>
                                <td>" . htmlspecialchars($row['Estado']) . "</td>
                                <td>
                                    <a href='update_cliente.php?cliente_id=" . htmlspecialchars($row['ClienteID']) . "'> ✏️ Editar</a> | 
                                    <a href='eliminar_cliente.php?cliente_id=" . htmlspecialchars($row['ClienteID']) . "' onclick='return confirm(\"¿Seguro que quieres eliminar este cliente?\")'> 🗑️ Eliminar</a>
                                </td>
                            </tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='11'>Error al cargar los clientes: " . $e->getMessage() . "</td></tr>";
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