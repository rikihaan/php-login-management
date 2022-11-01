<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProgrammerZamanNow\Belajar\PHP\MVC\App\Router;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\HomeController;
use ProgrammerZamanNow\Belajar\PHP\MVC\Controller\UserController;

// panggil database
Database::getConnection('prod');

// home 
Router::add('GET', '/', HomeController::class, 'index', []);
// user regitration
Router::add('GET','/users/register',UserController::class,'register',[]);
// post Register
Router::add('POST','/users/register',UserController::class,'postRegister',[]);
Router::add('GET','/users/login',UserController::class,'login',[]);
Router::run();
