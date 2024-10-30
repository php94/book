<?php

use App\Php94\Admin\Model\Menu;
use App\Php94\Book\Http\Home\Common;
use App\Php94\Book\Middleware\AuthMiddleware;
use PHP94\Handler;
use PHP94\Request;
use App\Php94\Book\Http\Admin\Book\Index;

return [
    Menu::class => function (
        Menu $menu
    ) {
        $menu->addMenu('文档管理', Index::class);
    },
    Handler::class => function (
        Handler $handler
    ) {
        if (is_a(Request::attr('handler'), Common::class, true)) {
            $handler->pushMiddleware(AuthMiddleware::class);
        }
    },
];
