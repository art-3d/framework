<?php

declare(strict_types=1);

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Model\ModelInterface;
use Framework\Security\Model\UserInterface;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class User extends ActiveRecord implements UserInterface, ModelInterface
{
    // public $id;
    public string $email;
    public string $password;
    public string $role;

    public function getTable(): string
    {
        return 'users';
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getRules()
    {
        return [
            'email' => [
                new NotBlank(),
                new Length(5, 100),
            ],
            'password' => [new NotBlank()],
        ];
    }
}
