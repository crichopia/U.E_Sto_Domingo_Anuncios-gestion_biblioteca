<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$root = realpath(__DIR__ . '/..');
$target = realpath($root . $uri);

// Si piden la raíz o un directorio, intenta cargar index.php o el archivo solicitado
if ($target && strpos($target, $root) === 0) {
    if (is_dir($target)) {
        $target = rtrim($target, '/') . '/index.php';
    }
    
    if (file_exists($target) && pathinfo($target, PATHINFO_EXTENSION) === 'php') {
        chdir(dirname($target));
        require_once $target;
        exit;
    }
}

// Si no encuentra nada, carga el index principal
chdir($root);
require_once $root . '/index.php';