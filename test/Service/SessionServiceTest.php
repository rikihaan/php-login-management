<?php

   namespace ProgrammerZamanNow\Belajar\PHP\MVC\Service;

   use PHPUnit\Framework\TestCase;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\user;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\SessionRepository;
   use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;

   function setcookie(string $name,string $value){
	  echo "$name : $value";
   }

   class SessionServiceTest extends TestCase
   {
	  private SessionRepository $sessionRepository;
	  private UserRepository $userRepository;
	  private SessionService $sessionService;

	  protected function setUp():void
	  {
		 $this->sessionRepository=new SessionRepository(Database::getConnection());
		 $this->userRepository= new UserRepository(Database::getConnection());
		 $this->sessionService = new SessionService($this->sessionRepository,$this->userRepository);
		 $this->sessionRepository->deleteAll();
		 $this->userRepository->deleteAll();

		 $user = new user();
		 $user->id="riki";
		 $user->name = "Asep Riki";
		 $user->password=password_hash("rahasiah",PASSWORD_BCRYPT);
		 $this->userRepository->save($user);

	  }

	  public function testCreate()
	  {
		 $session = $this->sessionService->create("riki");
		 $this->expectOutputRegex("[X-PZN-SESSION : $session->id]");

		 $result = $this->sessionRepository->findById($session->id);
		 self::assertEquals($result->userId,"riki");
	  }

	  public function testDestroy()
	  {
		 $session =new Session();
		 $session->id =uniqid();
		 $session->userId="riki";
		 $this->sessionRepository->save($session);

		 $_COOKIE[SessionService::$COOKIE_NAME]= $session->id;

		 $this->sessionService->destroy();

		 $this->expectOutputRegex("[X-PZN-SESSION]");

		 $result = $this->sessionRepository->findById($session->id);
		 self::assertNull($result);

	  }

	  public function testCurrent()
	  {
		 $session =new Session();
		 $session->id =uniqid();
		 $session->userId="riki";
		 $this->sessionRepository->save($session);

		 $_COOKIE[SessionService::$COOKIE_NAME]=$session->id;

		 $user = $this->sessionService->current();
		 self::assertEquals($session->userId ,$user->id);

	  }



   }
