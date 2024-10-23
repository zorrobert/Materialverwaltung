<?php
namespace Robert\Materialverwaltung\Controller;

use PDO;
use Robert\Materialverwaltung\Response;

class ItemController
{
    private PDO $database;

    public function __construct()
    {
        $this->database = new PDO('mysql:host=127.0.0.1;dbname=material', 'material', 'material');
    }

    public function getItems(): array
    {
        $stmt = $this->database->prepare("SELECT * FROM item");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}