<?php
namespace ProgrammerZamanNow\Belajar\PHP\MVC\Repository;

use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;

class UserRepositoryTest extends TestCase{
    private UserRepository $userRepository;

    public function setUp():void{
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess(){
        $user = new User();

        $user->id = "ujang";
        $user->name ="Ujang Riki";
        $user->password="rahasiah";

        $this->userRepository->save($user);

        // cek data apakah ada di database
        $result = $this->userRepository->findById($user->id);

        // test menyamalkan anatara data yng di kirim dan di ambil dari database;
        self::assertEquals($result->id,$user->id);
        self::assertEquals($result->name,$user->name);
        self::assertEquals($result->password,$user->password);
    }

    public function testFindByIdNotFound(){
        $user = $this->userRepository->findById("notfount");
        self::assertNull($user);
    }
}