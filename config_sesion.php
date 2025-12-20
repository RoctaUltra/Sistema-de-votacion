<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 si usas HTTPS
ini_set('session.use_strict_mode', 1);

function estaAutenticado() {
    return isset($_SESSION['estudiante_id']) && !empty($_SESSION['estudiante_id']);
}

function obtenerEstudianteId() {
    return $_SESSION['estudiante_id'] ?? null;
}

function obtenerCodigoEstudiante() {
    return $_SESSION['codigo_estudiante'] ?? null;
}

function cerrarSesion() {
    session_unset();
    session_destroy();
    session_start();
    session_regenerate_id(true);
}

function requireAuth($redirectUrl = 'login.html') {
    if (!estaAutenticado()) {
        header("Location: $redirectUrl?error=sesion");
        exit();
    }
}

function redirectIfAuth($redirectUrl = 'votar.html') {
    if (estaAutenticado()) {
        header("Location: $redirectUrl");
        exit();
    }
}

function generarCodigoEstudiante() {
    return "CEPEA-" . date("Y") . "-" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
}

function sanitizarEntrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarCodigoEstudiante($codigo) {
    return preg_match('/^CEPEA-\d{4}-\d{4}$/', $codigo);
}

function validarDNI($dni) {
    return preg_match('/^\d{8}$/', $dni);
}

date_default_timezone_set('America/Lima'); // Cambiar según tu zona horaria

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>