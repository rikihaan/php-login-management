<?php

namespace ProgrammerZamanNow\Belajar\PHP\MVC\Repository;

use ProgrammerZamanNow\Belajar\PHP\MVC\Domain\Session;

class SessionRepository
{
    private  \PDO $connection;


    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session):Session{
        $statement = $this->connection->prepare("INSERT INTO sessions (id,user_id) values (?,?)");
        $statement->execute([$session->id,$session->userId]);
        return $session;
    }

}