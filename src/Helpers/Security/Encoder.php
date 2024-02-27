<?php

namespace App\Helpers\Security;

abstract class Encoder
{
    protected const KEY = "KUM@R:1S:R0CK1N6";

    static abstract function encode($data, $algo);
    static abstract function decode($data, $algo);
}
