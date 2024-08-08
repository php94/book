<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Page;

use App\Php94\Admin\Http\Common;
use PHP94\Db;
use PHP94\Request;
use PHP94\Response;

class Delete extends Common
{
    public function get()
    {
        if (Db::get('php94_book_page', '*', [
            'pid' => Request::get('id'),
        ])) {
            return Response::error('请先删除下级内容');
        }
        Db::delete('php94_book_page', [
            'id' => Request::get('id'),
        ]);
        return Response::success('操作成功！');
    }
}
