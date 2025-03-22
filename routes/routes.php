<?php
use controller\ApiController;
use controller\HomeController;
use controller\UserController;


return [
    '/' => [HomeController::class, 'index'], 
    '/login' => [UserController::class, 'login'], 
    '/register' => [UserController::class, 'register'], 
    '/logout' => [UserController::class, 'logout'],
    '/changePicture' => [UserController::class, 'changePicture'],

    // API routes
    '/api/users' => [ApiController::class, 'users'],
    '/api/login' => [ApiController::class, 'login'],
];
