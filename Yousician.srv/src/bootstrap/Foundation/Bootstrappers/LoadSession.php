<?php

namespace Boot\Foundation\Bootstrappers;

use Boot\Foundation\Http\Session;

class LoadSession extends Bootstrapper
{
    public function boot()
    {
        ini_set('session.save_path', realpath(base_path('../sessions')));
        ini_set('session.gc_probability', 1);

        $session = new Session();

        if(isset($_COOKIE['session'])){
            $sessionArray = json_decode(base64_decode($_COOKIE['session']), true);
            if(!empty($sessionArray)) {
                $session->setId($sessionArray['session_id']);
            }
        }

        $session->start();

        $this->app->bind(Session::class, $session);
    }
}
