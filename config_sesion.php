<?php
// config_sesion.php - Configuración de sesiones y funciones auxiliares

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configuración de sesión segura
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 si usas HTTPS
ini_set('session.use_strict_mode', 1);

// Función para verificar si el usuario está autenticado
function estaAutenticado() {
    return isset($_SESSION['estudiante_id']) && !empty($_SESSION['estudiante_id']);
}

// Función para obtener el ID del estudiante autenticado
function obtenerEstudianteId() {
    return $_SESSION['estudiante_id'] ?? null;
}

// Función para obtener el código del estudiante autenticado
function obtenerCodigoEstudiante() {
    return $_SESSION['codigo_estudiante'] ?? null;
}

// Función para cerrar sesión de forma segura
function cerrarSesion() {
    session_unset();
    session_destroy();
    session_start();
    session_regenerate_id(true);
}

// Función para redirigir si no está autenticado
function requireAuth($redirectUrl = 'login.html') {
    if (!estaAutenticado()) {
        header("Location: $redirectUrl?error=sesion");
        exit();
    }
}

// Función para redirigir si ya está autenticado
function redirectIfAuth($redirectUrl = 'votar.html') {
    if (estaAutenticado()) {
        header("Location: $redirectUrl");
        exit();
    }
}

// Función para generar código de estudiante único
function generarCodigoEstudiante() {
    return "CEPEA-" . date("Y") . "-" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
}

// Función para sanitizar entrada de datos
function sanitizarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para validar formato de código de estudiante
function validarCodigoEstudiante($codigo) {
    return preg_match('/^CEPEA-\d{4}-\d{4}$/', $codigo);
}

// Función para validar DNI (formato básico)
function validarDNI($dni) {
    return preg_match('/^\d{8}$/', $dni);
}

// Configuración de zona horaria
date_default_timezone_set('America/Lima'); // Cambiar según tu zona horaria

// Configuración de errores (desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>