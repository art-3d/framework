<?php

declare(strict_types=1);

namespace Framework\Response;

class ResponseRedirect extends Response
{
    public string $type = 'redirect';

    public function __construct(string $url)
    {
        header('Location: '.$url);
    }
}
