<?php

declare(strict_types=1);

namespace Rinsvent\ExceptionBundle;

use Rinsvent\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Exception extends AbstractException implements HttpExceptionInterface
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;

    public function toArray() {
        return [
            'codeText' => $this->getCodeText(),
            'code' => $this->getCode(),
            'summary' => $this->getSummary()
        ];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return [];
    }
}