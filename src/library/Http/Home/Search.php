<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Home;

use PHP94\Facade\Db;
use PHP94\Facade\Template;
use PHP94\Help\Request;
use PHP94\Help\Response;
use Parsedown;

class Search extends Common
{
    public function get()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', ''),
        ])) {
            return Response::error('文档不存在');
        };

        $q = trim(Request::get('q', ''));
        if (strlen($q)) {
            $searchs = Db::select('php94_book_page', '*', [
                'book_id' => $book['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ]
            ]);
            if ($book['editor'] == 'simplemde') {
                foreach ($searchs as &$value) {
                    $value['body'] = (new Parsedown())->text($value['body']);
                }
                unset($value);
            }
            foreach ($searchs as $k => $vo) {
                if ((false === stripos($vo['title'], $q)) && (false === stripos(strip_tags($vo['body']), $q))) {
                    unset($searchs[$k]);
                }
            }
        } else {
            $searchs = [];
        }

        return Template::render('home/' . ($book['theme'] ?: 'default') . '/search@php94/book', [
            'seo' => [
                'title' => '搜索：' . $q . ' - ' . $book['title'],
                'keywords' => $q,
                'description' => $q,
            ],
            'book' => $book,
            'pages' => Db::select('php94_book_page', '*', [
                'book_id' => $book['id'],
                'ORDER' => [
                    'rank' => 'DESC',
                    'id' => 'ASC',
                ]
            ]),
            'searchs' => $searchs,
        ]);
    }
}
