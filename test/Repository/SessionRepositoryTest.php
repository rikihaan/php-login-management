<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Repository;


use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\user;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp():void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user =new user();
        $user->id="riki";
        $user->name="Asep Riki";
        $user->password="rahasiah";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id =uniqid();
        $session->userId="riki";
        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id,$result->id);
        self::assertEquals($session->userId,$result->userId);

    }

    public function testDeleteByIdSuccess()
    {
        $user =new user();
        $user->id="riki";
        $user->name="Asep Riki";
        $user->password="rahasiah";
        $this->userRepository->save($user);
        $session = new Session();
        $session->id =uniqid();
        $session->userId="riki";
        $this->sessionRepository->save($session);

        $this->sessionRepository->deleteById($session->id);

        $resultl = $this->sessionRepository->findById($session->id);
        self::assertNull($resultl);

    }

    public function testFindByIdNotfound(){
        $resultl = $this->sessionRepository->findById("notFount");
        self::assertNull($resultl);
    }

}
