<?php

declare(strict_types=1);

namespace Blog\Controller;

use Blog\Model\User;
use Framework\Controller\Controller;
use Framework\Exception\DatabaseException;
use Framework\Response\ResponseInterface;
use Framework\Response\ResponseRedirect;

class SecurityController extends Controller
{
    private string $salt = '5f4dcc3b5aa765d61d8327deb882cf99';

    public function loginAction(): ResponseInterface
    {
        if ($this->security->isAuthenticated()) {
            return new ResponseRedirect($this->generateRoute('home'));
        }
        $errors = [];

        if ($this->getRequest()->isPost()) {
            if ($user = (new User($this->connection))->findByEmail($this->getRequest()->post('email'))) {
                if ($user->password === md5($this->getRequest()->post('password') . '.' . $this->salt)) {
                    $this->security->setUser($user);
                    $returnUrl = $this->session->returnUrl;
                    unset($this->session->returnUrl);

                    return $this->redirect(
                        $returnUrl ?? $this->generateRoute('home')
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

    public function registerAction(): ResponseInterface
    {
        if ($this->security->isAuthenticated()) {
            return new ResponseRedirect($this->generateRoute('home'));
        }
        $errors = [];

        if ($this->getRequest()->isPost()) {
            try {
                $user = new User($this->connection);
                $user->email = $this->getRequest()->post('email');
                $user->password = md5($this->getRequest()->post('password') . '.' . $this->salt);
                $user->role = 'ROLE_USER';
                $user->save();

                $this->session->writeInfo('You are succesfully registered. Now you can login.');

                return $this->redirect($this->generateRoute('home'));
            } catch (DatabaseException $e) {
                $errors = [$e->getMessage()];
            }
        }

        return $this->render('register.html', ['errors' => $errors]);
    }
}
