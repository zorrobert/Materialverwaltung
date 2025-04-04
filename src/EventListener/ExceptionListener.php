<?php

namespace App\EventListener;

use App\Exception\InvalidInputException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\BackendResponse;
use App\Exception\MissingInputException;

# https://symfony.com/doc/current/http_client.html#handling-exceptions
final class ExceptionListener
{
    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (
            $exception instanceof InvalidInputException
            || $exception instanceof MissingInputException
        ) {
            $response = new BackendResponse(
                NULL,
                400,
                NULL, # there is no data
                $exception->getMessage() ?? $exception # return the exception message
            );
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $event->setResponse($response);
        }
    }
}
