<?php

namespace Cms\Controller;

use Framework\Controller\Controller;
use CMS\Model\Profile;
use Framework\Exception\DatabaseException;
use Framework\Exception\HttpNotFoundException;
use Framework\Response\ResponseInterface;
use Framework\Security\Security;
use Framework\Session\Session;

class ProfileController extends Controller
{
	public function __construct(
		private Session $session,
		private Security $security,
	) {
	}

	public function updateAction(): ResponseInterface
	{
		if (!$this->security->isAuthenticated()) {
			return $this->redirect($this->generateRoute('home'), 'You must be logged');
		}
		if ($this->getRequest()->isPost()) {
			try {
				$request = $this->getRequest();
				$user = $this->session->get('user');
				$password = $request->post('password');
				$pswd_new = $request->post('password_new');
				$pswd_new_copy = $request->post('password_new_copy');
				if (md5($password) === $user->password && $pswd_new === $pswd_new_copy && $user->password != md5($pswd_new)) {
					$profile = new Profile;
					$profile->email = $user->email;
					$profile->password = md5($pswd_new);
					$profile->updateProfile();
					$this->security->clear();

					return $this->redirect($this->generateRoute('home'), 'The password has been updated');
				} else {
					throw new \Exception('An error in the password');
				}
			} catch (DatabaseException $e) {
				$error = $e->getMessage();
			}
		}
        if (!$profile = $this->session->get('user')) {
            throw new HttpNotFoundException('Profile is not found!');
        }
	
		return $this->render('update.html', array('profile' => $profile));
	}	
}
