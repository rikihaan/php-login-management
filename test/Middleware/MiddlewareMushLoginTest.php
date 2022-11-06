<?php
   namespace ProgrammerZamanNow\Belajar\PHP\MVC\App {
	  function header(string $url)
	  {
		echo $url;

	  }
   }

   namespace ProgrammerZamanNow\Belajar\PHP\MVC\Middleware{
	  use PHPUnit\Framework\TestCase;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\user;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
	  use ProgrammerZamanNow\Belajar\PHP\MVC\Service\SessionService;

	  class MiddlewareMushLoginTest extends TestCase
	  {
		 private MiddlewareMushLogin $middlewareMushLogin;
		 private UserRepository $userRepository;
		 private SessionRepository $sessionRepository;

		 protected function setUp():void
		 {
			$this->middlewareMushLogin = new MiddlewareMushLogin();
			putenv("mode=test");
			$this->userRepository = new UserRepository(Database::getConnection());
			$this->sessionRepository = new SessionRepository(Database::getConnection());
			$this->sessionRepository->deleteAll();
			$this->userRepository->deleteAll();

		 }

		 public function testBifore()
		 {
			$this->middlewareMushLogin->before();

			$this->expectOutputRegex("[Location:/users/login]");

		 }

		 public function testBiforeUserLogin()
		 {

			$user = new user();
			$user->id = "riki";
			$user->name = "Asep Riki";
			$user->password = password_hash("rahasiah",PASSWORD_BCRYPT);
			$this->userRepository->save($user);

			$session = new Session();
			$session->id = uniqid();
			$session->userId = $user->id;
			$this->sessionRepository->save($session);

			$_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

			$this->middlewareMushLogin->before();
			$this->expectOutputString("");

		 }


	  }

   }

