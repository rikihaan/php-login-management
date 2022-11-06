<?php

   namespace ProgrammerZamanNow\Belajar\PHP\MVC\Middleware;
   use ProgrammerZamanNow\Belajar\PHP\MVC\App\View;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Service\SessionService;

   class MiddlewareMushNotLogin implements Middleware
   {
	  private SessionService $sessionService;
	  Private UserRepository $userRepository;

	  public function __construct()
	  {
		 $this->userRepository=new UserRepository(Database::getConnection());
		 $sessionRepository = new SessionRepository(Database::getConnection());
		 $this->sessionService = new SessionService($sessionRepository,$this->userRepository);
	  }

	  function before(): void
	  {
		 $user = $this->sessionService->current();
		 if($user != null){
			View::redirect("/");
		 }

	  }

   }