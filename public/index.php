<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProgrammerZamanNow\Belajar\PHP\MVC\App\Router;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;
use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\UserController;
 use  ProgrammerZamanNow\Belajar\PHP\MVC\Middleware\MiddlewareMushNotLogin;
 use  ProgrammerZamanNow\Belajar\PHP\MVC\Middleware\MiddlewareMushLogin;

// panggil database
Database::getConnection('prod');

// home 
Router::add('GET', '/', HomeController::class, 'index', []);
// user regitration
Router::add('GET', '/users/register', UserController::class, 'register', [MiddlewareMushNotLogin::class]);
// post Register
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MiddlewareMushNotLogin::class]);
Router::add('GET', '/users/login', UserController::class, 'login', [MiddlewareMushNotLogin::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MiddlewareMushNotLogin::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MiddlewareMushLogin::class]);
Router::run();
