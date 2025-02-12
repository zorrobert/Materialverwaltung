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
        $event->stopPropagation();
        # see https://hantsy.github.io/symfony-rest-sample/api/ex/ for details
        $exception = $event->getThrowable(); # get the exception object from the received event

        # check if this is a custom exception from the application
        switch (true) {
            # User Error: code 400
            case $exception instanceof InvalidInputException:
            case $exception instanceof MissingInputException:
                $response = new BackendResponse(
                    NULL,
                    400,
                    NULL, # there is no data
                    $exception->getMessage() ?? $exception # return the exception message
                );
                break;
        }

        # If the exception has not been caught in the case block, we return the full exception
        if (!isset($response)) {
            # return the exception as is
            $response = new BackendResponse('An uncaught Kernel Exception was thrown: '.$exception);
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
