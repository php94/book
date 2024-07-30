<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Home;

use PHP94\Facade\Db;
use PHP94\Facade\Template;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Page extends Common
{
    public function get()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', ''),
        ])) {
            return Response::error('文档不存在');
        };
        if (!$page = Db::get('php94_book_page', '*', [
            'id' => Request::get('id', ''),
        ])) {
            return Response::error('页面不存在');
        };
        if ($page['book_id'] != $book['id']) {
            return Response::error('页面不存在');
        }
        return Template::render('home/' . ($book['theme'] ?: 'default') . '/page@php94/book', [
            'seo' => [
                'title' => $page['title'] . ' - ' . $book['title'],
                'keywords' => $page['keywords'],
                'description' => $page['description'],
            ],
            'book' => $book,
            'pages' => Db::select('php94_book_page', '*', [
                'book_id' => $book['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ]
            ]),
            'page' => $page,
        ]);
    }
}
