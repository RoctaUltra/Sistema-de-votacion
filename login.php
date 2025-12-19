<?php
session_start();
include "conexion_pdo.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoEstudiante = trim($_POST['codigoEstudiante']);
    $contrasena = $_POST['contrasena'];
    
    try {
        $sql = "SELECT id, contrasena_hash FROM estudiantes WHERE codigo_estudiante = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codigoEstudiante]);
        $estudiante = $stmt->fetch();
        
        if ($estudiante && password_verify($contrasena, $estudiante['contrasena_hash'])) {
            $_SESSION['estudiante_id'] = $estudiante['id'];
            $_SESSION['codigo_estudiante'] = $codigoEstudiante;
            header("Location: votar.html");
            exit();
        } else {
            header("Location: error_login.html?error=credenciales");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: error_login.html?error=sistema&mensaje=" . urlencode("Error del sistema: " . $e->getMessage()));
        exit();
    }
} else {
    header("Location: login.html");
    exit();
}
?>