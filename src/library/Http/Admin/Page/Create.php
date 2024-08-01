<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Page;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Router;
use PHP94\Form\Field\Hidden;
use PHP94\Form\Field\SelectLevel;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Form\Field\Summernote;
use PHP94\Form\Field\Text;
use PHP94\Form\Form;
use PHP94\Form\Help\Summary;
use PHP94\Form\Layout\Col;
use PHP94\Form\Layout\Row;
use PHP94\Help\Request;
use PHP94\Help\Response;

class Create extends Common
{
    public function get()
    {
        $book = Db::get('php94_book_book', '*', [
            'id' => Request::get('book_id'),
        ]);

        $pages = Db::select('php94_book_page', '*', [
            'book_id' => $book['id'],
            'ORDER' => [
                'rank' => 'DESC',
                'id' => 'ASC',
            ]
        ]);

        $xfield = new SelectLevel('上级页面', 'pid');
        foreach ($pages as $vo) {
            $xfield->addItem($vo['title'], $vo['id'], $vo['pid'] ?: '');
        }

        if ($book['editor'] == 'summernote') {
            $editor = (new Summernote('内容', 'body'))
                ->setUploadUrl(Router::build('/php94/admin/tool/upload'));
        } else {
            $editor = (new Summernote('内容', 'body'))
                ->setUploadUrl(Router::build('/php94/admin/tool/upload'));
        }

        $form = new Form('添加页面');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('book_id', $book['id'])),
                    $xfield,
                    (new Text('标题', 'title')),
                    $editor,
                    (new Summernote('内容', 'body'))
                        ->setUploadUrl(Router::build('/php94/admin/tool/upload')),
                    (new Radios('是否发布', 'published', 1))->addRadio(
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
        Db::insert('php94_book_page', [
            'book_id' => Request::post('book_id'),
            'pid' => Request::post('pid'),
            'title' => Request::post('title'),
            'keywords' => Request::post('keywords'),
            'description' => Request::post('description'),
            'body' => Request::post('body'),
            'published' => Request::post('published'),
        ]);
        return Response::success('操作成功！');
    }
}
