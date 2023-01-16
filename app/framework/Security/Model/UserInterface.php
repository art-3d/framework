<?php

declare(strict_types=1);

namespace Framework\Security\Model;

interface UserInterface
{
    public function getTable(): string;

    public function getRole(): string;
}
