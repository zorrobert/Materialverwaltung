<?php
namespace Robert\Materialverwaltung;

#use PDO;
#use PDOException;
#echo("test");
# 

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    }

    public function test() {
        return("test");
    }
    
    
}
