<?php

namespace Rinsvent\ExceptionBundle;

use Rinsvent\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Exception extends AbstractException implements HttpExceptionInterface
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;

    public function toArray() {
        $message = [
            'code_text' => $this->getCodeText(),
            'message' => $this->getMessage()
        ];
        if ($this->getCode()) {
            $message['code'] = $this->getCode();
        }
        return $message;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return [];
    }
}