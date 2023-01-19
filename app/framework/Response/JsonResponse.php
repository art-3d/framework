<?php

declare(strict_types=1);

namespace Framework\Response;

class JsonResponse extends Response
{
    public string $type = 'json';

    public function __construct(private array $data)
    {
        parent::__construct(json_encode($data));
        $this->setHeader('Content-Type: application/json');
    }
}
