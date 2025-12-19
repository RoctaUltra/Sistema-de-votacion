<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "sistema_votacion_cepea";

// Crear conexión usando mysqli (para compatibilidad con lista.php)
$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// También crear objeto PDO para compatibilidad
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$basedatos", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}
?>