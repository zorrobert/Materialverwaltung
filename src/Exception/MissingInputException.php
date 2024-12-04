<?php
declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MissingInputException extends HttpException
{
    public function __construct(string $message)
    {
        $headers = [];
        parent::__construct(
            Response::HTTP_BAD_REQUEST,
            $message,
            null,
            $headers,
            400
        );
    }
}