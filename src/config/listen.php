<?php

use App\Php94\Book\Http\Home\Auth;
use App\Php94\Book\Http\Home\Book;
use App\Php94\Book\Http\Home\Common;
use App\Php94\Book\Http\Home\Page;
use App\Php94\Book\Http\Home\Search;
use App\Php94\Book\Middleware\AuthMiddleware;
use PHP94\Handler\Handler;
use PHP94\Help\Request;
use PHP94\Router\Router;

return [
    Router::class => function (
        Router $router
    ) {
        $router->addGroup('/book', function (Router $router) {
            $router->addRoute('/{book}/_auth', Auth::class, '/php94/book/home/auth');
            $router->addRoute('/{book}/_search', Search::class, '/php94/book/home/search');
            $router->addRoute('/{book}/{id:\d+}', Page::class, '/php94/book/home/page');
            $router->addRoute('/{book}', Book::class, '/php94/book/home/book');
        });
    },
    Handler::class => function (
        Handler $handler
    ) {
        if (is_a(Request::attr('handler'), Common::class, true)) {
            $handler->pushMiddleware(AuthMiddleware::class);
        }
    },
];
