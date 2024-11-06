<?php
declare(strict_types=1);

namespace Robert\Materialverwaltung\Entity;
use PDO;

class Item
{
    private string $name;
    private string $group;
    private int $amount;
    private PDO $database;
    public function __construct(string $name, string $group, int $amount)
    {
        $this->name = $name;
        $this->group = $group;
        $this->amount = $amount;
        $this->database = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    }

    public function create(): bool
    {
        $stmt = $this->database->prepare("INSERT INTO item (name, group, amount) VALUES (?, ?, ?)");
        $result = $stmt->execute([
            "name" => $this->name,
            "group" => $this->group,
            "amount" => $this->amount
        ]);
        return $result;
    }
}