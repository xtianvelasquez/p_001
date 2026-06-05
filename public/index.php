<?php
session_start();

// Autoloader for namespaces
spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/../';
    // Convert namespace separators to directory separators
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use Core\Router;

$router = new Router();

// --- Frontend Routes ---
$router->add('GET', '/', function() {
    require __DIR__ . '/../modules/Frontend/Views/home.php';
});
$router->add('GET', '/reservation', function() {
    require __DIR__ . '/../modules/Frontend/Views/reservation.php';
});
$router->add('GET', '/admin', function() {
    require __DIR__ . '/../modules/Admin/Views/admin.php';
});
$router->add('GET', '/admin/login', function() {
    require __DIR__ . '/../modules/Admin/Views/admin_login.php';
});
$router->add('GET', '/terms', function() {
    require __DIR__ . '/../modules/Terms/Views/tc_index.php';
});

// --- API Routes ---
$router->add('POST', '/api/reservations', ['Modules\Reservation\Controllers\ReservationAPIController', 'create']);
$router->add('GET', '/api/reservations', ['Modules\Reservation\Controllers\ReservationAPIController', 'index']);
$router->add('GET', '/api/reservations/availability', ['Modules\Reservation\Controllers\ReservationAPIController', 'availability']);
$router->add('PUT', '/api/reservations/{id}', ['Modules\Reservation\Controllers\ReservationAPIController', 'update']);
$router->add('DELETE', '/api/reservations/{id}', ['Modules\Reservation\Controllers\ReservationAPIController', 'delete']);
$router->add('POST', '/api/auth/login', ['Modules\Auth\Controllers\AuthController', 'login']);
$router->add('POST', '/api/auth/logout', ['Modules\Auth\Controllers\AuthController', 'logout']);
$router->add('GET', '/api/terms', ['Modules\Terms\Controllers\TermsAPIController', 'index']);

// Dispatch the current request
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);
