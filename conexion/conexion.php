<?php
$serverName = "GABY\\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "SuministrosSA",
    "Uid" => "UsuarioAdmin",
    "PWD" => "5678"
);
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}", $connectionOptions['Uid'], $connectionOptions['PWD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
