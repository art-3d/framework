<?php

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\Response\JsonResponse;
use Framework\Response\ResponseInterface;

class TestController extends Controller
{
    public function redirectAction(): ResponseInterface
    {
        return $this->redirect('/');
    }

    public function getJsonAction(): ResponseInterface
    {
        return new JsonResponse(json_encode(['body' => 'Hello World']));
    }
}
