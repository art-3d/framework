<?php

namespace Blog\Controller;

use Blog\Model\Post;
use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\DatabaseException;
use Framework\Exception\HttpNotFoundException;
use Framework\Response\Response;
use Framework\Response\ResponseInterface;
use Framework\Validation\Validator;

class PostController extends Controller
{
    public function indexAction(): ResponseInterface
    {
        return $this->render('index.html', array('posts' => Post::find('all')));
    }

    public function getPostAction($id): ResponseInterface
    {
        return new Response('Post: #' . $id);
    }

    public function addAction(): ResponseInterface
    {
        if ($this->getRequest()->isPost()) {
            try {
                $post          = new Post();
                $date          = new \DateTime();
                $post->title   = $this->getRequest()->post('title');
                $post->content = trim($this->getRequest()->post('content'));
                $post->date    = $date->format('Y-m-d H:i:s');
				$post->name    = Service::get('session')->get('user')->email;

                $validator = new Validator($post);
                if ($validator->isValid()) {
                    $post->save();
                    return $this->redirect($this->generateRoute('home'), 'The data has been saved successfully');
                } else {
                    $error = $validator->getErrors();
                }
            } catch (DatabaseException $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render(
            'add.html',
            ['action' => $this->generateRoute('add_post'), 'errors' => isset($error) ? $error : null]
        );
    }

    public function showAction($id): ResponseInterface
    {
        if (!$post = Post::find((int)$id)) {
            throw new HttpNotFoundException('Page Not Found!');
        }

        return $this->render('show.html', ['post' => $post]);
    }
}