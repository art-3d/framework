<?php

namespace Cms\Controller;

use Framework\Controller\Controller;
use Framework\DI\Service;
use CMS\Model\Profile;

class ProfileController extends Controller
{
	
	public function updateAction()
	{
		if(!Service::get('security')->isAuthenticated()){
			return $this->redirect($this->generateRoute('home'), 'You must be logged');
		}
		
		if($this->getRequest()->isPost()){
			try{
				$request = $this->getRequest();
				$user = Service::get('session')->get('user');
				
				$password = $request->post('password');
				$pswd_new = $request->post('password_new');
				$pswd_new_copy = $request->post('password_new_copy');
				
				if(md5($password) == $user->password && $pswd_new == $pswd_new_copy && $user->password != md5($pswd_new)){
					
					$profile = new Profile;
					$profile->email = $user->email;
					$profile->password = md5($pswd_new);
					$profile->updateProfile();
					Service::get('security')->clear();
					return $this->redirect($this->generateRoute('signin'));
				}else{
					throw new \Exception('An error in the password');
				}				
			}catch(DatabaseException $e){
				$error = $e->getMessage();
			}
		}
		
        if (!$profile = Service::get('session')->get('user')) {
            throw new HttpNotFoundException('Profile Not Found!');
        }
		return $this->render('update.html', array('profile' => $profile));		
	}	
}