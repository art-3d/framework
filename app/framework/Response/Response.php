<?php

declare(strict_types=1);

namespace Framework\Response;

class Response implements ResponseInterface
{
    public string $type = 'html';
    protected array $headers = [];

    public function __construct(
        protected string $content,
        protected string $message = '',
        protected int $code = 200,
    ) {
    }

    public function send(): void
    {
        $this->setHeader('HTTP/1.1 '.$this->code.' '.$this->message);
        header(implode("\n", $this->headers));

        echo $this->content;
    }

    public function setHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
