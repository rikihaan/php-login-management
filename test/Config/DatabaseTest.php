<?php
namespace ProgrammerZamanNow\Belajar\PHP\MVC\Config;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class DatabaseTest extends TestCase{
    public function testGetConnection(){
        $connection= Database::getConnection();

        self::assertNotNull($connection);
    }

    public function testGetConnectionSingleTon(){
        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();

        self:assertSame($connection1,$connection2);
    }

}