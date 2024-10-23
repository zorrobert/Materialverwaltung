<?php
declare(strict_types=1);

namespace Robert\Materialverwaltung\Controller;

class ItemController
{
    public function __construct()
    {
        # $this->request = $request;
    }

    public function getItems(): array
    {
        return ["bide"];
    }
}