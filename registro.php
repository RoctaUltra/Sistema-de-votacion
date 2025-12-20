<?php
include "conexion_pdo.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $identificacion = trim($_POST['identificacion']);
    $contrasena_plana = $_POST['contrasena'];
    
    $codigo = "CEPEA-" . date("Y") . "-" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $contrasena_hashed = password_hash($contrasena_plana, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO estudiantes (nombre, identificacion, codigo_estudiante, contrasena_hash) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nombre, $identificacion, $codigo, $contrasena_hashed])) {
            header("Location: registro_exitoso.html?codigo=" . urlencode($codigo));
            exit();
        } else {
            // Error en la inserción
            $error_mensaje = "Error al registrar: No se pudo crear la cuenta.";
            header("Location: error_registro.html?mensaje=" . urlencode($error_mensaje));
            exit();
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            // Error de duplicado (DNI o código ya existe)
            $error_mensaje = "Ya existe un estudiante registrado con esa identificación o código.";
            header("Location: error_registro.html?mensaje=" . urlencode($error_mensaje));
            exit();
        } else {
            // Error general del sistema
            $error_mensaje = "Error del sistema: " . $e->getMessage();
            header("Location: error_registro.html?mensaje=" . urlencode($error_mensaje));
            exit();
        }
    }
} else {
    // No es una petición POST, redirigir al formulario
    header("Location: registro.html");
    exit();
}
?>