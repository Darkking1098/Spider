<?php

namespace App\Helpers\Security\Token;

use App\Helpers\Security\Token;
use App\Models\AuthToken;
use Illuminate\Support\Str;

class Vector extends Token
{
    private const TOKEN_LENGTH = 32;
    public $expiry, $refresh;

    public function __construct($expiry = true, $refresh = false)
    {
        $this->expiry = $expiry;
        $this->refresh = $refresh;
    }

    function generate($data)
    {
        $token = new AuthToken([
            "token" => Str::random(self::TOKEN_LENGTH) . time(),
            "data" => $data,
        ] + self::generate_payload([], false));
        if ($token->save()) return $token->token;
        return ["success" => false, "message" => "Database connection failed"];
    }

    function validate($token)
    {
        $tkn = AuthToken::where('token', $token)->first();
        if (!$tkn) return ["success" => false, 'msg' => "Token is invalid","refresh"=>false];
        $token = $tkn->toArray();
        if ($token['expiry'] < time() * 1000) {
            if ($token['refresh'] < time() * 1000) {
                $tkn->delete();
                return ["success" => false, 'msg' => "Token has been expired. Kindly login again.", "expired" => true, "refresh" => false, 'data' => $token['data']];
            } else {
                return ["success" => false, 'msg' => "Token has expired. Kindly refresh token", "expired" => true, "refresh" => true, 'data' => $token['data']];
            }
        }
        return ['success' => true, 'data' => $token['data'], 'refresh' => $tkn['refresh'] ? true : false];
    }
    function refresh($token)
    {
        $result = self::validate($token);
        if ($result['refresh']) {
            AuthToken::where('token', $token)->first()->delete();
            return self::generate($result['data']);
        } else if ($result['success']) {
            return ["success" => false, 'msg' => "Token can not be refreshed"];
        }
        return ["success" => false, 'msg' => "Token has expired. Kindly login token", "expired" => true, "refresh" => false, 'data' => $result['data']??[]];
    }
}
