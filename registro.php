<?php
include "conexion_pdo.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST['nombre'] ?? '');
    $identificacion = trim($_POST['identificacion'] ?? '');
    $contrasena_plana = $_POST['contrasena'] ?? '';

    if (empty($nombre) || empty($identificacion) || empty($contrasena_plana)) {
        die("Todos los campos son obligatorios.");
    }

    $codigo = "CEPEA-" . date("Y") . "-" . rand(1000, 9999);

    $contrasena_hashed = password_hash($contrasena_plana, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO estudiantes 
                (nombre, identificacion, codigo_estudiante, contrasena_hash, fecha_registro, activo) 
                VALUES (?, ?, ?, ?, NOW(), 1)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nombre, $identificacion, $codigo, $contrasena_hashed])) {
            header("Location: registro_exitoso.html?codigo=" . urlencode($codigo));
            exit();
        } else {
            echo "Error al registrar: no se pudo crear la cuenta.";
        }

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Error: Ya existe un estudiante con esa identificación o código.";
        } else {
            echo "Error del sistema: " . $e->getMessage();
        }
    }

} else {
    header("Location: registro.html");
    exit();
}
?>
