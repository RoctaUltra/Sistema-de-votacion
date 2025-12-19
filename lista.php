<?php
include "conexion_pdo.php";

try {
    $sql = "SELECT v.id, v.candidato_elegido, e.nombre as estudiante_nombre 
            FROM votos v 
            LEFT JOIN estudiantes e ON v.estudiante_id = e.id 
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
        width: 80%;
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

    .mensaje-vacio {
        background-color: #fff3cd;
        color: #856404;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #ffeaa7;
        margin: 20px auto;
        max-width: 500px;
    }

    .botones-navegacion {
        margin: 20px 0;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 0 10px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        background: #6A5ACD;
        color: white;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #5a4fbf;
    }

    .btn-secundario {
        background: #FFD55A;
        color: #333;
    }

    .btn-secundario:hover {
        background: #f1c232;
    }

    .estadisticas {
        background: #e8f5e8;
        color: #155724;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid #c3e6cb;
        margin: 20px auto;
        max-width: 500px;
    }

    @media screen and (max-width: 600px) {
        table, th, td {
            width: 100%;
            display: block;
        }

        tr {
            margin-bottom: 10px;
        }

        th {
            text-align: left;
        }

        td {
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

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
<h2>Lista de Votos</h2>

<?php if (empty($votos)): ?>
    <div class="mensaje-vacio">
        <h3>📭 No hay votos registrados</h3>
        <p>No se han emitido votos en el sistema aún.</p>
        <p><strong>Para probar el sistema:</strong></p>
        <ul style="text-align: left; display: inline-block;">
            <li>Registra un estudiante en <a href="registro.html">Registro</a></li>
            <li>Inicia sesión con las credenciales</li>
            <li>Emite un voto en <a href="votar.html">Votar</a></li>
            <li>Regresa aquí para ver los resultados</li>
        </ul>
    </div>
<?php else: ?>
    <div class="estadisticas">
        <strong>📊 Total de votos registrados: <?= count($votos) ?></strong>
    </div>

    <table>
    <tr>
        <th>ID</th>
        <th>Candidato</th>
        <th>Estudiante</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($votos as $fila): ?>
    <tr>
        <td data-label="ID"><?= htmlspecialchars($fila['id']) ?></td>
        <td data-label="Candidato"><?= htmlspecialchars($fila['candidato_elegido']) ?></td>
        <td data-label="Estudiante"><?= htmlspecialchars($fila['estudiante_nombre'] ?? 'N/A') ?></td>
        <td data-label="Acciones">
            <a href="eliminar.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este voto?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

<div class="botones-navegacion">
    <a href="index.html" class="btn">🏠 Inicio</a>
    <a href="resultados.php" class="btn btn-secundario">📊 Ver Resultados</a>
    <a href="registro.html" class="btn btn-secundario">➕ Registrar Estudiante</a>
</div>

</body>
</html>