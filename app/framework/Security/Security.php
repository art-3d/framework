<?php

declare(strict_types=1);

namespace Framework\Security;

use Framework\Session\Session;

class Security
{
    public function __construct(private Session $session)
    {
    }

    public function setUser($user): void
    {
        $this->session->set('user', json_encode($user));
    }

    public function clear(): void
    {
        $this->session->destroy();
    }

    public function isAuthenticated(): bool
    {
        return $this->session->getUser() ? true : false;
    }
}
