<?php

namespace Boot\Foundation\Bootstrappers;

use App\Support\RequestInput;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

class LoadDebuggingPage extends Bootstrapper
{
    public function boot()
    {
        $whoops = function ($exception, $inspector, $run) {

            $message = $exception->getMessage();
            if (config('app.app_debug')) {
                $title = $inspector->getExceptionName();
                $stack = $exception->getTrace();

                if (false) {
                    $request = $exception->getRequest();
                    $route = RouteContext::fromRequest($request)->getRoute();
                    $requestInput = new RequestInput($request, $route);
                    $input = $requestInput->all();
                }
                $input = json_encode($exception);
                $with = compact('exception', 'inspector', 'run', 'title', 'message', 'input', 'stack');

                $time = Carbon::now()->format('Y-m-d');
                $path = storage_path("error_logs/ysls-{$time}.log");
                $notFound = storage_path("error_logs/ysls-404.log");

                $filesystem = app()->resolve(Filesystem::class);

                $filesystem->put($path, json_encode($with));
                if ($exception->getCode() == 404) {
                    $filesystem->append($notFound, $exception->getRequest()->getUri()->getPath() . "\r\n");
                }
            }
            if (empty($message)) {
                $with = [
                    'message' => 'Could not verify your access level for that URL. You have to login with proper credentials'
                ];
            }
            header('content-type: application/json');
            echo json_encode($with);
            exit;

        };
        $this->app->bind('whoops', new WhoopsMiddleware([], [$whoops]));

        if (env('APP_DEBUG', false)) {
            $this->app->add(app()->resolve('whoops'));
        }
    }
}
