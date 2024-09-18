<?php
namespace Item;

class Item {
    // Properties
    public $name;
    public $type;
    public $amount;

    public $status;

    function __construct($name, $type, $amount) {
      $this->name = $name;
      $this->type = $type;
      $this->amount = $amount;
    }

    function registerItem($conn) {

    }

    function deleteItems($conn) {}
}
?>

