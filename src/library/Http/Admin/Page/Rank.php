<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Page;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Rank extends Common
{
    public function get()
    {
        $type = Request::get('type');
        $page = Db::get('php94_book_page', '*', [
            'id' => Request::get('id'),
        ]);

        $pages = Db::select('php94_book_page', '*', [
            'book_id' => $page['book_id'],
            'pid' => $page['pid'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);

        $count = Db::count('php94_book_page', [
            'id[!]' => $page['id'],
            'book_id' => $page['book_id'],
            'pid' => $page['pid'],
            'rank[<=]' => $page['rank'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        $change_key = $type == 'up' ? $count + 1 : $count - 1;

        if ($change_key < 0) {
            return Response::success('操作成功！');
        }
        if ($change_key > count($pages) - 1) {
            return Response::success('操作成功！');
        }

        $pages = array_reverse($pages);
        foreach ($pages as $key => $value) {
            if ($key == $change_key) {
                Db::update('php94_book_page', [
                    'rank' => $count,
                ], [
                    'id' => $value['id'],
                ]);
            } elseif ($key == $count) {
                Db::update('php94_book_page', [
                    'rank' => $change_key,
                ], [
                    'id' => $value['id'],
                ]);
            } else {
                Db::update('php94_book_page', [
                    'rank' => $key,
                ], [
                    'id' => $value['id'],
                ]);
            }
        }
        return Response::success('操作成功！');
    }
}
