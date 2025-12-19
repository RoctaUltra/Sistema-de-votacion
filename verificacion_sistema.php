<?php
// verificacion_sistema.php - Script para verificar que todos los componentes del sistema funcionen correctamente

echo "<h1>🔍 Verificación del Sistema de Votación CEPEA</h1>";
echo "<hr>";

// 1. Verificar conexión a base de datos
echo "<h2>1. 📡 Conexión a Base de Datos</h2>";
try {
    include "conexion_pdo.php";
    echo "✅ <strong>CONEXIÓN EXITOSA</strong><br>";
    echo "📊 Base de datos: sistema_votacion_cepea<br>";
    echo "🔌 Servidor: localhost<br>";
} catch (Exception $e) {
    echo "❌ <strong>ERROR DE CONEXIÓN:</strong> " . $e->getMessage() . "<br>";
}

// 2. Verificar tablas
echo "<h2>2. 🗄️ Verificación de Tablas</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $tablas_requeridas = ['estudiantes', 'votos', 'candidatos'];
    
    foreach ($tablas_requeridas as $tabla) {
        if (in_array($tabla, $tablas)) {
            echo "✅ <strong>$tabla</strong> existe<br>";
        } else {
            echo "❌ <strong>$tabla</strong> NO existe<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error al verificar tablas: " . $e->getMessage() . "<br>";
}

// 3. Verificar candidatos
echo "<h2>3. 👥 Candidatos Predefinidos</h2>";
try {
    $stmt = $pdo->query("SELECT nombre, carrera FROM candidatos");
    $candidatos = $stmt->fetchAll();
    
    if (count($candidatos) > 0) {
        foreach ($candidatos as $candidato) {
            echo "✅ " . htmlspecialchars($candidato['nombre']) . " (" . htmlspecialchars($candidato['carrera']) . ")<br>";
        }
    } else {
        echo "⚠️ No hay candidatos registrados<br>";
    }
} catch (Exception $e) {
    echo "❌ Error al verificar candidatos: " . $e->getMessage() . "<br>";
}

// 4. Verificar archivos PHP
echo "<h2>4. 📁 Verificación de Archivos</h2>";
$archivos_requeridos = [
    'index.html' => 'Página principal',
    'registro.html' => 'Formulario de registro',
    'registro.php' => 'Procesamiento de registro',
    'login.html' => 'Formulario de login',
    'login.php' => 'Procesamiento de login',
    'votar.html' => 'Interfaz de votación',
    'votar.php' => 'Procesamiento de voto',
    'resultados.php' => 'Resultados de votación',
    'lista.php' => 'Lista de votos (admin)',
    'eliminar.php' => 'Eliminar votos',
    'conexion_pdo.php' => 'Conexión a BD',
    'error_registro.html' => 'Error de registro',
    'error_login.html' => 'Error de login',
    'error_general.html' => 'Error general'
];

foreach ($archivos_requeridos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "✅ <strong>$archivo</strong> - $descripcion<br>";
    } else {
        echo "❌ <strong>$archivo</strong> - $descripcion (FALTANTE)<br>";
    }
}

// 5. Verificar estructura de base de datos
echo "<h2>5. 🏗️ Estructura de Base de Datos</h2>";
try {
    // Verificar tabla estudiantes
    $stmt = $pdo->query("DESCRIBE estudiantes");
    $campos_estudiantes = $stmt->fetchAll();
    echo "📋 <strong>Tabla estudiantes:</strong><br>";
    foreach ($campos_estudiantes as $campo) {
        echo "  - " . $campo['Field'] . " (" . $campo['Type'] . ")<br>";
    }
    
    echo "<br>";
    
    // Verificar tabla votos
    $stmt = $pdo->query("DESCRIBE votos");
    $campos_votos = $stmt->fetchAll();
    echo "📋 <strong>Tabla votos:</strong><br>";
    foreach ($campos_votos as $campo) {
        echo "  - " . $campo['Field'] . " (" . $campo['Type'] . ")<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error al verificar estructura: " . $e->getMessage() . "<br>";
}

// 6. Estadísticas
echo "<h2>6. 📊 Estadísticas Actuales</h2>";
try {
    // Contar estudiantes
    $stmt = $pdo->query("SELECT COUNT(*) FROM estudiantes");
    $total_estudiantes = $stmt->fetchColumn();
    echo "👥 <strong>Estudiantes registrados:</strong> $total_estudiantes<br>";
    
    // Contar votos
    $stmt = $pdo->query("SELECT COUNT(*) FROM votos");
    $total_votos = $stmt->fetchColumn();
    echo "🗳️ <strong>Votos emitidos:</strong> $total_votos<br>";
    
    // Contar candidatos
    $stmt = $pdo->query("SELECT COUNT(*) FROM candidatos WHERE activo = 1");
    $total_candidatos = $stmt->fetchColumn();
    echo "🎯 <strong>Candidatos activos:</strong> $total_candidatos<br>";
    
} catch (Exception $e) {
    echo "❌ Error al obtener estadísticas: " . $e->getMessage() . "<br>";
}

// 7. Recomendaciones
echo "<h2>7. 💡 Recomendaciones</h2>";
echo "<ul>";

if ($total_estudiantes == 0) {
    echo "<li>⚠️ No hay estudiantes registrados. Ejecuta el registro para probar el sistema.</li>";
}

if ($total_votos == 0) {
    echo "<li>⚠️ No hay votos emitidos. Una vez registrados estudiantes, pueden votar.</li>";
}

if (file_exists('conexion_pdo.php') && $pdo) {
    echo "<li>✅ Base de datos configurada correctamente.</li>";
} else {
    echo "<li>❌ Verificar configuración de base de datos.</li>";
}

echo "<li>🔄 <strong>Para probar el sistema:</strong><br>";
echo "   1. Registra un estudiante en registro.html<br>";
echo "   2. Inicia sesión con las credenciales<br>";
echo "   3. Emite un voto en votar.html<br>";
echo "   4. Verifica los resultados en resultados.php</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>🕐 Verificación realizada:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><a href='index.html'>🏠 Volver al Sistema Principal</a></p>";
?>