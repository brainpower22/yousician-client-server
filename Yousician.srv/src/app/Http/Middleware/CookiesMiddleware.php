<?php

namespace App\Http\Middleware;

use App\Controllers\UserController;
use App\Support\Cookies;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;

class CookiesMiddleware
{

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Handler $handler): \Psr\Http\Message\ResponseInterface
    {
        $cookies = (new Cookies())
            ->set('AWSALB', [
                'value' => '3ahxno5YyPbp8Pa+IdjxqJcFso/PlrG5Iuyz3Ou+oEGF+QbQkWabx0HMWbts8oVGninEQiYojLyEkB0vac5GAT6LR0wXsZSRG823YvJIkibiNeG40GuZGaj8Iqmh',
                'domain' => 'localhost',
                'expires' => 'Sun, 20 Sep 2043 15:08:25 GMT',
                'path' => '/',
            ])
            ->set('AWSALBCORS', [
                'value' => '3ahxno5YyPbp8Pa+IdjxqJcFso/PlrG5Iuyz3Ou+oEGF+QbQkWabx0HMWbts8oVGninEQiYojLyEkB0vac5GAT6LR0wXsZSRG823YvJIkibiNeG40GuZGaj8Iqmh',
                'domain' => 'localhost',
                'expires' => 'Sun, 20 Sep 2043 15:08:25 GMT',
                'path' => '/',
            ]);
        if (session()->has('user')) {
            $valueArray = [
                '_permanent' => true,
                'currentInstrument' => 'guitar',
                'session_id' => session()->getId(),
            ];
            $cookies->set('session', [
                'value' => base64_encode(json_encode($valueArray)),
                'domain' => 'localhost',
                'expires' => 'Sun, 20 Sep 2043 15:08:25 GMT',
                'path' => '/',
                'encode' => false,
            ]);
        } else {
            $cookies->set('session', [
                'value' => '',
                'domain' => 'localhost',
                'expires' => 'Sun, 20 Sep 2043 15:08:25 GMT',
                'path' => '/',
                'encode' => false,
            ]);
        }
        return $handler
            ->handle($request)
            ->withHeader('access-control-allow-methods', 'GET, POST, PUT, DELETE, OPTIONS, HEAD')
            ->withHeader('access-control-allow-headers', 'X-Application-Name,X-Requested-With, Origin, Accept, Content-Type, Authorization, Compression, Remember, Cache-Control')
            ->withHeader('access-control-allow-credentials', 'true')
            ->withHeader('access-control-expose-headers', 'ETag')
            ->withHeader('vary', 'Origin,Cookie,Accept-Encoding')
            ->withHeader('set-cookie', $cookies->toHeaders());
//            ->withHeader('content-encoding', 'gzip');
    }
}