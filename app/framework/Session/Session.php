<?php

declare(strict_types=1);

namespace Framework\Session;

class Session
{
    public string $returnUrl;

    public function __construct()
    {
        session_start();
    }

    public function set(string $name, string $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function get(string $name): mixed
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function getUser(): ?object
    {
        $user = $this->get('user');

        return $user ? json_decode((string) $user) : null;
    }

    public function delete(string $name): void
    {
        unset($_SESSION[$name]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function writeInfo(string $message): void
    {
        $this->set('message', json_encode(['info' => [$message]]));
    }

    public function writeError(string $message): void
    {
        $this->set('message', json_encode(['danger' => [$message]]));
    }
}
