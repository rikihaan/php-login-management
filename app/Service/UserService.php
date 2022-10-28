<?php
namespace ProgrammerZamanNow\Belajar\PHP\MVC\Service;

use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\User;
use ProgrammerZamanNow\Belajar\PHP\MVC\Exception\ValidationException;
use ProgrammerZamanNow\Belajar\PHP\MVC\Model\UserRegisterRequest;
use ProgrammerZamanNow\Belajar\PHP\MVC\Model\UserRegisterResponse;
use ProgrammerZamanNow\Belajar\PHP\MVC\Repository\UserRepository;

class UserService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }
    public function register(UserRegisterRequest $request):UserRegisterResponse{
        $this->validateUserRegistrationRequest($request);

        // melakukan pengecekan apah user suda ada
        $user = $this->userRepository->findById($request->id);
        if($user !=null){
            // artinya user ada
            throw new ValidationException("User already exist");
        }

        $user = new User();
        $user->id = $request->id;
        $user->name = $request->name;
        $user->password = password_hash($request->password,PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $response = new UserRegisterResponse();
        $response->user = $user;
        return $response;

    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request){
        if($request->id==null||$request->name==null ||$request->password ==null || trim($request->id)=="" || trim($request->name) == ""|| trim($request->password)==""){
            throw new ValidationException("id,name and password can not blank");
        }
    }
}