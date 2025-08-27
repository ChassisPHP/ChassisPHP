<?php
// tests/bootstrap-minimal.php
// Minimal bootstrap for framework unit tests without vendor/ dependencies

error_reporting(E_ALL | E_STRICT);

// Define APP_ROOT for framework testing
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

// Basic autoloader for framework classes only (no vendor/ needed)
spl_autoload_register(function ($class) {
    // Only load ChassisPHP framework classes
    if (strpos($class, 'ChassisPHP\\') === 0) {
        $file = str_replace('\\', '/', $class);
        $file = str_replace('ChassisPHP/', '', $file);
        $path = APP_ROOT . '/src/' . $file . '.php';
        
        if (file_exists($path)) {
            require_once $path;
            return true;
        }
    }
    
    // Load test classes
    if (strpos($class, 'Tests\\') === 0) {
        $file = str_replace('\\', '/', $class);
        $file = str_replace('Tests/', '', $file);
        $path = APP_ROOT . '/tests/' . $file . '.php';
        
        if (file_exists($path)) {
            require_once $path;
            return true;
        }
    }
    
    return false;
});

// Load essential mocks only if interfaces don't exist
if (!interface_exists('Psr\\Http\\Message\\ServerRequestInterface')) {
    require_once __DIR__ . '/Mocks/PSR7Mocks.php';
}

if (!interface_exists('Psr\\Container\\ContainerInterface')) {
    require_once __DIR__ . '/Mocks/PSR11Mocks.php';
}

if (!class_exists('League\\Container\\Container')) {
    require_once __DIR__ . '/Mocks/ContainerMocks.php';
}

if (!class_exists('FastRoute\\Dispatcher')) {
    require_once __DIR__ . '/Mocks/FastRouteMocks.php';
}

// Set up minimal test environment
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';
$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ?? 'localhost';
$_SERVER['SERVER_NAME'] = $_SERVER['SERVER_NAME'] ?? 'localhost';
$_SERVER['SERVER_PORT'] = $_SERVER['SERVER_PORT'] ?? 80;

// Prevent headers already sent errors in tests
if (!headers_sent()) {
    ob_start();
}