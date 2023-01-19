<?php

declare(strict_types=1);

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\Response\JsonResponse;
use Framework\Response\ResponseInterface;

class TestController extends Controller
{
    public function redirectAction(): ResponseInterface
    {
        return $this->redirect('/', 'You were redirected to home page');
    }

    public function getJsonAction(): ResponseInterface
    {
        return new JsonResponse(['body' => 'Hello World']);
    }
}
