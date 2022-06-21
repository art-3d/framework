<?php

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord
{
    public string $title;
    public string $content;
    public \DateTimeImmutable $date;
    public string $author;

    public static function getTable(): string
    {
        return 'posts';
    }

    public function getRules()
    {
        return [
            'title'   => [
                new NotBlank(),
                new Length(4, 100),
            ],
            'content' => [new NotBlank()],
        ];
    }
}