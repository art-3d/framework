<?php

namespace CMS\Model;

use Framework\Model\ActiveRecord;

class Profile extends ActiveRecord
{
    public string $email;
    public string $password;

    public function getTable(): string
    {
        return 'users';
    }

	public function updateProfile(): void
	{
        $query = sprintf('UPDATE %s SET password = :password WHERE email = :email', self::getTable());

        $this->query($query, [
            'password' => $this->password,
            'email' => $this->email,
        ]);
	}
}
