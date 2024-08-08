<?php

declare(strict_types=1);

namespace App\Php94\Book\Middleware;

use App\Php94\Book\Http\Home\Auth;
use PHP94\Db;
use PHP94\Router;
use PHP94\Session;
use PHP94\Template;
use PHP94\Request;
use PHP94\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$book = Db::get('php94_book_book', '*', [
            'name' => Request::get('book', '')
        ])) {
            return Response::error('文档不存在');
        }
        if (!$this->checkIp($_SERVER['REMOTE_ADDR'], $book['ip'])) {
            return Response::error('您的IP被限制访问');
        }
        if ($book['password'] && !Session::has('auth_book_' . Request::get('book'))) {
            if (!is_a(Request::attr('handler'), Auth::class, true)) {
                return Response::redirect(Router::build('/php94/book/home/auth', ['book' => $book['name']]));
                return Response::html(Template::render('home/' . ($book['theme'] ?: 'default') . '/password@php94/book', [
                    'book' => $book,
                ]));
            }
        }
        return $handler->handle($request);
    }

    private function checkIp($ip, $limit_ips): bool
    {
        if (!is_string($limit_ips) || !strlen($limit_ips)) {
            return true;
        }
        foreach (explode(' ', $limit_ips) as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }
        return false;
    }

    private function ipInRange(string $ip, string $range): bool
    {
        if (strpos($range, '/') === false) {
            $range .= '/32';
        }
        $ip = ip2long($ip);
        list($network, $netmask) = explode('/', $range);
        $network = ip2long($network);
        $netmask = ~((1 << (32 - $netmask)) - 1);
        $network &= $netmask;
        $netmask &= -1;

        return ($ip & $netmask) == $network;
    }
}
