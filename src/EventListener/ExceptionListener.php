<?php

namespace Rinsvent\ExceptionBundle\EventListener;

use Rinsvent\ExceptionBundle\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof Exception) {
            $message = $exception->toArray();
        }

        $response = new JsonResponse(
            $message ?? [
                'message' => $exception->getMessage()
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }

        $event->setResponse($response);
    }
}
