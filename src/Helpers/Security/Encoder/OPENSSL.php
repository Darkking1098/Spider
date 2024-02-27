<?php

namespace App\Helpers\Security\Encoder;

use App\Helpers\Security\Encoder;

class OPENSSL extends Encoder
{
    private const IV = "VECTOR####VECTOR";
    private const ALGOS = [
        "aes-128-cbc",
        "aes-128-cbc-hmac-sha1",
        "aes-128-cbc-hmac-sha256",
        "aes-128-ccm",
        "aes-128-cfb",
        "aes-128-cfb1",
        "aes-128-cfb8",
        "aes-128-ctr",
        "aes-128-gcm",
        "aes-128-ocb",
        "aes-128-ofb",
        "aes-128-xts",
        "aes-192-cbc",
        "aes-192-ccm",
        "aes-192-cfb",
        "aes-192-cfb1",
        "aes-192-cfb8",
        "aes-192-ctr",
        "aes-192-gcm",
        "aes-192-ocb",
        "aes-192-ofb",
        "aes-256-cbc",
        "aes-256-cbc-hmac-sha1",
        "aes-256-cbc-hmac-sha256",
        "aes-256-ccm",
        "aes-256-cfb",
        "aes-256-cfb1",
        "aes-256-cfb8",
        "aes-256-ctr",
        "aes-256-gcm",
        "aes-256-ocb",
        "aes-256-ofb",
        "aes-256-xts",
        "aria-128-cbc",
        "aria-128-ccm",
        "aria-128-cfb",
        "aria-128-cfb1",
        "aria-128-cfb8",
        "aria-128-ctr",
        "aria-128-gcm",
        "aria-128-ofb",
        "aria-192-cbc",
        "aria-192-ccm",
        "aria-192-cfb",
        "aria-192-cfb1",
        "aria-192-cfb8",
        "aria-192-ctr",
        "aria-192-gcm",
        "aria-192-ofb",
        "aria-256-cbc",
        "aria-256-ccm",
        "aria-256-cfb",
        "aria-256-cfb1",
        "aria-256-cfb8",
        "aria-256-ctr",
        "aria-256-gcm",
        "aria-256-ofb",
        "bf-cbc",
        "bf-cfb",
        "bf-ofb",
        "camellia-128-cbc",
        "camellia-128-cfb",
        "camellia-128-cfb1",
        "camellia-128-cfb8",
        "camellia-128-ctr",
        "camellia-128-ofb",
        "camellia-192-cbc",
        "camellia-192-cfb",
        "camellia-192-cfb1",
        "camellia-192-cfb8",
        "camellia-192-ctr",
        "camellia-192-ofb",
        "camellia-256-cbc",
        "camellia-256-cfb",
        "camellia-256-cfb1",
        "camellia-256-cfb8",
        "camellia-256-ctr",
        "camellia-256-ofb",
        "cast5-cbc",
        "cast5-cfb",
        "cast5-ofb",
        "chacha20",
        "chacha20-poly1305",
        "id-aes128-CCM",
        "id-aes128-GCM",
        "id-aes128-wrap",
        "id-aes128-wrap-pad",
        "id-aes192-CCM",
        "id-aes192-GCM",
        "id-aes192-wrap",
        "id-aes192-wrap-pad",
        "id-aes256-CCM",
        "id-aes256-GCM",
        "id-aes256-wrap",
        "id-aes256-wrap-pad",
        "idea-cbc",
        "idea-cfb",
        "idea-ofb",
        "seed-cbc",
        "seed-cfb",
        "seed-ofb",
        "sm4-cbc",
        "sm4-cfb",
        "sm4-ctr",
        "sm4-ofb",
    ];
    /** 
     * 0 => aes-128-cbc
     * 1 => aes-128-cbc-hmac-sha1
     * 2 => aes-128-cbc-hmac-sha256
     * 3 => aes-128-ccm
     * 4 => aes-128-cfb
     * 5 => aes-128-cfb1
     * 6 => aes-128-cfb8
     * 7 => aes-128-ctr
     * 9 => aes-128-gcm
     * 10 => aes-128-ocb
     * 11 => aes-128-ofb
     * 12 => aes-128-xts
     * 13 => aes-192-cbc
     * 14 => aes-192-ccm
     * 15 => aes-192-cfb
     * 16 => aes-192-cfb1
     * 17 => aes-192-cfb8
     * 18 => aes-192-ctr
     * 20 => aes-192-gcm
     * 21 => aes-192-ocb
     * 22 => aes-192-ofb
     * 23 => aes-256-cbc
     * 24 => aes-256-cbc-hmac-sha1
     * 25 => aes-256-cbc-hmac-sha256
     * 26 => aes-256-ccm
     * 27 => aes-256-cfb
     * 28 => aes-256-cfb1
     * 29 => aes-256-cfb8
     * 30 => aes-256-ctr
     * 32 => aes-256-gcm
     * 33 => aes-256-ocb
     * 34 => aes-256-ofb
     * 35 => aes-256-xts
     * 36 => aria-128-cbc
     * 37 => aria-128-ccm
     * 38 => aria-128-cfb
     * 39 => aria-128-cfb1
     * 40 => aria-128-cfb8
     * 41 => aria-128-ctr
     * 43 => aria-128-gcm
     * 44 => aria-128-ofb
     * 45 => aria-192-cbc
     * 46 => aria-192-ccm
     * 47 => aria-192-cfb
     * 48 => aria-192-cfb1
     * 49 => aria-192-cfb8
     * 50 => aria-192-ctr
     * 52 => aria-192-gcm
     * 53 => aria-192-ofb
     * 54 => aria-256-cbc
     * 55 => aria-256-ccm
     * 56 => aria-256-cfb
     * 57 => aria-256-cfb1
     * 58 => aria-256-cfb8
     * 59 => aria-256-ctr
     * 61 => aria-256-gcm
     * 62 => aria-256-ofb
     * 63 => bf-cbc
     * 64 => bf-cfb
     * 66 => bf-ofb
     * 67 => camellia-128-cbc
     * 68 => camellia-128-cfb
     * 69 => camellia-128-cfb1
     * 70 => camellia-128-cfb8
     * 71 => camellia-128-ctr
     * 73 => camellia-128-ofb
     * 74 => camellia-192-cbc
     * 75 => camellia-192-cfb
     * 76 => camellia-192-cfb1
     * 77 => camellia-192-cfb8
     * 78 => camellia-192-ctr
     * 80 => camellia-192-ofb
     * 81 => camellia-256-cbc
     * 82 => camellia-256-cfb
     * 83 => camellia-256-cfb1
     * 84 => camellia-256-cfb8
     * 85 => camellia-256-ctr
     * 87 => camellia-256-ofb
     * 88 => cast5-cbc
     * 89 => cast5-cfb
     * 91 => cast5-ofb
     * 92 => chacha20
     * 93 => chacha20-poly1305
     * 111 => id-aes128-CCM
     * 112 => id-aes128-GCM
     * 113 => id-aes128-wrap
     * 114 => id-aes128-wrap-pad
     * 115 => id-aes192-CCM
     * 116 => id-aes192-GCM
     * 117 => id-aes192-wrap
     * 118 => id-aes192-wrap-pad
     * 119 => id-aes256-CCM
     * 120 => id-aes256-GCM
     * 121 => id-aes256-wrap
     * 122 => id-aes256-wrap-pad
     * 124 => idea-cbc
     * 125 => idea-cfb
     * 127 => idea-ofb
     * 137 => seed-cbc
     * 138 => seed-cfb
     * 140 => seed-ofb
     * 141 => sm4-cbc
     * 142 => sm4-cfb
     * 143 => sm4-ctr
     * 145 => sm4-ofb
     */
    static function encode($data, $algo = 0)
    {
        return openssl_encrypt($data, gettype($algo) == 'integer' ? self::ALGOS[$algo] : $algo, self::KEY, 0, self::IV);
    }
    static function decode($data, $algo = 0)
    {
        return openssl_decrypt($data, gettype($algo) == 'integer' ? self::ALGOS[$algo] : $algo, self::KEY, 0, self::IV);
    }
}
