<?php

declare(strict_types=1);

namespace App\Php94\Book\Http\Home;

use PHP94\Factory;
use PHP94\Framework;
use PHP94\Request;
use PHP94\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class File implements RequestHandlerInterface
{
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        $method = strtolower($request->getMethod());
        if (in_array($method, ['get', 'put', 'post', 'delete', 'head', 'patch', 'options']) && is_callable([$this, $method])) {
            $resp = Framework::execute([$this, $method]);
            if (is_scalar($resp) || (is_object($resp) && method_exists($resp, '__toString'))) {
                return Response::html((string)$resp);
            }
            return $resp;
        } else {
            return Response::error('不支持该请求');
        }
    }

    public function get(): ResponseInterface
    {
        switch (Request::get('file')) {
            case 'jquery':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/jquery/jquery.min.js'));
                return $response;
                break;
            case 'bsjs':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/bootstrap/js/bootstrap.bundle.min.js'));
                return $response;
                break;
            case 'bscss':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'text/css')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/bootstrap/css/bootstrap.min.css'));
                return $response;
                break;
            case 'markjs':
                $response = Factory::createResponse(200)
                    ->withHeader('Content-Type', 'application/javascript')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Cache-Control', 'max-age=3600')
                    ->withHeader('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
                $response->getBody()->write(file_get_contents(__DIR__ . '/../../../static/mark/jquery.mark.min.js'));
                return $response;
                break;

            default:
                return Factory::createResponse(404);
                break;
        }
    }
}
