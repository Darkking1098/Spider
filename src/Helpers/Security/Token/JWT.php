<?php

namespace App\Helpers\Security\Token;

use App\Helpers\Security\Encoder\BASE64;
use App\Helpers\Security\Encoder\HMAC;
use App\Helpers\Security\Token;

class JWT extends Token
{
    public $algo, $expiry, $refresh;

    public function __construct($algo = null, $expiry = true, $refresh = false)
    {
        $this->algo = $algo;
        $this->expiry = $expiry;
        $this->refresh = $refresh;
    }
    private function encode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], BASE64::encode($data));
    }
    private function decode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], BASE64::encode($data));
    }
    private function header()
    {
        return self::encode(json_encode(['type' => 'JWT', 'algo' => "HS256"]));
    }
    function generate($payload)
    {
        $data = self::header() . '.' . self::encode(self::generate_payload($payload));
        $signature = HMAC::encode($data);
        return $data . '.' . $signature;
    }
    function validate($token)
    {
        if (!$token) return ["success" => false, 'msg' => "Token is invalid"];
        list($header, $payload, $signature) = explode('.', $token);

        $expectedSignature = HMAC::encode($header . "." . $payload);

        if ($expectedSignature !== $signature) {
            return ["success" => false, 'msg' => "Token is invalid"];
        }

        $dec = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);

        if (isset($dec['expiry']) && $dec['expiry'] < time() * 1000) {
            if (isset($dec['refresh']) && $dec['refresh'] < time() * 1000) {
                return ["success" => false, 'msg' => "Token has been expired. Kindly login again.", "expired" => true, "refresh" => false, 'data' => $dec];
            } elseif (!isset($dec['refresh'])) {
                return ["success" => false, 'msg' => "Token has expired. Kindly refresh token.", "expired" => true, "refresh" => true, 'data' => $dec];
            }
        }

        return ['success' => true, 'data' => $dec];
    }
    function refresh($token)
    {
        $result = self::validate($token);
        if (isset($result['refresh']) && $result['refresh']) {
            return self::generate($result['data']);
        } else if ($result['success']) {
            return ["success" => false, 'msg' => "Token can not be refreshed"];
        }
        return ["success" => false, 'msg' => "Token has expired. Kindly login token", "expired" => true, "refresh" => false, 'data' => $token['data']];
    }
}
