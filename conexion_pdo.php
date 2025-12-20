<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "sistema_votacion_cepea";


$conexion = new mysqli($servidor, $usuario, $clave, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$basedatos", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}
?>