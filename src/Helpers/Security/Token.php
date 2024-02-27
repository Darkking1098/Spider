<?php

namespace App\Helpers\Security;

abstract class Token
{
    protected $expiry = true;
    protected $refresh = false;
    // MilliSeconds * Seconds * Minutes * Hours * Days
    const TIMEOUT = 1000 * 60 * 60;
    const REFRESH = 1000 * 60 * 70;

    protected function generate_payload($payload, $encode = true)
    {
        $time = time() * 1000;
        $payload += ["issue" => $time] + ($this->expiry ? ['expiry' => $time + self::TIMEOUT] : []) + ($this->refresh ? ['refresh' => $time + self::REFRESH] : []);
        if (!$encode) return $payload;
        return json_encode($payload);
    }
    abstract function validate($token);
    abstract function generate($data);
}
