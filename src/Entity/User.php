<?php
namespace User;

class User {
  // Properties
  public $username;
  public $password;

  function __construct($username, $password) {
    $this->username = $username;
    $this->password = $password;
  }

  // $username
  function set_username($username) {
    $this->username = $username;
  }
  function get_username() {
    return $this->username;
  }

  // $password
  function set_password($password) {
    $this->password = $password;
  }
  function get_password() {
    return $this->password;
  }

  function registerUser() {
    return True;
  }
}
?>
