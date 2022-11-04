<?php

declare(strict_types=1);

namespace Rinsvent\ExceptionBundle\EventListener;

use Rinsvent\ExceptionBundle\Exception;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsEventListener(event: 'kernel.exception', priority: 100, method: 'onKernelException')]
class ExceptionListener
{
    public function __construct(
        private TranslatorInterface $translator,
        private KernelInterface $kernel,
    ) {
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $message = [];
        if ($exception instanceof Exception) {
            $message = $exception->toArray();
            $translatedMessage = $this->translator?->trans($exception->getCodeText());
            if ($translatedMessage && $translatedMessage !== $exception->getCodeText()) {
                $message['message'] = $translatedMessage;
            }
        }

        if ($this->kernel->getEnvironment() !== 'prod') {
            $message['system_message'] = $exception->getMessage();
            $message['trace'] = $exception->getTrace();
        }

        $message['summary'] ??= $exception->getMessage();

        $response = new JsonResponse($message,Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->add($exception->getHeaders());
        }

        $event->setResponse($response);
    }
}
