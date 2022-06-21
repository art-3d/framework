<?php

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class User extends ActiveRecord implements UserInterface
{
    // public $id;
    public string $email;
    public string $password;
    public string $role;

    public static function getTable(): string
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
            'email'   => [
                new NotBlank(),
                new Length(5, 100),
            ],
            'password' => [new NotBlank()],
        ];
    }
}