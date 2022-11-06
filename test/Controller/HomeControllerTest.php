<?php

   namespace ProgrammerZamanNow\Belajar\PHP\MVC\Service {
	  function setcookie(string $name, string $value)
	  {
			echo "$name : $value";

	  }
   }

   namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller{
	  use PHPUnit\Framework\TestCase;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\user;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Service\SessionService;



	  class HomeControllerTest extends TestCase
	  {
		 private SessionService $sessionService;
		 private HomeController $homeController;
		 private UserRepository $userRepository;
		 private SessionRepository $sessionRepository;

		 protected function setUp():void
		 {
			$connection = Database::getConnection();
			$this->userRepository = new UserRepository($connection);
			$this->sessionRepository = new SessionRepository($connection);
			$this->homeController =new HomeController();
			$this->sessionService = new SessionService($this->sessionRepository,$this->userRepository);
			$this->sessionRepository->deleteAll();
			$this->userRepository->deleteAll();

		 }

		 public function testGuest()
		 {
			$this->homeController->index();
			$this->expectOutputRegex("[Login Management]");
		 }

		 public function testLoginSuccess()
		 {
			$user = new user();
			$user->id="riki";
			$user->name = "Riki";
			$user->password = password_hash("rahasiah",PASSWORD_BCRYPT);
			$this->userRepository->save($user);

//		 session
			$session = new Session();
			$session->id=uniqid();
			$session->userId = $user->id;
			$this->sessionRepository->save($session);
			$_COOKIE[SessionService::$COOKIE_NAME]=$session->id;

			$this->expectOutputRegex("[Hello Riki]");
			$this->homeController->index();
		 }


	  }

   }

