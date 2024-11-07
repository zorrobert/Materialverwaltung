<?php
namespace Robert\Materialverwaltung\Controller;
use Robert\Materialverwaltung\Request;
use Robert\Materialverwaltung\Response;

class ActionController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function test(): Response
    {
        return new Response(["hello world from ActionController->test()"], 200, "This is an error");
    }

    # User Actions
    public function loginUser(): Response
    {
        return new Response([]);
    }
    public function logoutUser(): Response
    {
        return new Response([]);
    }
    public function registerUser(): Response
    {
        return new Response([]);
    }
    public function deleteUser(): Response
    {
        return new Response([]);
    }
    public function loadUser(): Response
    {
        return new Response([]);
    }
    public function adminCreateUser(): Response
    {
        return new Response([]);
    }
    public function adminDeleteUser(): Response
    {
        return new Response([]);
    }

    # Permission Actions
    public function hasPermission(): Response
    {
        return new Response([]);
    }
    
    # Item Actions
    public function createItems(): Response
    {
        return new Response([]);
    }
    public function deleteItems(): Response
    {
        return new Response([]);
    }
    public function editItems(): Response
    {
        return new Response([]);
    }
    public function getListItems(): Response
    {
        return new Response([]);
    }

    # Loan Actions
    public function createLoan(): Response
    {
        return new Response([]);
    }
    public function revertLoan(): Response
    {
        return new Response([]);
    }
    public function approveLoan(): Response
    {
        return new Response([]);
    }
    public function handedOutLoan(): Response
    {
        return new Response([]);
    }
    public function handedInLoan(): Response
    {
        return new Response([]);
    }
}