<?php
declare(strict_types=1);

namespace Robert\Materialverwaltung\Entity;

class Item
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}