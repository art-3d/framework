<?php

namespace CMS\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;

class Profile extends ActiveRecord{
	
    public $email;
    public $password;

    public static function getTable()
    {
        return 'users';
    }
	
	public function updateProfile()
	{
		$query = "UPDATE `" . $this->getTable() . "` SET `password`='" . $this->password . "' WHERE `email`='" . $this->email . "'";
		if(!$this->query($query)){
			throw new \Exception('Update profile error');
		}
	}
	
	
}