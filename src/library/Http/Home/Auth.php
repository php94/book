<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Home;

use PHP94\Facade\Db;
use PHP94\Facade\Router;
use PHP94\Facade\Session;
use PHP94\Facade\Template;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Auth extends Common
{
    public function get()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', ''),
        ])) {
            return Response::error('文档不存在');
        };
        return Template::render('home/' . ($book['theme'] ?: 'default') . '/auth@php94/book', [
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

    public function post()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', ''),
        ])) {
            return Response::error('文档不存在');
        };

        if (Request::post('password', '') == $book['password']) {
            Session::set('auth_book_' . $book['name'], 1);
            return Response::success('授权成功', Router::build('/php94/book/home/book', [
                'book' => $book['name'],
            ]));
        } else {
            return Response::error('密码错误');
        }
    }
}
