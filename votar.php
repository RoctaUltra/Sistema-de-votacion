<?php
session_start();
include "conexion_pdo.php"; 

if (!isset($_SESSION['estudiante_id'])) {
    header("Location: login.html?error=sesion");
    exit();
}
$estudiante_id = $_SESSION['estudiante_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidato_elegido = $_POST['candidato'] ?? '';

    if (empty($candidato_elegido)) {
        die("Error: No se seleccionó ningún candidato.");
    }
    
    $sql_check = "SELECT COUNT(*) FROM votos WHERE estudiante_id = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$estudiante_id]);
    
    if ($stmt_check->fetchColumn() > 0) {
        die("¡Usted ya ha emitido su voto!");
    }
    
    $sql_insert = "INSERT INTO votos (estudiante_id, candidato_elegido) VALUES (?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);
    
    if ($stmt_insert->execute([$estudiante_id, $candidato_elegido])) {
        header("Location: voto_confirmado.html?candidato=" . urlencode($candidato_elegido));
        exit();
    } else {
        die("Ocurrió un error al registrar su voto.");
    }

} else {
    header("Location: votar.html");
    exit();
}
?>