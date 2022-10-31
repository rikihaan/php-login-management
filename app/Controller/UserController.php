<?php
namespace ProgrammerZamanNow\Belajar\PHP\MVC\Controller;

use ProgrammerZamanNow\Belajar\PHP\MVC\App\View;
use ProgrammerZamanNow\Belajar\PHP\MVC\Config\Database;
use ProgrammerZamanNow\Belajar\PHP\MVC\Exception\ValidationException;
use ProgrammerZamanNow\Belajar\PHP\MVC\Model\UserRegisterRequest;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;
use ProgrammerZamanNow\Belajar\PHP\MVC\Service\UserService;

class UserController {

    private UserService $userService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService= new UserService($userRepository);
    }

    // menampilkan View
    public function register (){
        View::render('User/register',[
            'title'=>'User Register'
        ]);
    }

    public function postRegister(){
        $request = new UserRegisterRequest();
        $request->id=$_POST['id'];
        $request->name=$_POST['name'];
        $request->password=$_POST['password'];

        try{
            $this->userService->register($request);
            // redirect
            View::redirect('/users/login');
        }catch(ValidationException $exception){
            View::render('User/register',[
                'title'=>'User Register',
                'error'=>$exception->getMessage()
            ]);
        }

    }

    public function login(){
        View::render('User/login',[
            'title'=>'Login Page'
        ]);
    }

}