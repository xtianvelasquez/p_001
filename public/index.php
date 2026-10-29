<?php
// When running via PHP built-in server with router script, serve existing static files directly
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
        return false;
    }
}

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
$router->add('GET', '/reservation/view', function() {
    require __DIR__ . '/../modules/Frontend/Views/reservation_view.php';
});
$router->add('GET', '/reservation/view/{code}', function($code) {
    $_GET['code'] = $code;
    require __DIR__ . '/../modules/Frontend/Views/reservation_view.php';
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
$router->add('GET', '/api/seatings', ['Modules\Reservation\Controllers\SeatingAPIController', 'index']);
$router->add('POST', '/api/seatings', ['Modules\Reservation\Controllers\SeatingAPIController', 'create']);
$router->add('PUT', '/api/seatings/{id}', ['Modules\Reservation\Controllers\SeatingAPIController', 'update']);
$router->add('PATCH', '/api/seatings/{id}/toggle', ['Modules\Reservation\Controllers\SeatingAPIController', 'toggle']);
$router->add('DELETE', '/api/seatings/{id}', ['Modules\Reservation\Controllers\SeatingAPIController', 'delete']);
$router->add('GET', '/api/seatings/floors', ['Modules\Reservation\Controllers\SeatingAPIController', 'floors']);
$router->add('POST', '/api/seatings/floors', ['Modules\Reservation\Controllers\SeatingAPIController', 'createFloor']);
$router->add('POST', '/api/reservations', ['Modules\Reservation\Controllers\ReservationAPIController', 'create']);
$router->add('GET', '/api/reservations', ['Modules\Reservation\Controllers\ReservationAPIController', 'index']);
$router->add('GET', '/api/reservations/lookup', ['Modules\Reservation\Controllers\ReservationAPIController', 'lookup']);
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
