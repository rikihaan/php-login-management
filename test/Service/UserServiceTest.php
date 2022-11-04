<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
use ProgrammerZamanNow\Belajar\PHP\MVC\Exception\ValidationException;
use ProgrammerZamanNow\Belajar\PHP\MVC\Model\UserLoginRequest;
use ProgrammerZamanNow\Belajar\PHP\MVC\Model\UserRegisterRequest;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
use ProgrammerZamanNow\Belajar\PHP\MVC\Service\UserService;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->id = "riki";
        $request->name = "Asep Riki";
        $request->password = "rahsiah";

        $response = $this->userService->register($request);
        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";
        $this->userService->register($request);
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = "riki";
        $user->name = "Asep Riki";
        $user->password = "rahasiah";
        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $user->id = "riki";
        $user->name = "Asep Riki";
        $user->password = "rahasiah";
        $this->userService->register($request);
    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = "eko";
        $request->password = "rahasiah";

        $this->userService->login($request);
    }

    public function testLoginWorngPassword()
    {
        $user = new User();
        $user->id = "riki";
        $user->name = "Asep Riki";
        $user->password = password_hash('rahasiah', PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = "riki";
        $request->password = "salah";
        $this->userService->login($request);
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->id = "riki";
        $user->name = "Asep Riki";
        $user->password = password_hash('rahasiah', PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = "riki";
        $request->password = "rahasiah";
        $response = $this->userService->login($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }
}
