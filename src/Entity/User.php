<?php
namespace Robert\Materialverwaltung\Entity;
use PDO;

class User
{
    //private PDO $pdo = PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    private string $username;
    private string $passwordHash;
    private PDO $database;

    public function __construct(string $username)
    {
        $this->username = $username;
        $this->database = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    }

    public function login($password): bool
    {
        $this->pullData();
        return password_verify($password, $this->passwordHash);
    }

    public function pullData(): bool
    {
        $stmt = $this->database->prepare("SELECT * FROM user where name = ?");
        $stmt->execute([$this->username]);
        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        } else if (sizeof($result) == 1) {
            $user = $result[0];
            $this->passwordHash = $user["password_hash"];
            return true;
        } else {
            throw new Exception("More than one user found in database for username.");
        }
    }
}