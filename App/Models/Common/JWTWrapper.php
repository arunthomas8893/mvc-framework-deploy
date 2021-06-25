<?php

namespace App\Models\Common;

use \App\Models\Common\Values;
use \Firebase\JWT\JWT;

class JWTWrapper {

    private $key = "-----BEGIN PUBLIC KEY-----
MIICITANBgkqhkiG9w0BAQEFAAOCAg4AMIICCQKCAgB0XKsniRCTEeoYM93e33NV
HUpp/hvM/xBiz+uVPslloSEBCgLb+mgCotDotOo9eDqPsh7jnWpNJ6p5BdPwzndx
lK4ALjELyr+ErWa1A+kKmRNDEGHx38yvuottX0xoJtX1M1WsJVIuS95Debm8liaL
9sr0sYGzdYBASIBFHYsGqCCCcE0xyWKqMABuS1O44e898V+7e+tTlU2XilBNUnw4
D+n1S4ZzGO9i7emVfa77MrHHjF7kF1LTKAHCo6D33q7ySb/uJU6Gg1rGWjNAV1lz
SkfMPjQ+dp1I0mbRvdWXZyUgQsmEBwUS9A8E5WX5PcCEVs0Lrshmeq2Px4vDZiEl
lgCFDXci5d7ZxTqvy4JV89H+DyG9E6kg1mhsDcSTKLJ6A/nxY118ePY7iqjYv5Mc
Qch2mrhQbsLyn18j5eUoy/X8mOKriILj6hFUw4kHxYyAvGONR+dc3xQLgeTahnFE
TKxgdeNs1ud/wvhGFOyPVp/mfBAoRmT8OJCrF3LzbAVOVJMexpcGUnqzgXYA+e6g
HwOwcX9QSPM0oS5dYt+TqLTP7D8FawlC2DgztdOXLDcLsdt86/+imKGVIxR3oUS1
b2p/pHNsAIv7Kw1wEbvGFt8/1q5VZe7DaKT4/X9H7CDlmCuEHeSEdXo4zd6gim+C
Hz3pGJu2qEGk1IhpTx1eeQIDAQAB
-----END PUBLIC KEY-----";

    public function generateToken(array $user) {
        $token = array(
            "iat" => time(),
            "exp" => time() + (60 * 60 * 24 * 10),
            "name" => $user['name'],
            "mobile" => $user['mobile'],
            "id" => $user['id'],
            "email" => $user['email']
        );

        $jwt = JWT::encode($token, $this->key);
        return $jwt;
    }

    public function generateAdminToken(array $user) {
        $token = array(
            "iat" => time(),
            "exp" => time() + (60 * 60 * 24 * 10),
            "type" => $user['type'],
            "email" => $user['email'],
            "privilages" => $user['privilages'],
            "sections" => $user['sections']
        );

        $jwt = JWT::encode($token, $this->key);
        return $jwt;
    }

    private function getToken() {
        if (isset($_COOKIE['token'])) {
            return $_COOKIE['token'];
        } else {
            //header('Location: /authentication/login');
            throw new \Exception("", Values::$resCode_notAuthenticated);
        }
    }

    private function getAdminToken() {
        if (isset($_COOKIE['admin-token'])) {
            return $_COOKIE['admin-token'];
        } else {
            //header('Location: /authentication/login');
            throw new \Exception("", Values::$resCode_notAuthenticated);
        }
    }

    public function authorizeUser() {
        try {
            JWT::decode($this->getToken(), $this->key, array('HS256'));
            return true;
        } catch (\Throwable $e) {
            throw new \Exception('Incorrect, Invalid or Non existant token', Values::$resCode_notAuthenticated);
        }
    }

    public function authorizeAdmin() {
        try {
            JWT::decode($this->getAdminToken(), $this->key, array('HS256'));
            return true;
        } catch (\Throwable $e) {
            return false;
            //throw new \Exception('Incorrect, Invalid or Non existant token', Values::$resCode_notAuthenticated);
        }
    }

    public function checkUser() {
        try {
            JWT::decode($this->getToken(), $this->key, array('HS256'));
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getPayload() {
        if ($this->authorizeUser()) {
            return \json_decode(json_encode(JWT::decode($this->getToken(), $this->key, array('HS256'))), true);
        } else {
            throw new \Exception('Incorrect, Invalid or Non existant token', Values::$resCode_notAuthenticated);
        }
    }

    public function getPayloadIfUserUserAuthenticated() {
        try {
            JWT::decode($this->getToken(), $this->key, array('HS256'));
            return \json_decode(json_encode(JWT::decode($this->getToken(false), $this->key, array('HS256'))), true);
        } catch (\Throwable $e) {
            return false;
        }
    }

}
