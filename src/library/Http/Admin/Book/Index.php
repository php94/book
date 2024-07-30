<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Book;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Template;

class Index extends Common
{
    public function get()
    {
        return Template::render('/admin/book/index@php94/book', [
            'books' => Db::select('php94_book_book', '*'),
        ]);
    }
}
