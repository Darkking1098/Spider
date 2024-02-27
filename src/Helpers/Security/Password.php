<?php

namespace App\Helpers\Security;

class Password
{
    private const SALT = "@ki";

    static function generate($password)
    {
        return password_hash($password, null, ["salt" => self::SALT]);
    }
    static function validate($password, $hash)
    {
        return self::generate($password) == $hash;
    }
}
