<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Page;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Template;
use PHP94\Request;

class Index extends Common
{
    public function get()
    {
        $book_id = Request::get('book_id');

        $book = Db::get('php94_book_book', '*', [
            'id' => $book_id,
        ]);

        $pages = Db::select('php94_book_page', '*', [
            'book_id' => $book_id,
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);

        return Template::render('/admin/page/index@php94/book', [
            'book' => $book,
            'pages' => $pages,
        ]);
    }
}
