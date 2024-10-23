<?php
namespace Robert\Materialverwaltung;
class Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function testAction(): Response
    {
        $response = [
            "testAction",
            $this->request->getQueryParameter("new")
        ];

        return new Response($response, 201);
    }

}