<?php

declare(strict_types=1);

namespace Framework\Request;

class Request
{
    public function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getURI(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost(): bool
    {
        return 'POST' === $this->getMethod();
    }

    public function post(string $name): ?string
    {
        return isset($_POST[$name]) ? $this->filter($_POST[$name]) : null;
    }

    public function get(string $name): ?string
    {
        return isset($_GET[$name]) ? $this->filter($_GET[$name]) : null;
    }

    private function filter(string $var): string
    {
        $var = trim($var);
        $var = strip_tags($var);
        $var = htmlentities($var, ENT_QUOTES, 'UTF-8');

        return htmlspecialchars($var, ENT_QUOTES);
    }
}
