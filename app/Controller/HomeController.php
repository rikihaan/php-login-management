<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;

use ProgrammerZamanNow\Belajar\PHP\MVC\App\View;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
use ProgrammerZamanNow\Belajar\PHP\MVC\Service\SessionService;

class HomeController
{
   private SessionService $sessionService;

   public function __construct()
   {
	  $connection = Database::getConnection();
	  $userRepository = new UserRepository($connection);
	  $sessionRepository = new SessionRepository($connection);
	  $this->sessionService = new SessionService($sessionRepository,$userRepository);
   }


   function index(): void
    {


	   $user = $this->sessionService->current();
	   if($user == null){
		  $model = [
			  "title" => "Belajar PHP MVC",
			  "content" => "Selamat Belajar PHP MVC dari Programmer Zaman Now"
		  ];
		  View::render('Home/index', $model);
	   }else{
		  $model = [
			  "title" => "Belajar PHP MVC",
			  "content" => "Selamat Belajar PHP MVC dari Programmer Zaman Now",
			 "user"=>[
				 "name"=> $user->name
			 ]
		  ];
		  View::render('User/dashboard', $model);

	   }

    }

    function hello(): void
    {
        echo "HomeController.hello()";
    }

    function world(): void
    {
        echo "HomeController.world()";
    }

    function about(): void
    {
        echo "Author : Eko Kurniawan Khannedy";
    }

    function login(): void
    {
        $request = [
            "username" => $_POST['username'],
            "password" => $_POST['password']
        ];

        $user = [

        ];

        $response = [
            "message" => "Login Sukses"
        ];
        // kirimkan response ke view
    }

}