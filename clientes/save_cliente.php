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
}if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $razon_social = $_POST['razon_social'];
    $nombre_contacto = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion_facturacion = $_POST['direccion_facturacion'];
    $direccion_envio = $_POST['direccion_envio'];
    $condiciones_pago = $_POST['condiciones_pago'];
    $tipo_cliente = $_POST['tipo_cliente'];
    try {
        $sql_cliente = "INSERT INTO Clientes (RazonSocial, NombreContacto, Telefono, Email, DireccionFacturacion, DireccionEnvio, CondicionesPago, TipoCliente)
                        VALUES ('$razon_social', '$nombre_contacto', '$telefono', '$email', '$direccion_facturacion', '$direccion_envio', '$condiciones_pago', '$tipo_cliente')";
        $conn->exec($sql_cliente);
        echo "<script>alert('Cliente registrado con éxito'); window.location.href = 'mostrar_clientes.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al registrar el cliente: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('No se enviaron datos del formulario');</script>";
}?>