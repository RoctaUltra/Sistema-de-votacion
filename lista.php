<?php
include "conexion_pdo.php";

try {
    $sql = "SELECT 
                v.id, 
                v.fecha_voto,             
                c.nombre AS candidato_nombre, 
                e.nombre AS estudiante_nombre 
            FROM votos v 
            
            LEFT JOIN estudiantes e ON v.estudiante_id = e.id 
            
            LEFT JOIN candidatos c ON v.candidato_elegido = c.clave_voto 
            
            ORDER BY v.id DESC";
            
    $stmt = $pdo->query($sql);
    $votos = $stmt->fetchAll();

} catch (PDOException $e) {

    die("Error al obtener los votos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de Votos</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    h2 {
        color: #333;
    }

    table {
        width: 85%; 
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #6A5ACD;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    a {
        text-decoration: none;
        color: #6A5ACD;
        font-weight: bold;
    }

    a:hover {
        color: #483D8B;
    }

    @media screen and (max-width: 600px) {
        table {
            width: 100%;
        }
        th, td {
            display: block;
            width: auto;
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        th {
            display: none; 
        
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            font-weight: bold;
            text-align: left;
        }
    }
</style>
</head>
<body>
<h2>Lista de Votos Emitidos</h2>
<a href="resultados.php">Ver Conteo de Votos</a>
<table>
    <tr>
        <th>ID Voto</th>
        <th>Estudiante (ID)</th>
        <th>Candidato Elegido</th>
        <th>Fecha y Hora</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($votos as $fila) { ?>
    <tr>
        <td data-label="ID Voto"><?=htmlspecialchars($fila['id'])?></td>
        <td data-label="Estudiante"><?=htmlspecialchars($fila['estudiante_nombre'] ?? 'N/A')?></td>
        
        <td data-label="Candidato"><?=htmlspecialchars($fila['candidato_nombre'] ?? 'N/A')?></td>
        
        <td data-label="Fecha"><?=htmlspecialchars($fila['fecha_voto'])?></td>
        <td data-label="Acciones">
            <a href="eliminar_voto.php?id=<?=$fila['id']?>">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
<?php
include "conexion_pdo.php";
?>