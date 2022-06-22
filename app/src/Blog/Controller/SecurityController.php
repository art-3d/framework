<?php

namespace Blog\Controller;

use Blog\Model\User;
use Framework\Controller\Controller;
use Framework\Exception\DatabaseException;
use Framework\Response\ResponseInterface;
use Framework\Response\ResponseRedirect;

class SecurityController extends Controller
{
    public function loginAction(): ResponseInterface
    {
        if ($this->security->isAuthenticated()) {
            return new ResponseRedirect($this->generateRoute('home'));
        }
        $errors = [];

        if ($this->getRequest()->isPost()) {

            if ($user = (new User($this->connection))->findByEmail($this->getRequest()->post('email'))) {
                if ($user->password === md5($this->getRequest()->post('password'))) {
                    $this->security->setUser($user);
                    // $returnUrl = $this->session->returnUrl;
                    // unset($this->session->returnUrl);

					return $this->redirect(
                        $this->generateRoute('home')
                        // $returnUrl ?? $this->generateRoute('home')
                    );
                }
            }

            array_push($errors, 'Invalid username or password');
        }

        return $this->render('login.html', ['errors' => $errors]);
    }

    public function logoutAction(): ResponseInterface
    {
        $this->security->clear();

        return $this->redirect($this->generateRoute('home'));
    }

    public function signinAction(): ResponseInterface
    {
        if ($this->security->isAuthenticated()) {
            return new ResponseRedirect($this->generateRoute('home'));
        }
        $errors = [];

        if ($this->getRequest()->isPost()) {
            try {
                $user           = new User($this->connection);
                $user->email    = $this->getRequest()->post('email');
                $user->password = md5($this->getRequest()->post('password'));
                $user->role     = 'ROLE_USER';
                $user->save();
                return $this->redirect($this->generateRoute('home'));
            } catch (DatabaseException $e) {
                $errors = [$e->getMessage()];
            }
        }

        return $this->render('signin.html', ['errors' => $errors]);
    }
}
