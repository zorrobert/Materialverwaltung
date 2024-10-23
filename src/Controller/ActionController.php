<?php
namespace Robert\Materialverwaltung\Controller;

use Robert\Materialverwaltung\Request;
use Robert\Materialverwaltung\Response;
use Robert\Materialverwaltung\Entity\User;

class ActionController
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function test(): Response
    {
        var_dump(password_hash("paduch", PASSWORD_BCRYPT));
        return new Response(["testDaten"], 200, "");
    }

    public function login(): Response
    {
        $username = $this->request->getQueryParameter("username");
        if (empty($username)) {
            return new Response([], 401, "Login failed: No username");
        }
        $password = $this->request->getQueryParameter("password");
        $user = new User($username);

        if ($user->login($password)) {
            $_SESSION["user"] = $username;
            return new Response([], 200);
        } else {
            return new Response([], 401, "Login failed: Incorrect username or password");
        }
    }

    public function listItems(): Response
    {
        $itemController = new ItemController();
        $data = $itemController->getItems();
        return new Response($data, 200);
    }


    /*sequenceDiagram
participant Client
participant Server
participant Database
Client->>+Server: action=getChallenge
Note over Server: Generate $challenge <str>, $challengeHash and $challengeID <int>
Server->>+Database: store timestamp, $challenge and $challengeID
Server->>-Client: {challengeID=<int>, challenge="<str>"}

Note over Client: User enters <username> and <password>
Note over Client: <passwordHash> = hash(sha256, <password>)
    Note over Client: <response> = hash(sha256, <hashedPassword> + <challenge>)

    Client->>+Server: action=login<br>&username=<username><br>&challenge=<challengeID><br>&response=<response>
Note over Server: Generate Token from own Data
    Server->>Database: get $challenge where $challengeID == <challengeID>
Database->>-Server: $challenge

    Server->>+Database: get $passwordHash where $username == <username>
Database->>-Server: $passwordHash
    Note over Server: $response = hash(sha256, $passwordHash+$challenge)
    alt $response == <response>
Server->>Client: [{"authToken":"secretToken"},""]
    else $response != <response>
Server->>-Client: [{"authToken":""},"Login failed, incorrect username or password"]
    end

    Note over Client: Store <secretToken> for later authentication*/
}