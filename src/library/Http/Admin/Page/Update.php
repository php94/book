<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Page;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Router;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\SelectLevel;
use PHP94\Help\Request;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Form\Field\SimpleMDE;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Form\Help\Summary;
use PHP94\Form\Layout\Col;
use PHP94\Form\Layout\Row;
use PHP94\Help\Response;

class Update extends Common
{
    public function get()
    {
        $page = Db::get('php94_book_page', '*', [
            'id' => Request::get('id'),
        ]);

        $pages = Db::select('php94_book_page', '*', [
            'book_id' => $page['book_id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ]
        ]);

        $xfield = new SelectLevel('上级页面', 'pid', $page['pid']);
        foreach ($pages as $vo) {
            $xfield->addItem($vo['title'], $vo['id'], $vo['pid'] ?: '');
        }

        $form = new Form('更新页面');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('id', $page['id'])),
                    $xfield,
                    (new Text('标题', 'title', $page['title'])),
                    (new SimpleMDE('内容', 'body', $page['body']))
                        ->setUploadUrl(Router::build('/php94/admin/tool/upload')),
                    (new Radios('是否发布', 'published', $page['published']))->addRadio(
                        new Radio('否', 0),
                        new Radio('是', 1),
                    ),
                    (new Summary('SEO'))->addItem(
                        (new Text('关键词', 'keywords')),
                        (new Text('简介', 'description')),
                    ),
                )
            )
        );
        return $form;
    }

    public function post()
    {
        if (!$page = Db::get('php94_book_page', '*', [
            'id' => Request::post('id'),
        ])) {
            return Response::error('文档不存在');
        }

        if (Request::post('pid') == $page['id']) {
            return Response::error('上级页面不能是自己');
        }

        Db::update('php94_book_page', [
            'pid' => Request::post('pid'),
            'title' => Request::post('title'),
            'keywords' => Request::post('keywords'),
            'description' => Request::post('description'),
            'body' => Request::post('body'),
            'published' => Request::post('published'),
        ], [
            'id' => $page['id'],
        ]);

        return Response::success('操作成功！');
    }
}
