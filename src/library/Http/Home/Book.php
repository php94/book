<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Home;

use PHP94\Db;
use PHP94\Template;
use PHP94\Request;
use PHP94\Response;

class Book extends Common
{
    public function get()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', ''),
        ])) {
            return Response::error('文档不存在');
        };
        return Template::render('home/' . ($book['theme'] ?: 'default') . '/book@php94/book', [
            'seo' => [
                'title' => $book['title'],
                'keywords' => $book['keywords'],
                'description' => $book['description'],
            ],
            'book' => $book,
            'pages' => Db::select('php94_book_page', '*', [
                'book_id' => $book['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ]
            ]),
        ]);
    }
}
