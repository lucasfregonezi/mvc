<?php

namespace App\Http;

class Response
{
    private int $httpCode = 200;
    private array $headers = [];
    private string $contentType = 'text/html';
    private mixed $content;

    public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }


    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    private function sendHeaders(): void
    {
        http_response_code($this->httpCode);

        foreach($this->headers as $key=>$value) {
            header($key . ': ' . $value);
        }
    }

    public function sendResponse(): void
    {
        $this->sendHeaders();
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

}
