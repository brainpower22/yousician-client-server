<?php

namespace App\Support;

use App\Models\User;

class Auth
{
    public static function attempt($email, $password)
    {
        $password_exists_with_email = function ($attribute, $value, $fail) use ($email, $password) {

            $exists = User::where(compact('email', 'password'))->exists();

            if (!$exists) {
                $attribute = ucfirst($attribute);
                $fail("{$attribute} Is Invalid, doesn't line up with provided email");
            }
        };

        $validator = session()->validator(compact('email', 'password'), [
            'email' => 'required|exists:users,email',
            'password' => ['required', 'exists:users,password', $password_exists_with_email],
        ],
            [
                'email.exists' => 'Email not found',
                'password.exists' => 'Password not found'
            ]);

        if ($validator->fails()) abort(403);

        $user = User::where('email', $email)->first();

        $_id = $user->_id;
        $email = $user->email;
        $password = $user->password;

        session()->set('user', compact('_id', 'email', 'password'));
        session()->set('last_used_instrument', $user->last_used_instrument);

        return true;
    }

    public static function logout()
    {
        $_id = null;
        $email = null;
        $password = null;

        session()->set('user', compact('_id', 'email', 'password'));
        session()->set('last_used_instrument', null);
    }

    public static function user()
    {
        if (!session()->has('user')) return false;

        $query = User::where(session()->get('user'));

        app()->bind(
            Auth::class,
            $query->exists() ? $query->first() : false
        );

        return app()->resolve(Auth::class);
    }

    public static function check(): bool
    {
        return (bool)self::user();
    }

    public static function guest(): bool
    {
        return (bool)self::user() === false;
    }
}
