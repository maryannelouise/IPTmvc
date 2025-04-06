<?php
// Include configuration and routes using require_once
require_once __DIR__.'/routes/config.php'; // Configuration for routes, etc.
$routes = require_once __DIR__.'/routes/routes.php'; // Routes definition

// Include the controllers with require_once to prevent multiple inclusions
require_once __DIR__.'/controller/HomeController.php';
require_once __DIR__.'/controller/UserController.php';
require_once __DIR__.'/controller/ApiController.php';
require_once __DIR__.'/controller/DoctorController.php';
require_once __DIR__.'/controller/AppointmentController.php';


// Get the current path from the ?url= query parameter (set by .htaccess)
$path = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';

// Normalize the path (fallback to '/' if accessing index.php directly)
if ($path === '/index.php') $path = '/';

// Route handling: check if the path exists in the $routes array
if (isset($routes[$path])) {
    // Retrieve the controller class and method
    [$controllerClass, $method] = $routes[$path];
    
    // Check if the controller class exists before instantiation
    if (class_exists($controllerClass)) {
        // Instantiate the controller
        $controller = new $controllerClass();
        
        // Check if the method exists in the controller class
        if (method_exists($controller, $method)) {
            // Call the method
            $controller->$method();
        } else {
            // If method doesn't exist, show an error
            http_response_code(500);
            echo "Method '$method' not found in controller '$controllerClass'.";
        }
    } else {
        // If class doesn't exist, show an error
        http_response_code(500);
        echo "Controller class '$controllerClass' not found.";
    }
} else {
    // If the route is not defined in $routes, show 404
    http_response_code(404);
    echo "404 Not Found - Path: $path";
}

