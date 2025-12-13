<?php
include "conexion_pdo.php"; 

try {
    $sql_total = "SELECT COUNT(*) AS total_votos FROM votos";
    $stmt_total = $pdo->query($sql_total);
    $total_votos = $stmt_total->fetchColumn();
} catch (\PDOException $e) {
    die("Error al obtener el total de votos: " . $e->getMessage());
}

try {
    $sql_candidatos = "
        SELECT 
            c.nombre,  
            c.carrera,
            v.candidato_elegido,
            COUNT(v.id) AS conteo
        FROM candidatos c
        LEFT JOIN votos v ON c.clave_voto = v.candidato_elegido
        
        WHERE c.activo = 1
        
        GROUP BY c.clave_voto, c.nombre, c.carrera
        ORDER BY conteo DESC";
        
    $stmt_candidatos = $pdo->query($sql_candidatos);
    $resultados = $stmt_candidatos->fetchAll();

} catch (\PDOException $e) {
    die("Error al obtener el conteo de candidatos: " . $e->getMessage());
}


function calcular_porcentaje($votos, $total) { 
    if ($total == 0) {
        return 0;
    }
    return number_format(($votos / $total) * 100, 2); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resultados Oficiales - Votación CEPEA</title>
<style>

body {
    font-family: Arial, sans-serif;
    background: #eee;
    text-align: center;
}

.contenedor {
    width: 90%;
    max-width: 600px; 
    margin: 40px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
}

h2 {
    background: #6A5ACD; 
    color: white;
    padding: 20px;
    margin: -20px -20px 20px -20px;
    border-radius: 10px 10px 0 0;
}


.caja-resultado {
    margin: 25px 0;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.resultado-nombre {
    font-weight: bold;
    color: #333;
    font-size: 1.1em;
    margin-bottom: 5px;
}

.barra-contenedor {
    background-color: #ddd;
    border-radius: 5px;
    margin-top: 8px;
    height: 30px;
    overflow: hidden;
    position: relative;
}

.barra-porcentaje {
    height: 100%;
    background-color: #FFD55A; 
    transition: width 1.5s ease-in-out; 
    display: flex;
    align-items: center;
    justify-content: flex-end; 
    color: #333;
    font-weight: bold;
    font-size: 0.9em;
}

.porc-text {
    padding-right: 10px;
    min-width: 50px; 
    text-align: right;
}

.total-votos {
    margin-top: 15px;
    font-size: 1.2em;
    font-weight: bold;
    color: #444;
}
</style>
</head>
<body>

<div class="contenedor">
    <h2>Resultados Oficiales de Votación</h2>
    
    <p class="total-votos">Total de Votos Emitidos: <span><?= htmlspecialchars($total_votos) ?></span></p>
    <hr>
    
    <?php foreach ($resultados as $candidato): 
        $votos = $candidato['conteo'];
        $porcentaje = calcular_porcentaje($votos, $total_votos);
    ?>
    
    <div class="caja-resultado">
        <div class="resultado-nombre">
            <?= htmlspecialchars($candidato['nombre']) ?> (<?= htmlspecialchars($candidato['carrera']) ?>)
        </div>
        <div class="barra-contenedor">
            <div class="barra-porcentaje" style="width: <?= $porcentaje ?>%;">
                <span class="porc-text"><?= $votos ?> votos (<?= $porcentaje ?>%)</span>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
    
    <p style="margin-top: 30px;"><a href="lista.php">Ver lista detallada de votos (Admin)</a></p>

</div>

</body>
</html>