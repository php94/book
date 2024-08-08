<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Book;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Response;

class Delete extends Common
{
    public function get()
    {
        Db::delete('php94_book_book', [
            'id' => Request::get('id'),
        ]);
        Db::delete('php94_book_page', [
            'book_id' => Request::get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
