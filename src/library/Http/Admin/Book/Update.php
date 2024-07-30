<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Admin\Book;

use App\Php94\Admin\Http\Common;
use PHP94\Facade\Db;
use PHP94\Facade\Router;
use PHP94\Help\Request;
use PHP94\Form\Field\Picture;
use PHP94\Form\Field\Radio;
use PHP94\Form\Field\Radios;
use PHP94\Form\Field\SimpleMDE;
use PHP94\Form\Field\Text;
use PHP94\Form\Field\Textarea;
use PHP94\Form\Form;
use PHP94\Form\Help\Summary;
use PHP94\Form\Layout\Col;
use PHP94\Form\Layout\Row;
use PHP94\Help\Response;

class Update extends Common
{
    public function get()
    {
        $page = Db::get('php94_book_book', '*', [
            'id' => Request::get('id'),
        ]);
        $form = new Form('创建文档');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Text('标题', 'title', $page['title'])),
                    (new Summary('SEO'))->addItem(
                        (new Text('关键词', 'keywords')),
                        (new Text('简介', 'description')),
                    ),
                    (new Text('名称', 'name', $page['name'])),
                    (new SimpleMDE('介绍', 'body', $page['body'])),
                    (new Picture('封面', 'cover', $page['cover']))
                        ->setUploadUrl(Router::build('/php94/admin/tool/upload')),
                    (new Picture('水印', 'water', $page['water']))
                        ->setUploadUrl(Router::build('/php94/admin/tool/upload')),
                    (new Text('主题', 'theme', $page['theme'])),
                    (new Text('访问密码', 'password', $page['password'])),
                    (new Textarea('IP限制', 'ip', $page['ip'])),
                    (new Radios('是否允许复制', 'copy', $page['copy']))->addRadio(
                        new Radio('否', 0),
                        new Radio('是', 1),
                    ),
                    (new Radios('是否发布', 'published', $page['published']))->addRadio(
                        new Radio('否', 0),
                        new Radio('是', 1),
                    ),
                )
            )
        );
        return $form;
    }

    public function post()
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'id' => Request::post('id'),
        ])) {
            return Response::error('文档不存在');
        }

        Db::update('php94_book_book', [
            'title' => Request::post('title'),
            'keywords' => Request::post('keywords'),
            'description' => Request::post('description'),
            'name' => Request::post('name'),
            'body' => Request::post('body'),
            'cover' => Request::post('cover'),
            'water' => Request::post('water'),
            'theme' => Request::post('theme', 'default'),
            'password' => Request::post('password'),
            'ip' => Request::post('ip'),
            'copy' => Request::post('copy'),
            'published' => Request::post('published'),
        ], [
            'id' => $book['id'],
        ]);

        return Response::success('操作成功！');
    }
}
