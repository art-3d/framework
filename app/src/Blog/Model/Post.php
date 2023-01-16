<?php

declare(strict_types=1);

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord
{
    public string $title;
    public string $content;
    public string $date;
    public string $author;
    public string $name;

    public function getTable(): string
    {
        return 'posts';
    }

    public function getRules()
    {
        return [
            'title' => [
                new NotBlank(),
                new Length(4, 100),
            ],
            'content' => [new NotBlank()],
        ];
    }
}
