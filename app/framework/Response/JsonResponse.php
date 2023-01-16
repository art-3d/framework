<?php

declare(strict_types=1);

namespace Framework\Response;

class JsonResponse extends Response
{
    public string $type = 'json';
    public string $msg = '';

    public function __construct(string $content)
    {
        parent::__construct($content);
        // $this->content = $content;
        $this->setHeader('HTTP/1.1 '.$this->code.' '.$this->msg);
        $this->setHeader('Content-Type: application/json');
        header(implode("\n", $this->headers));
        echo json_encode($this->getContent());

        exit;
    }
}
