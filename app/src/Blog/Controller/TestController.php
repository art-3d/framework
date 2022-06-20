<?php

namespace Blog\Controller;

use Framework\Controller\Controller;
use Framework\Response\JsonResponse;

class TestController extends Controller
{
    public function redirectAction()
    {
        return $this->redirect('/');
    }

    public function getJsonAction()
    {
        return new JsonResponse(json_encode(['body' => 'Hello World']));
    }
} 