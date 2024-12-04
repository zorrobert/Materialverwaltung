<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class BackendResponse extends JsonResponse
{
    public function __construct(
        string $message = NULL,
        int $status = 200,
        array $data = NULL,
        string $error = NULL
    )
    {
        $body = [
            'data' => $data,
            'info' => [
                'message' => $message,
                'error' => $error
            ]
        ];
        parent::__construct($body, $status);
    }
}