<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\App {
function header(string $value)
{
    echo $value;
}
}

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller {

use PHPUnit\Framework\TestCase;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;

class UserControllerTest extends TestCase
{
    private UserController $usercontroller;
    private UserRepository $userrepository;

    public function setUp(): void
    {
        $this->usercontroller = new UserController();
        $this->userrepository = new UserRepository(Database::getConnection());
        $this->userrepository->deleteAll();
        putenv("mode=test");
    }

    public function testRegister()
    {
        $this->usercontroller->register();
        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[name]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[User Register]");
    }

    public function testPostRegisterSuccess()
    {
        $_POST['id'] = "jaka";
        $_POST['name'] = "Jaka Tongkir";
        $_POST['password'] = "rahasiah";

        $this->usercontroller->postRegister();
        $this->expectOutputRegex("[Location:/users/login]");
    }

    public function testPostRegisterValidationError()
    {
        $_POST['id'] = " ";
        $_POST['name'] = "";
        $_POST['password'] = "";

        $this->usercontroller->register();

        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[name]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[User Register]");
        $this->expectOutputString("id,name and password can not blank");
    }

    public function testPostRegisterDuplicate()
    {
        $user = new User();
        $user->id = "riki";
        $user->name = "Asep Riki";
        $user->password = "rahasiah";
        $this->userrepository->save($user);

        $_POST['id'] = "riki";
        $_POST['name'] = "Asep Riki";
        $_POST['password'] = "rahasiah";

        $this->usercontroller->postRegister();
        $this->expectOutputRegex("[Register]");
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[name]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[User Register]");
        $this->expectOutputRegex("[User already exist]");
    }

    public function testLogin()
    {
        $this->usercontroller->login();
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[Login Page]");
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->id="riki";
        $user->name="Asep Riki";
        $user->password=password_hash("rahasiah",PASSWORD_BCRYPT);
        $this->userrepository->save($user);

        $_POST['id']="riki";
        $_POST['password']="rahasiah";

        $this->usercontroller->postLogin();
        $this->expectOutputRegex("[/]");
    }

    public function testLoginvalidationError()
    {
        $_POST['id']="";
        $_POST['password']="";
        $this->usercontroller->postLogin();

        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[Login Page]");
        $this->expectOutputRegex("[id or password canot blank]");

    }

    public function testLoginNotFound()
    {
        $_POST['id']="notFound";
        $_POST['password']="notFound";
        $this->usercontroller->postLogin();
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[Login Page]");
        $this->expectOutputRegex("[id or password not found]");
    }

    public function testLoginWorngPassword()
    {

        $user = new User();
        $user->id="riki";
        $user->name="Asep Riki";
        $user->password=password_hash("rahasiah",PASSWORD_BCRYPT);
        $this->userrepository->save($user);

        $_POST['id']="riki";
        $_POST['password']="salah";
        $this->usercontroller->postLogin();
        $this->expectOutputRegex("[id]");
        $this->expectOutputRegex("[password]");
        $this->expectOutputRegex("[Login Page]");
        $this->expectOutputRegex("[id or password is worng]");
    }


}


}
