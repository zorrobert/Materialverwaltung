<?php
namespace Robert\Materialverwaltung;

class Request
{
    private array $get;
    private array $post;
    private array $session;
    private array $cookie;

    public function __construct(array $get, array $post, array $session, array $cookie)
    {
        $this->get = $get;
        $this->post = $post;
        $this->session = $session;
        $this->cookie = $cookie;
    }

    public static function fromSuperglobals():self
    {
        return new self($_GET, $_POST, $_SESSION, $_COOKIE);
    }

    public function getAction()
    {
        return $this->get["action"] ?? 'error';
    }
    public function getQueryParameter(string $name)
    {
        return $this->post[$name] ?? null;
    }
}