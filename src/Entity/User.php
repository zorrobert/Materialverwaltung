<?php
namespace Robert\Materialverwaltung\Entity;

use PDO;

class User
{
    //private PDO $pdo = PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    public string $username;
    public string $passwordHash;
    public string $displayName;
    private string $authToken;
    private PDO $database;

    public function __construct(string $username, string $passwordHash = "", string $displayName = "")
    {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->displayName = $displayName;
        $this->authToken = "";
        $this->database = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    }

    public function login($password): bool
    {
        return ($this->username === $password);
    }

    public function pullData()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');

        $stmt = $pdo->prepare("SELECT * FROM Users where username = ?");
        $stmt->execute([$this->username]);
        $result = $stmt->fetchAll();
        if (sizeof($result) > 1) { throw new Exception("More than one user found in database for username"); }
        $user = $result[0];

        $this->passwordHash = $user["password"];
    }

    public function createAuthToken(): string
    {
        $token = random_bytes(32);
        var_dump(bin2hex($token));

        $stmt = $this->database->prepare("INSERT INTO auth_token (token_hash, user) values (?, ?)");
        $stmt->execute([hash("sha256", $token), $this->username]);
        return $token;
    }
}