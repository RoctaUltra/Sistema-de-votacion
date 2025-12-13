<?php
include "conexion_pdo.php"; 

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Se requiere un ID de voto para la eliminación.");
}

$voto_id = (int)$_GET['id'];

$sql = "DELETE FROM votos WHERE id = ?";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([$voto_id]);

    if ($stmt->rowCount() > 0) {
        header("Location: lista.php?mensaje=voto_eliminado");
        exit();
    } else {
        die("Error: No se encontró ningún voto con el ID {$voto_id}.");
    }

} catch (\PDOException $e) {
    die("Error al eliminar el registro: " . $e->getMessage());
}
?>